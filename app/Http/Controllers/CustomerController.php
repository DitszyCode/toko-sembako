<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    /**
     * Display the products catalog with filters.
     */
    public function products(Request $request)
    {
        $query = Product::with('category');

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock filter
        if ($request->has('in_stock') && $request->in_stock) {
            $query->where('stock', '>', 0);
        }

        // Featured filter
        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Cache::remember('categories_for_filter', 3600, function () {
            return Category::withCount('products')->get();
        });

        $selectedCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('customer.products', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Display product detail page.
     */
    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category'])
            ->firstOrFail();

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }

    /**
     * Display categories listing page.
     */
    public function categories()
    {
        $categories = Category::withCount('products')
            ->with(['products' => function ($query) {
                $query->where('stock', '>', 0)
                    ->limit(4);
            }])
            ->orderBy('name')
            ->get();

        // Get unique brands from products
        $brands = Product::whereNotNull('brand')
            ->where('brand', '!=', '')
            ->distinct()
            ->pluck('brand')
            ->filter()
            ->take(12)
            ->values();

        return view('customer.categories', compact('categories', 'brands'));
    }

    /**
     * Display products by category.
     */
    public function categoryProducts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::withCount('products')->get();

        return view('customer.products', compact('products', 'categories', 'category'));
    }
}
