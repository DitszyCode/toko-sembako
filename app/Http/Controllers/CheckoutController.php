<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Display the checkout page.
     */
    public function index()
    {
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            $items = $carts->map(function ($cart) {
                $product = $cart->product;
                $discount = $product->discount ?? 0;
                $price = $product->price * (1 - $discount / 100);

                return [
                    'id' => $cart->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->image,
                    'price' => $price,
                    'original_price' => $product->price,
                    'quantity' => $cart->quantity,
                    'stock' => $product->stock,
                    'subtotal' => $price * $cart->quantity,
                ];
            })->toArray();
        } else {
            $sessionCart = Session::get('cart', []);
            $items = [];

            foreach ($sessionCart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $discount = $product->discount ?? 0;
                    $price = $product->price * (1 - $discount / 100);
                    $items[] = [
                        'id' => $product->id,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'price' => $price,
                        'original_price' => $product->price,
                        'quantity' => $item['quantity'],
                        'stock' => $product->stock,
                        'subtotal' => $price * $item['quantity'],
                    ];
                }
            }
        }

        if (empty($items)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = array_sum(array_column($items, 'subtotal'));
        $shipping = $subtotal > 500000 ? 0 : 25000;
        $total = $subtotal + $shipping;

        $user = Auth::check() ? Auth::user() : null;

        // Get Midtrans client key
        $midtransClientKey = $this->midtrans->getClientKey();
        $midtransIsProduction = $this->midtrans->isProduction();

        return view('customer.checkout', compact('items', 'subtotal', 'shipping', 'total', 'user', 'midtransClientKey', 'midtransIsProduction'));
    }

    /**
     * Process the checkout and create order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        // Get cart items
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            $items = $carts->map(function ($cart) {
                $product = $cart->product;
                $discount = $product->discount ?? 0;
                $price = $product->price * (1 - $discount / 100);

                return [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $price,
                    'quantity' => $cart->quantity,
                    'unit' => $product->unit,
                    'subtotal' => $price * $cart->quantity,
                ];
            })->toArray();
        } else {
            $sessionCart = Session::get('cart', []);
            $items = [];

            foreach ($sessionCart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $discount = $product->discount ?? 0;
                    $price = $product->price * (1 - $discount / 100);
                    $items[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $price,
                        'quantity' => $item['quantity'],
                        'unit' => $product->unit,
                        'subtotal' => $price * $item['quantity'],
                    ];
                }
            }
        }

        if (empty($items)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
        }

        // Calculate totals
        $subtotal = array_sum(array_column($items, 'subtotal'));
        $shipping = $subtotal > 500000 ? 0 : 25000;
        $total = $subtotal + $shipping;

        // Generate order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(6));

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::check() ? Auth::id() : null,
                'recipient_name' => $validated['recipient_name'],
                'recipient_phone' => $validated['recipient_phone'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
                'total_amount' => $total,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'product_price' => $item['product_price'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            // Get Midtrans snap token
            try {
                $snapData = $this->midtrans->createTransaction($order, $items);
                $snapToken = $snapData['token'] ?? null;
                $redirectUrl = $snapData['redirect_url'] ?? null;

                // Store snap token in session
                session(['midtrans_snap_token' => $snapToken]);
                session(['midtrans_order_id' => $order->id]);

                return view('customer.checkout-payment', compact('order', 'snapToken', 'redirectUrl', 'items'));
            } catch (\Exception $e) {
                // If Midtrans fails, show error but keep order
                return redirect()->back()
                    ->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage())
                    ->withInput();
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Handle Midtrans payment notification (webhook)
     */
    public function notification(Request $request)
    {
        $notification = $request->all();

        if (empty($notification)) {
            return response()->json(['message' => 'No notification'], 400);
        }

        $result = $this->midtrans->handleNotification($notification);

        return response()->json($result);
    }

    /**
     * Handle payment finish from Midtrans
     */
    public function finish(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update order status based on transaction result
        if ($request->has('status_id') && $request->status_id == '200') {
            $order->payment_status = 'paid';
            $order->status = 'processing';
            $order->save();

            // Clear cart after successful payment
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Session::forget('cart');
            }

            // Update product stock
            $orderItems = OrderItem::where('order_id', $order->id)->get();
            foreach ($orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
        }

        return redirect()->route('orders.show', $order->id)
            ->with('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
    }

    /**
     * Show payment page for existing order
     */
    public function payment($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        // Check if user owns this order
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Get order items for Midtrans
        $items = $order->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'product_price' => $item->product_price,
                'quantity' => $item->quantity,
                'unit' => $item->unit,
                'subtotal' => $item->subtotal,
            ];
        })->toArray();

        // Get Midtrans snap token
        try {
            $snapData = $this->midtrans->createTransaction($order, $items);
            $snapToken = $snapData['token'] ?? null;
            $redirectUrl = $snapData['redirect_url'] ?? null;
        } catch (\Exception $e) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Gagal memuat halaman pembayaran: ' . $e->getMessage());
        }

        $midtransClientKey = $this->midtrans->getClientKey();

        return view('customer.checkout-payment', compact('order', 'snapToken', 'redirectUrl', 'items', 'midtransClientKey'));
    }

    /**
     * Handle payment error
     */
    public function error(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        return redirect()->route('orders.show', $order->id)
            ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }

    /**
     * Handle payment unfinish
     */
    public function unfinish(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        return redirect()->route('orders.show', $order->id)
            ->with('warning', 'Pembayaran belum selesai. Silakan selesaikan pembayaran.');
    }
}
