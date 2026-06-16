<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ProductCard extends Component
{
    public Product $product;
    public $quantity = 1;

    public function addToCart()
    {
        if (!Auth::check()) {
            $this->addToSessionCart();
            return;
        }

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($existingCart) {
            $existingCart->update([
                'quantity' => $existingCart->quantity + $this->quantity,
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
            ]);
        }

        $this->dispatch('cartUpdated')->to(CartManager::class);
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => "{$this->product->name} ditambahkan ke keranjang",
        ])->to(Toast::class);
    }

    public function addToSessionCart()
    {
        $cart = Session::get('cart', []);
        $found = false;

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $this->product->id) {
                $cart[$key]['quantity'] += $this->quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
            ];
        }

        Session::put('cart', $cart);
        $this->dispatch('cartUpdated')->to(CartManager::class);
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => "{$this->product->name} ditambahkan ke keranjang",
        ])->to(Toast::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->product->price, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}
