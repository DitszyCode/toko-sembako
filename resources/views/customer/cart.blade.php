@extends('layouts.customer')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Keranjang Belanja</h1>
            <p class="text-white/70 mt-2">{{ count($items) }} item dalam keranjang</p>
        </div>
        <a href="{{ route('products') }}" class="flex items-center gap-2 text-green-400 hover:text-green-300 transition">
            <i class="fas fa-plus"></i>
            Tambah Produk
        </a>
    </div>

    @if(count($items) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Cart Header -->
                <div class="glass-card rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-white/70 text-sm">{{ count($items) }} item dipilih</span>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-300 transition text-sm">
                                <i class="fas fa-trash mr-1"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Cart Items -->
                @foreach($items as $item)
                    <div class="glass-card rounded-xl p-4">
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-green-700/30 to-emerald-700/30 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-box text-white/50 text-3xl"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <a href="{{ route('product', $item['slug']) }}" class="text-white font-semibold hover:text-green-400 transition">
                                            {{ $item['name'] }}
                                        </a>
                                        <p class="text-green-400 font-bold mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <button type="submit" class="text-white/50 hover:text-red-400 transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-3">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                            <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                            <button type="submit" class="w-8 h-8 rounded-lg glass flex items-center justify-center hover:bg-white/20 transition {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus text-white text-xs"></i>
                                            </button>
                                        </form>
                                        <span class="w-12 text-center text-white">{{ $item['quantity'] }}</span>
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                            <button type="submit" class="w-8 h-8 rounded-lg glass flex items-center justify-center hover:bg-white/20 transition {{ $item['quantity'] >= $item['stock'] ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }}>
                                                <i class="fas fa-plus text-white text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <p class="text-green-400 font-bold text-lg">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div>
                <div class="glass-card rounded-2xl p-6 sticky top-24">
                    <h3 class="text-white text-xl font-semibold mb-6">Ringkasan Belanja</h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-white/80">
                            <span>Subtotal ({{ count($items) }} item)</span>
                            <span class="text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-white/80">
                            <span>Ongkos Kirim</span>
                            <span class="{{ $shipping == 0 ? 'text-green-400' : 'text-white' }}">
                                {{ $shipping == 0 ? 'GRATIS' : 'Rp ' . number_format($shipping, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($subtotal < 500000)
                            <div class="text-sm text-green-400/70">
                                <i class="fas fa-info-circle mr-1"></i> Belanja Rp {{ number_format(500000 - $subtotal, 0, ',', '.') }} lagi untuk gratis ongkir!
                            </div>
                        @endif
                        <div class="border-t border-white/10 pt-4 flex justify-between">
                            <span class="text-white font-semibold">Total</span>
                            <span class="text-green-400 font-bold text-2xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="block w-full glass-btn px-6 py-4 rounded-xl text-white font-semibold text-center">
                        Checkout
                    </a>

                    <div class="mt-6 p-4 glass rounded-xl">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="fas fa-shield-halved text-green-400"></i>
                            <span class="text-white/80 text-sm">Transaksi Aman & Terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-truck text-green-400"></i>
                            <span class="text-white/80 text-sm">Gratis ongkir untuk pembelian Rp 500.000+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="glass-card rounded-xl p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full glass flex items-center justify-center">
                <i class="fas fa-shopping-cart text-white/50 text-4xl"></i>
            </div>
            <h3 class="text-white text-xl font-semibold mb-2">Keranjang Kosong</h3>
            <p class="text-white/60 mb-6">Belum ada produk dalam keranjang Anda</p>
            <a href="{{ route('products') }}" class="inline-flex items-center gap-2 glass-btn px-6 py-3 rounded-xl text-white font-medium">
                <i class="fas fa-shopping-bag"></i>
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection
