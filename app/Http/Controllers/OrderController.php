<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    /**
     * Display the order history page.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('guest_email', session('guest_email'));
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    /**
     * Display order detail page.
     */
    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->firstOrFail();

        // Check if user has access to this order
        if (Auth::check()) {
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        } else {
            $guestEmail = session('guest_email');
            if ($order->guest_email !== $guestEmail) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        }

        return view('customer.order-detail', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('id', $id)->firstOrFail();

        // Check if user has access to this order
        if (Auth::check()) {
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        } else {
            $guestEmail = session('guest_email');
            if ($order->guest_email !== $guestEmail) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        }

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        try {
            \DB::beginTransaction();

            // Restore product stock
            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $request->get('reason', 'Dibatalkan oleh pelanggan'),
            ]);

            \DB::commit();

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
        }
    }

    /**
     * Reorder (add previous order items to cart).
     */
    public function reorder($id)
    {
        $order = Order::with('items')
            ->where('id', $id)
            ->firstOrFail();

        // Check if user has access to this order
        if (Auth::check()) {
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        } else {
            $guestEmail = session('guest_email');
            if ($order->guest_email !== $guestEmail) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        }

        $addedItems = [];
        $failedItems = [];

        foreach ($order->items as $item) {
            $product = \App\Models\Product::find($item->product_id);

            if (!$product) {
                $failedItems[] = $item->product_name;
                continue;
            }

            if ($product->stock < $item->quantity) {
                $failedItems[] = $item->product_name . ' (stok tidak mencukupi)';
                continue;
            }

            if (Auth::check()) {
                $existingCart = \App\Models\Cart::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();

                if ($existingCart) {
                    $existingCart->update([
                        'quantity' => $existingCart->quantity + $item->quantity,
                    ]);
                } else {
                    \App\Models\Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                    ]);
                }
            } else {
                $cart = session('cart', []);
                $found = false;

                foreach ($cart as $key => $cartItem) {
                    if ($cartItem['product_id'] === $product->id) {
                        $cart[$key]['quantity'] += $item->quantity;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $cart[] = [
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                    ];
                }

                session()->put('cart', $cart);
            }

            $addedItems[] = $item->product_name;
        }

        $message = '';
        if (!empty($addedItems)) {
            $message .= count($addedItems) . ' item(s) ditambahkan ke keranjang. ';
        }
        if (!empty($failedItems)) {
            $message .= count($failedItems) . ' item(s) gagal ditambahkan.';
        }

        return redirect()->route('cart')->with('success', $message);
    }
}
