<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

        // Dynamic stats from database
        $stats = [
            'products' => Cache::remember('total_products', 3600, fn() => Product::count()),
            'customers' => Cache::remember('total_customers', 3600, fn() => \App\Models\User::where('role', 'customer')->count()),
            'rating' => Cache::remember('avg_rating', 3600, fn() => Review::avg('rating') ?? 0),
            'avg_delivery' => '< 24 jam',
        ];

        // Popular searches from product names (keywords)
        $popularSearches = Cache::remember('popular_searches', 3600, function() {
            $products = Product::select('name')->limit(10)->get();
            $keywords = [];
            foreach ($products as $product) {
                $words = explode(' ', $product->name);
                foreach ($words as $word) {
                    if (strlen($word) > 3) {
                        $keywords[] = $word;
                    }
                }
            }
            return array_unique(array_slice($keywords, 0, 5));
        });

        // Testimonials from reviews
        $testimonials = Review::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('customer.home', compact(
            'featuredProducts',
            'newProducts',
            'categories',
            'banners',
            'stats',
            'popularSearches',
            'testimonials'
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
