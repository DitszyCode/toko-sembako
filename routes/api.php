<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    // Admin notifications (real-time)
    Route::get('/admin/notifications', function () {
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
                'url' => route('admin.orders.show', $order, true),
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
                'url' => route('admin.users', [], true),
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
                'message' => 'Stok rendah: ' . $product->name . ' (' . $product->stock . ')',
                'time' => 'Baru',
                'icon' => 'fas fa-exclamation-triangle',
                'icon_color' => 'text-yellow-400',
                'bg_class' => 'bg-yellow-500/20',
                'url' => route('admin.products.edit', $product, true),
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
                'url' => route('admin.products.edit', $product, true),
                'read' => false,
            ];
        }

        return response()->json(array_slice($notifications, 0, 10));
    })->middleware(['auth', 'role:admin']);
});
