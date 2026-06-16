<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart page.
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

        $subtotal = array_sum(array_column($items, 'subtotal'));
        $shipping = $subtotal >= 500000 ? 0 : 25000;
        $total = $subtotal + $shipping;

        return view('customer.cart', compact('items', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia');
        }

        if (Auth::check()) {
            $existingCart = Cart::where('user_id', Auth::id())
                ->where('product_id', $validated['product_id'])
                ->first();

            if ($existingCart) {
                $newQty = $existingCart->quantity + $validated['quantity'];
                if ($newQty > $product->stock) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi');
                }
                $existingCart->update(['quantity' => $newQty]);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity'],
                ]);
            }
        } else {
            $cart = Session::get('cart', []);
            $found = false;

            foreach ($cart as $key => $item) {
                if ($item['product_id'] === $validated['product_id']) {
                    $newQty = $item['quantity'] + $validated['quantity'];
                    if ($newQty > $product->stock) {
                        return redirect()->back()->with('error', 'Stok tidak mencukupi');
                    }
                    $cart[$key]['quantity'] = $newQty;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cart[] = [
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity'],
                ];
            }

            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    /**
     * Update cart item quantity.
     */
    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia');
        }

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $validated['product_id'])
                ->update(['quantity' => $validated['quantity']]);
        } else {
            $cart = Session::get('cart', []);
            foreach ($cart as $key => $item) {
                if ($item['product_id'] === $validated['product_id']) {
                    $cart[$key]['quantity'] = $validated['quantity'];
                    break;
                }
            }
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Keranjang diperbarui');
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $validated['product_id'])
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            $cart = array_values(array_filter($cart, function ($item) use ($validated) {
                return $item['product_id'] !== $validated['product_id'];
            }));
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Clear all items from cart.
     */
    public function clearCart()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('cart');
        }

        return redirect()->route('cart')->with('success', 'Keranjang dikosongkan');
    }

    /**
     * Get current cart count.
     */
    public function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = Session::get('cart', []);
            return array_sum(array_column($cart, 'quantity'));
        }
    }
}
