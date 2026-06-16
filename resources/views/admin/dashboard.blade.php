@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .stat-card { transition: transform 0.2s, box-shadow 0.2s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }
    .trend-up { color: #4ade80; }
    .trend-down { color: #f87171; }
    .table-row:hover { background: rgba(255,255,255,0.03); }
    .chart-container { position: relative; height: 280px; }
    .chart-container-sm { position: relative; height: 200px; }
    .badge-pending { background: rgba(251,191,36,0.15); color: #fbbf24; border: 1px solid rgba(251,191,36,0.3); }
    .badge-processing { background: rgba(59,130,246,0.15); color: #3b82f6; border: 1px solid rgba(59,130,246,0.3); }
    .badge-shipped { background: rgba(168,85,247,0.15); color: #a855f7; border: 1px solid rgba(168,85,247,0.3); }
    .badge-delivered { background: rgba(34,197,94,0.15); color: #22c55e; border: 1px solid rgba(34,197,94,0.3); }
    .badge-cancelled { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); }
    .low-stock-alert { animation: pulse-red 2s infinite; }
    @keyframes pulse-red { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400 mt-1">Selamat datang kembali! Berikut ringkasan toko Anda.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="glass px-4 py-2 rounded-xl text-gray-300 text-sm">
            <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
            {{ now()->format('d F Y') }}
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    {{-- Total Revenue --}}
    <div class="stat-card bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-5">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-400 text-lg"></i>
            </div>
            @if(($stats['revenue_growth'] ?? 0) != 0)
                <span class="trend-up text-xs font-semibold flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i> {{ abs($stats['revenue_growth']) }}%
                </span>
            @endif
        </div>
        <p class="text-gray-400 text-sm mt-4 mb-1">Total Pendapatan</p>
        <p class="text-2xl font-bold text-white">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
        <div class="mt-3 h-1 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-green-500 rounded-full" style="width: {{ min(($stats['total_revenue'] / ($stats['revenue_target'] ?? 10000000)) * 100, 100) }}%"></div>
        </div>
    </div>

    {{-- Total Orders --}}
    <div class="stat-card bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-5">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-shopping-bag text-blue-400 text-lg"></i>
            </div>
            @if(($stats['orders_growth'] ?? 0) != 0)
                <span class="trend-up text-xs font-semibold flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i> {{ abs($stats['orders_growth']) }}%
                </span>
            @endif
        </div>
        <p class="text-gray-400 text-sm mt-4 mb-1">Total Pesanan</p>
        <p class="text-2xl font-bold text-white">{{ $stats['total_orders'] ?? 0 }}</p>
        <div class="mt-3 h-1 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 rounded-full" style="width: {{ min(($stats['total_orders'] / ($stats['orders_target'] ?? 100)) * 100, 100) }}%"></div>
        </div>
    </div>

    {{-- Pending Orders --}}
    <div class="stat-card bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-5">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-yellow-400 text-lg"></i>
            </div>
            @if(($stats['pending_orders'] ?? 0) > 0)
                <span class="low-stock-alert text-xs font-semibold flex items-center gap-1 text-red-400">
                    <i class="fas fa-exclamation-circle"></i> Perlu diproses
                </span>
            @endif
        </div>
        <p class="text-gray-400 text-sm mt-4 mb-1">Pesanan Pending</p>
        <p class="text-2xl font-bold text-white">{{ $stats['pending_orders'] ?? 0 }}</p>
        <div class="mt-3 h-1 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-yellow-500 rounded-full" style="width: {{ min(($stats['pending_orders'] ?? 0) * 10, 100) }}%"></div>
        </div>
    </div>

    {{-- Total Products --}}
    <div class="stat-card bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-5">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-box text-purple-400 text-lg"></i>
            </div>
            <span class="text-xs text-gray-400">Produk aktif</span>
        </div>
        <p class="text-gray-400 text-sm mt-4 mb-1">Total Produk</p>
        <p class="text-2xl font-bold text-white">{{ $stats['total_products'] ?? 0 }}</p>
        <div class="mt-3 h-1 bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-purple-500 rounded-full" style="width: {{ min(($stats['total_products'] / ($stats['products_target'] ?? 100)) * 100, 100) }}%"></div>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    {{-- Sales Chart --}}
    <div class="lg:col-span-2 bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-white">Grafik Penjualan {{ date('Y') }}</h2>
                <p class="text-gray-400 text-sm mt-1">Pendapatan per bulan</p>
            </div>
            <div class="flex gap-2">
                <button onclick="updateChart('line')" id="btn-line" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30 transition hover:bg-green-500/30">
                    <i class="fas fa-chart-line mr-1"></i> Line
                </button>
                <button onclick="updateChart('bar')" id="btn-bar" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-700/50 text-gray-400 border border-gray-600/30 transition hover:bg-gray-700">
                    <i class="fas fa-chart-bar mr-1"></i> Bar
                </button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- Orders by Status --}}
    <div class="bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-1">Status Pesanan</h2>
        <p class="text-gray-400 text-sm mb-6">Distribusi berdasarkan status</p>
        <div class="chart-container-sm">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="mt-4 space-y-2">
            @php
                $statusColors = [
                    'pending' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-400', 'label' => 'Pending'],
                    'processing' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-400', 'label' => 'Diproses'],
                    'shipped' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-400', 'label' => 'Dikirim'],
                    'delivered' => ['bg' => 'bg-green-500', 'text' => 'text-green-400', 'label' => 'Selesai'],
                    'cancelled' => ['bg' => 'bg-red-500', 'text' => 'text-red-400', 'label' => 'Dibatalkan'],
                ];
            @endphp
            @foreach($ordersByStatus ?? [] as $status => $count)
                @if(isset($statusColors[$status]))
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full {{ $statusColors[$status]['bg'] }}"></div>
                            <span class="text-gray-300 text-sm">{{ $statusColors[$status]['label'] }}</span>
                        </div>
                        <span class="text-white font-semibold text-sm">{{ $count }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Top Selling Products --}}
    <div class="bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-white">Produk Terlaris</h2>
                <p class="text-gray-400 text-sm mt-1">Berdasarkan jumlah penjualan</p>
            </div>
            <a href="{{ route('admin.products') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($topProducts ?? [] as $i => $product)
                <div class="flex items-center gap-4 p-3 bg-gray-700/20 rounded-xl hover:bg-gray-700/40 transition">
                    <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                        <span class="text-green-400 font-bold text-sm">{{ $i + 1 }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-medium text-sm truncate">{{ $product->product_name ?? 'Produk' }}</p>
                        <div class="mt-2 h-2 bg-gray-600 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 rounded-full" style="width: {{ $product->total_sold > 0 ? min(($product->total_sold / ($topProducts->max('total_sold') ?: 1)) * 100, 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-green-400 font-bold text-sm">{{ $product->total_sold }}</p>
                        <p class="text-gray-400 text-xs">terjual</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-box-open text-3xl mb-2 opacity-30"></i>
                    <p class="text-sm">Belum ada data penjualan</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Category Distribution --}}
    <div class="bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-white">Distribusi Kategori</h2>
                <p class="text-gray-400 text-sm mt-1">Jumlah produk per kategori</p>
            </div>
            <a href="{{ route('admin.categories') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                Kelola <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="chart-container-sm">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-2">
            @php $catColors = ['from-green-400 to-emerald-500', 'from-blue-400 to-cyan-500', 'from-purple-400 to-pink-500', 'from-yellow-400 to-orange-500', 'from-red-400 to-rose-500']; @endphp
            @foreach($categoryDistribution ?? [] as $i => $cat)
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-gradient-to-r {{ $catColors[$i % count($catColors)] }}"></div>
                    <span class="text-gray-300 text-xs truncate">{{ $cat['name'] }}</span>
                    <span class="text-gray-500 text-xs ml-auto">{{ $cat['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Orders & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2 bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-white">Pesanan Terbaru</h2>
                <p class="text-gray-400 text-sm mt-1">5 pesanan terakhir</p>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-gray-400 text-xs uppercase tracking-wider border-b border-gray-700">
                        <th class="pb-3">Order</th>
                        <th class="pb-3">Pelanggan</th>
                        <th class="pb-3">Items</th>
                        <th class="pb-3">Total</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Tanggal</th>
                        <th class="pb-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($recentOrders ?? [] as $order)
                        <tr class="table-row border-b border-gray-700/30">
                            <td class="py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-green-400 hover:text-green-300 font-medium">
                                    #{{ $order->order_number ?? $order->id }}
                                </a>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                        <span class="text-green-400 text-xs font-bold">{{ substr($order->user->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <span class="text-gray-200">{{ $order->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-gray-400">
                                {{ $order->items->count() ?? $order->orderItems->count() ?? '-' }}
                            </td>
                            <td class="py-3 text-green-400 font-semibold">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3">
                                @php
                                    $statusBadge = [
                                        'pending' => 'badge-pending',
                                        'processing' => 'badge-processing',
                                        'shipped' => 'badge-shipped',
                                        'delivered' => 'badge-delivered',
                                        'cancelled' => 'badge-cancelled',
                                    ];
                                    $statusLabel = [
                                        'pending' => 'Pending',
                                        'processing' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusBadge[$order->status] ?? 'badge-pending' }}">
                                    {{ $statusLabel[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="p-2 text-yellow-400 hover:bg-yellow-500/10 rounded-lg transition" title="Proses">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-30"></i>
                                <p class="text-sm">Belum ada pesanan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Stats & Info --}}
    <div class="space-y-6">
        {{-- Quick Stats --}}
        <div class="bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-white mb-5">Statistik</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-400"></i>
                        </div>
                        <span class="text-gray-300 text-sm">Total Pelanggan</span>
                    </div>
                    <span class="text-xl font-bold text-white">{{ $stats['total_customers'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tags text-green-400"></i>
                        </div>
                        <span class="text-gray-300 text-sm">Total Kategori</span>
                    </div>
                    <span class="text-xl font-bold text-white">{{ $stats['total_categories'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <span class="text-gray-300 text-sm">Produk Unggulan</span>
                    </div>
                    <span class="text-xl font-bold text-white">{{ \App\Models\Product::where('is_featured', true)->count() }}</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-700/20 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes-stacked text-red-400"></i>
                        </div>
                        <span class="text-gray-300 text-sm">Stok Menipis</span>
                    </div>
                    <span class="text-xl font-bold text-red-400">{{ \App\Models\Product::where('stock', '<', 10)->where('stock', '>', 0)->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-gray-800/60 backdrop-blur-md border border-gray-700/50 rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-white mb-5">Aksi Cepat</h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition text-center">
                    <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-green-400"></i>
                    </div>
                    <span class="text-gray-300 text-xs">Tambah Produk</span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition text-center">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-folder-plus text-blue-400"></i>
                    </div>
                    <span class="text-gray-300 text-xs">Tambah Kategori</span>
                </a>
                <a href="{{ route('admin.banners.create') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition text-center">
                    <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-purple-400"></i>
                    </div>
                    <span class="text-gray-300 text-xs">Tambah Banner</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="flex flex-col items-center gap-2 p-4 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition text-center">
                    <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list-check text-yellow-400"></i>
                    </div>
                    <span class="text-gray-300 text-xs">Kelola Pesanan</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from controller
    const chartLabels = {!! json_encode($chartLabels ?? []) !!};
    const chartData = {!! json_encode($chartData ?? []) !!};
    const ordersByStatus = {!! json_encode($ordersByStatus ?? []) !!};
    const categoryData = {!! json_encode($categoryDistribution->pluck('count', 'name') ?? []) !!};

    // Sales Chart
    let salesChart;
    const salesCtx = document.getElementById('salesChart').getContext('2d');

    function createSalesChart(type = 'line') {
        if (salesChart) salesChart.destroy();

        const gradient = salesCtx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
        gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

        salesChart = new Chart(salesCtx, {
            type: type,
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Penjualan',
                    data: chartData,
                    borderColor: '#22c55e',
                    backgroundColor: type === 'line' ? gradient : 'rgba(34, 197, 94, 0.8)',
                    borderWidth: 2,
                    fill: type === 'line',
                    tension: 0.4,
                    pointBackgroundColor: '#22c55e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#9ca3af',
                        borderColor: 'rgba(34, 197, 94, 0.3)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                                if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'rb';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    createSalesChart('line');

    function updateChart(type) {
        createSalesChart(type);
        document.getElementById('btn-line').className = type === 'line'
            ? 'px-3 py-1.5 rounded-lg text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30 transition hover:bg-green-500/30'
            : 'px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-700/50 text-gray-400 border border-gray-600/30 transition hover:bg-gray-700';
        document.getElementById('btn-bar').className = type === 'bar'
            ? 'px-3 py-1.5 rounded-lg text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30 transition hover:bg-green-500/30'
            : 'px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-700/50 text-gray-400 border border-gray-600/30 transition hover:bg-gray-700';
    }

    // Status Doughnut Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusLabels = Object.keys(ordersByStatus).map(s => {
        const map = { pending: 'Pending', processing: 'Diproses', shipped: 'Dikirim', delivered: 'Selesai', cancelled: 'Dibatalkan' };
        return map[s] || s;
    });
    const statusCounts = Object.values(ordersByStatus);

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusCounts,
                backgroundColor: ['#fbbf24', '#3b82f6', '#a855f7', '#22c55e', '#ef4444'],
                borderColor: '#1f2937',
                borderWidth: 3,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#9ca3af',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                }
            }
        }
    });

    // Category Doughnut Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const catLabels = Object.keys(categoryData);
    const catCounts = Object.values(categoryData);

    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catCounts,
                backgroundColor: ['#22c55e', '#3b82f6', '#a855f7', '#fbbf24', '#ef4444'],
                borderColor: '#1f2937',
                borderWidth: 3,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#9ca3af',
                }
            }
        }
    });
</script>
@endpush
