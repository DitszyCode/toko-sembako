<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartManager extends Component
{
    public $items = [];
    public $total = 0;
    public $subtotal = 0;
    public $shipping = 0;
    public $isLoading = false;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->isLoading = true;

        if (Auth::check()) {
            $this->loadDatabaseCart();
        } else {
            $this->loadSessionCart();
        }

        $this->isLoading = false;
    }

    protected function loadDatabaseCart()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $this->items = $carts->map(function ($cart) {
            $product = $cart->product;
            if (!$product) return null;

            return [
                'id' => $cart->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => $product->price,
                'original_price' => $product->price,
                'quantity' => $cart->quantity,
                'stock' => $product->stock,
                'subtotal' => $product->price * $cart->quantity,
            ];
        })->filter()->values()->toArray();

        $this->calculateTotals();
    }

    protected function loadSessionCart()
    {
        $cart = Session::get('cart', []);
        $this->items = [];

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $this->items[] = [
                    'id' => $item['product_id'],
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->image,
                    'price' => $product->price,
                    'original_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'stock' => $product->stock,
                    'subtotal' => $product->price * $item['quantity'],
                ];
            }
        }

        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        $this->subtotal = collect($this->items)->sum('subtotal');
        $this->shipping = $this->subtotal >= 100000 ? 0 : 15000;
        $this->total = $this->subtotal + $this->shipping;
    }

    public function removeFromCart($itemId)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $itemId)
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            $cart = array_values(array_filter($cart, fn($item) => $item['product_id'] != $itemId));
            Session::put('cart', $cart);
        }

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($itemId, $quantity)
    {
        $quantity = max(1, (int) $quantity);

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $itemId)
                ->first();

            if ($cart) {
                $product = Product::find($itemId);
                $cart->update(['quantity' => min($quantity, $product->stock)]);
            }
        } else {
            $cart = Session::get('cart', []);
            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $itemId) {
                    $product = Product::find($itemId);
                    $cart[$key]['quantity'] = min($quantity, $product->stock);
                    break;
                }
            }
            Session::put('cart', $cart);
        }

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('cart');
        }

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function getItemCountProperty()
    {
        return collect($this->items)->sum('quantity');
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedShippingAttribute()
    {
        return $this->shipping == 0 ? 'Gratis' : 'Rp ' . number_format($this->shipping, 0, ',', '.');
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.cart-manager');
    }
}
