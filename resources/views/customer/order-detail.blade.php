@extends('layouts.customer')

@section('title', 'Detail Pesanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-400 via-green-500 to-green-600 py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('orders') }}" class="text-green-200/60 hover:text-white transition text-sm mb-2 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Pesanan
                </a>
                <h1 class="text-3xl font-bold text-white">Detail Pesanan</h1>
                <p class="text-green-100 mt-1">#{{ $order->order_number }}</p>
            </div>
            @php
                $statusClasses = [
                    'pending' => 'bg-yellow-500/30 text-yellow-200 border-yellow-400/30',
                    'processing' => 'bg-blue-500/30 text-blue-200 border-blue-400/30',
                    'shipped' => 'bg-purple-500/30 text-purple-200 border-purple-400/30',
                    'delivered' => 'bg-green-500/30 text-green-200 border-green-400/30',
                    'cancelled' => 'bg-red-500/30 text-red-200 border-red-400/30',
                ];
                $statusLabels = [
                    'pending' => 'Menunggu Pembayaran',
                    'processing' => 'Sedang Diproses',
                    'shipped' => 'Sedang Dikirim',
                    'delivered' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp
            <span class="px-4 py-2 rounded-xl text-sm font-medium border {{ $statusClasses[$order->status] ?? 'bg-gray-500/30' }}">
                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status Timeline -->
                <div class="glass-card" x-data="{
                    currentStep: {{ $order->status === 'pending' ? 1 : ($order->status === 'processing' ? 2 : ($order->status === 'shipped' ? 3 : ($order->status === 'delivered' ? 4 : 0))) }},
                    steps: [
                        { label: 'Pesanan Dibuat', date: '{{ $order->created_at->format('d M Y, H:i') }}' },
                        { label: 'Menunggu Pembayaran', date: '{{ $order->status === 'pending' ? now()->format('d M Y, H:i') : '-' }}' },
                        { label: 'Sedang Diproses', date: '{{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? now()->format('d M Y, H:i') : '-' }}' },
                        { label: 'Sedang Dikirim', date: '{{ in_array($order->status, ['shipped', 'delivered']) ? now()->format('d M Y, H:i') : '-' }}' },
                        { label: 'Selesai', date: '{{ $order->status === 'delivered' ? now()->format('d M Y, H:i') : '-' }}' }
                    ]
                }">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l6 6m-6-6l6-6"></path>
                        </svg>
                        Status Pesanan
                    </h2>

                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-white/10"></div>
                        <div class="absolute left-4 top-0 w-0.5 bg-green-500"
                            :style="'height: ' + ((currentStep - 1) * 25) + '%'"></div>

                        <template x-for="(step, index) in steps" :key="index">
                            <div class="relative flex items-start gap-6 pb-6 last:pb-0">
                                <div class="relative z-10 w-8 h-8 rounded-full flex items-center justify-center"
                                    :class="index < currentStep ? 'bg-green-500' : 'bg-white/20'">
                                    <svg x-show="index < currentStep" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span x-show="index >= currentStep" class="text-white/40 text-sm" x-text="index + 1"></span>
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-white font-medium" :class="index >= currentStep ? 'text-white/60' : ''" x-text="step.label"></p>
                                    <p class="text-green-200/60 text-sm" x-text="step.date"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="glass-card">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Item Pesanan
                    </h2>

                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="glass bg-green-400/10 p-4 rounded-xl flex items-center gap-4">
                                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/60' }}"
                                    alt="{{ $item->product->name }}"
                                    class="w-16 h-16 rounded-lg object-cover bg-green-600/20">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-medium">{{ $item->product->name }}</h4>
                                    <p class="text-green-200/60 text-sm">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="text-green-400 font-semibold whitespace-nowrap">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="glass-card">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Informasi Pengiriman
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="glass bg-green-400/10 p-4 rounded-xl">
                            <p class="text-green-200/60 text-sm mb-2">Alamat Pengiriman</p>
                            <p class="text-white font-medium">{{ $order->shipping_name }}</p>
                            <p class="text-white/80 text-sm mt-1">{{ $order->shipping_address }}</p>
                            <p class="text-green-200/60 text-sm mt-1">{{ $order->shipping_phone }}</p>
                        </div>
                        <div class="glass bg-green-400/10 p-4 rounded-xl">
                            <p class="text-green-200/60 text-sm mb-2">Metode Pengiriman</p>
                            <p class="text-white font-medium">{{ $order->shipping_method ?? 'JNE Express' }}</p>
                            <p class="text-white/80 text-sm mt-1">
                                Estimasi {{ $order->shipping_estimation ?? '2-3 hari kerja' }}
                            </p>
                            @if ($order->tracking_number)
                                <p class="text-green-400 text-sm mt-1">Resi: {{ $order->tracking_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                @if ($order->payment_method)
                    <div class="glass-card">
                        <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Informasi Pembayaran
                        </h2>

                        <div class="glass bg-green-400/10 p-4 rounded-xl">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-lg bg-green-600/30 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                                    <p class="text-green-200/60 text-sm">a.n. Toko Sembako</p>
                                </div>
                            </div>
                            @if ($order->payment_number)
                                <div class="bg-green-600/20 p-4 rounded-lg">
                                    <p class="text-green-200/60 text-sm mb-2">Nomor Rekening</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-white font-mono text-lg">{{ $order->payment_number }}</p>
                                        <button @click="navigator.clipboard.writeText('{{ $order->payment_number }}')"
                                            class="text-green-400 hover:text-green-300 transition text-sm flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div>
                <div class="glass-card sticky top-24">
                    <h3 class="text-xl font-semibold text-white mb-6">Ringkasan Pembayaran</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-green-200/80 text-sm">
                            <span>Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex justify-between text-green-400 text-sm">
                                <span>Diskon</span>
                                <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-green-200/80 text-sm">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-white/10 pt-3 flex justify-between">
                            <span class="text-white font-semibold">Total</span>
                            <span class="text-green-400 font-bold text-2xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if ($order->status === 'pending')
                        <div class="mb-6">
                            <p class="text-green-200/60 text-sm mb-2">Batas Pembayaran</p>
                            <div class="glass bg-green-400/10 p-4 rounded-xl text-center" x-data="{ countdown: '{{ $order->payment_deadline->format('Y-m-d H:i:s') }}' }">
                                <p class="text-red-400 font-bold text-xl" x-text="countdown">23:45:30</p>
                                <p class="text-green-200/60 text-sm">{{ $order->payment_deadline->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @if ($order->status === 'pending')
                            <button class="w-full glass-btn py-4 rounded-xl text-white font-semibold text-center">
                                Bayar Sekarang
                            </button>
                        @endif
                        <button class="w-full glass py-3 rounded-xl text-white text-sm hover:bg-white/20 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Butuh Bantuan?
                        </button>
                    </div>

                    <div class="mt-6 glass bg-green-400/10 p-4 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="text-white text-sm font-medium">Transaksi Aman</span>
                        </div>
                        <p class="text-green-200/60 text-xs">Pembayaran Anda dilindungi oleh sistem keamanan kami</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
