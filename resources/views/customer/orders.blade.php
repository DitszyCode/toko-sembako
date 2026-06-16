@extends('layouts.customer')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-400 via-green-500 to-green-600 py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="glass-card mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Riwayat Pesanan</h1>
                    <p class="text-green-100 mt-1">Lacak semua pesanan Anda</p>
                </div>
                <a href="{{ route('home') }}" class="glass-btn px-4 py-2 bg-green-600/50 hover:bg-green-600 text-white rounded-lg transition-all">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-4" x-data="{ expandedOrder: null }">
            @forelse ($orders as $order)
                <div class="glass-card">
                    <!-- Order Header -->
                    <div class="flex flex-wrap items-center justify-between gap-4 cursor-pointer"
                        @click="expandedOrder = expandedOrder === {{ $order->id }} ? null : {{ $order->id }}">
                        <div class="flex-1 min-w-[200px]">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-green-600/30 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-semibold">#{{ $order->order_number }}</p>
                                    <p class="text-green-200/60 text-sm">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <!-- Status Badge -->
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-500/30 text-yellow-200 border-yellow-400/30',
                                    'processing' => 'bg-blue-500/30 text-blue-200 border-blue-400/30',
                                    'shipped' => 'bg-purple-500/30 text-purple-200 border-purple-400/30',
                                    'delivered' => 'bg-green-500/30 text-green-200 border-green-400/30',
                                    'cancelled' => 'bg-red-500/30 text-red-200 border-red-400/30',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'processing' => 'Diproses',
                                    'shipped' => 'Dikirim',
                                    'delivered' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium border {{ $statusClasses[$order->status] ?? 'bg-gray-500/30' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>

                            <div class="text-right hidden sm:block">
                                <p class="text-green-200/60 text-sm">Total</p>
                                <p class="text-white font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>

                            <svg class="w-5 h-5 text-white transition-transform duration-300"
                                :class="{ 'rotate-180': expandedOrder === {{ $order->id }} }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Expanded Details -->
                    <div x-show="expandedOrder === {{ $order->id }}"
                        x-collapse
                        x-cloak
                        class="mt-6 pt-6 border-t border-white/10">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Order Items -->
                            <div>
                                <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Item Pesanan
                                </h3>
                                <div class="space-y-3">
                                    @foreach ($order->items as $item)
                                        <div class="glass bg-green-400/10 p-3 rounded-lg flex items-center gap-3">
                                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/50' }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-12 h-12 rounded-lg object-cover">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-white font-medium truncate">{{ $item->product->name }}</p>
                                                <p class="text-green-200/60 text-sm">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="text-white font-semibold whitespace-nowrap">
                                                Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div>
                                <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Ringkasan
                                </h3>
                                <div class="glass bg-green-400/10 p-4 rounded-lg space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-green-200/60">Subtotal</span>
                                        <span class="text-white">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-green-200/60">Ongkos Kirim</span>
                                        <span class="text-white">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                    </div>
                                    @if ($order->discount > 0)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-green-200/60">Diskon</span>
                                            <span class="text-green-300">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="border-t border-white/10 pt-3 flex justify-between">
                                        <span class="text-white font-semibold">Total</span>
                                        <span class="text-white font-bold text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <h3 class="text-white font-semibold mt-4 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Alamat Pengiriman
                                </h3>
                                <div class="glass bg-green-400/10 p-4 rounded-lg">
                                    <p class="text-white">{{ $order->shipping_address }}</p>
                                    <p class="text-green-200/60 text-sm mt-1">{{ $order->shipping_phone }}</p>
                                </div>

                                @if ($order->payment_method)
                                    <h3 class="text-white font-semibold mt-4 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        Metode Pembayaran
                                    </h3>
                                    <div class="glass bg-green-400/10 p-4 rounded-lg">
                                        <p class="text-white">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                                    </div>
                                @endif

                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                    class="glass-btn mt-4 w-full py-2 bg-green-600/50 hover:bg-green-600 text-white rounded-lg transition-all text-center block">
                                    Lihat Detail Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-card text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-green-200/40 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-white text-lg font-semibold mb-2">Belum Ada Pesanan</h3>
                    <p class="text-green-200/60 mb-6">Mulai belanja untuk melihat riwayat pesanan Anda</p>
                    <a href="{{ route('products') }}" class="glass-btn px-6 py-2 bg-green-600/50 hover:bg-green-600 text-white rounded-lg transition-all inline-block">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="glass-card px-4 py-3">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
