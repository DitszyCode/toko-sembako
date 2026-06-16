<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products and banners.
     */
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('stock', '>', 0)
            ->with('category')
            ->limit(8)
            ->get();

        $newProducts = Product::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->with('category')
            ->limit(8)
            ->get();

        $categories = Category::withCount('products')
            ->limit(6)
            ->get();

        $banners = Banner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('customer.home', compact(
            'featuredProducts',
            'newProducts',
            'categories',
            'banners'
        ));
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $stats = [
            'products' => Product::count(),
            'customers' => \App\Models\User::where('role', 'customer')->count(),
            'orders' => Order::count(),
            'categories' => Category::count(),
        ];

        return view('customer.about', compact('stats'));
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('customer.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
