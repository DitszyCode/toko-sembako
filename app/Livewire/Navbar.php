<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public $search = '';
    public $cartCount = 0;
    public $showUserDropdown = false;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        if (Auth::check()) {
            $this->cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $sessionCart = session('cart', []);
            $this->cartCount = array_sum(array_column($sessionCart, 'quantity'));
        }
    }

    public function searchProducts()
    {
        if (strlen($this->search) >= 2) {
            return redirect()->route('products', ['search' => $this->search]);
        }
    }

    public function toggleUserDropdown()
    {
        $this->showUserDropdown = !$this->showUserDropdown;
    }

    public function closeUserDropdown()
    {
        $this->showUserDropdown = false;
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('cart');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
