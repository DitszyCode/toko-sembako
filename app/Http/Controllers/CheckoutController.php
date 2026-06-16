<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
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

        return view('customer.checkout', compact('items', 'subtotal', 'shipping', 'total', 'user'));
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

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Session::forget('cart');
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
