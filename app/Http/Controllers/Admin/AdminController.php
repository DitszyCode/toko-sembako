<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with statistics and charts.
     */
    public function dashboard()
    {
        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get top selling products
        $topProducts = DB::table('order_items')
            ->select('product_id', 'product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Get monthly sales data for chart
        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
            ->orderBy('month')
            ->get();

        // Prepare chart data
        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $monthData = $monthlySales->firstWhere('month', $i);
            $chartData[] = $monthData ? (float) $monthData->total_revenue : 0;
        }

        // Get orders by status
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get category distribution
        $categoryDistribution = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->products_count,
                ];
            });

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'chartLabels',
            'chartData',
            'ordersByStatus',
            'categoryDistribution'
        ));
    }

    /**
     * Display widgets data for dashboard.
     */
    public function widgets()
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->count();

        $outOfStockProducts = Product::where('stock', 0)->count();

        return response()->json([
            'today_orders' => $todayOrders,
            'today_revenue' => $todayRevenue,
            'low_stock_products' => $lowStockProducts,
            'out_of_stock_products' => $outOfStockProducts,
        ]);
    }

    /**
     * Get real-time notifications for admin.
     */
    public function notifications()
    {
        $notifications = [];
        $now = now();

        // New orders (last 24 hours)
        $newOrders = Order::where('created_at', '>=', $now->copy()->subDay())
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        foreach ($newOrders as $order) {
            $notifications[] = [
                'id' => 'order_' . $order->id,
                'message' => 'Pesanan baru #' . ($order->order_number ?? $order->id) . ' dari ' . ($order->user->name ?? 'Pelanggan'),
                'time' => $order->created_at->diffForHumans(),
                'icon' => 'fas fa-shopping-bag',
                'icon_color' => 'text-green-400',
                'bg_class' => 'bg-green-500/20',
                'url' => route('admin.orders.show', $order),
                'read' => false,
            ];
        }

        // New users (last 24 hours)
        $newUsers = User::where('role', 'customer')
            ->where('created_at', '>=', $now->copy()->subDay())
            ->latest()
            ->limit(3)
            ->get();

        foreach ($newUsers as $user) {
            $notifications[] = [
                'id' => 'user_' . $user->id,
                'message' => 'Pengguna baru: ' . $user->name,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'fas fa-user-plus',
                'icon_color' => 'text-blue-400',
                'bg_class' => 'bg-blue-500/20',
                'url' => route('admin.users'),
                'read' => false,
            ];
        }

        // Low stock products
        $lowStock = Product::where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->limit(3)
            ->get();

        foreach ($lowStock as $product) {
            $notifications[] = [
                'id' => 'stock_' . $product->id,
                'message' => 'Stok rendah: ' . $product->name . ' (' . $product->stock . ' remaining)',
                'time' => 'Baru',
                'icon' => 'fas fa-exclamation-triangle',
                'icon_color' => 'text-yellow-400',
                'bg_class' => 'bg-yellow-500/20',
                'url' => route('admin.products.edit', $product),
                'read' => false,
            ];
        }

        // Out of stock
        $outOfStock = Product::where('stock', 0)->limit(2)->get();
        foreach ($outOfStock as $product) {
            $notifications[] = [
                'id' => 'out_' . $product->id,
                'message' => 'Stok habis: ' . $product->name,
                'time' => 'Baru',
                'icon' => 'fas fa-times-circle',
                'icon_color' => 'text-red-400',
                'bg_class' => 'bg-red-500/20',
                'url' => route('admin.products.edit', $product),
                'read' => false,
            ];
        }

        // Sort by newest first
        usort($notifications, fn($a, $b) => 0);

        return response()->json(array_slice($notifications, 0, 10));
    }
}
