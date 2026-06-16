<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Review;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ProductDetail extends Component
{
    public Product $product;
    public $quantity = 1;
    public $selectedImage;
    public $activeTab = 'description';
    public $reviews = [];
    public $averageRating = 0;
    public $reviewCount = 0;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->selectedImage = $product->image;
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('product_id', $this->product->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user_name' => $review->user->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->diffForHumans(),
                ];
            })
            ->toArray();

        $this->reviewCount = count($this->reviews);
        $this->averageRating = $this->reviewCount > 0
            ? round(array_sum(array_column($this->reviews, 'rating')) / $this->reviewCount, 1)
            : 0;
    }

    public function setImage($image)
    {
        $this->selectedImage = $image;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if ($this->quantity > $this->product->stock) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Jumlah melebihi stok yang tersedia',
            ])->to(Toast::class);
            return;
        }

        if (!Auth::check()) {
            $this->addToSessionCart();
            return;
        }

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($existingCart) {
            $newQty = $existingCart->quantity + $this->quantity;
            if ($newQty > $this->product->stock) {
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'Stok tidak mencukupi',
                ])->to(Toast::class);
                return;
            }
            $existingCart->update(['quantity' => $newQty]);
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
            if ($item['product_id'] === $this->product->id) {
                $newQty = $item['quantity'] + $this->quantity;
                if ($newQty > $this->product->stock) {
                    $this->dispatch('showToast', [
                        'type' => 'error',
                        'message' => 'Stok tidak mencukupi',
                    ])->to(Toast::class);
                    return;
                }
                $cart[$key]['quantity'] = $newQty;
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

    public function getDiscountedPriceAttribute()
    {
        $discountedPrice = $this->product->price * (1 - $this->product->discount / 100);
        return 'Rp ' . number_format($discountedPrice, 0, ',', '.');
    }

    public function getHasDiscountAttribute()
    {
        return $this->product->discount > 0;
    }

    public function getDiscountedPriceValueAttribute()
    {
        return $this->product->price * (1 - $this->product->discount / 100);
    }

    public function getStockStatusAttribute()
    {
        if ($this->product->stock <= 0) {
            return ['text' => 'Stok Habis', 'class' => 'text-red-600'];
        } elseif ($this->product->stock <= 10) {
            return ['text' => 'Hanya ' . $this->product->stock . ' tersisa', 'class' => 'text-orange-600'];
        }
        return ['text' => 'Tersedia', 'class' => 'text-green-600'];
    }

    public function getRelatedProductsAttribute()
    {
        return Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
