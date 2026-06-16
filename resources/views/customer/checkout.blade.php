@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Checkout</h1>
            <p class="text-white/70 mt-2">Lengkapi data untuk menyelesaikan pesanan</p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Address -->
                    <div class="glass-card p-6">
                        <h3 class="text-white text-xl font-semibold mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold">1</span>
                            Alamat Pengiriman
                        </h3>

                        <div class="space-y-4">
                            @auth
                                <div class="p-4 glass rounded-xl">
                                    <div class="flex items-start gap-4">
                                        <input type="radio" name="address_type" value="profile" checked class="mt-1 accent-green-500">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-white font-medium">Alamat Profil</span>
                                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-lg">Tersimpan</span>
                                            </div>
                                            <p class="text-white/80 text-sm mb-1">{{ auth()->user()->name }}</p>
                                            <p class="text-white/60 text-sm mb-1">{{ auth()->user()->phone }}</p>
                                            <p class="text-white/60 text-sm">{{ auth()->user()->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endauth

                            <!-- New Address Form -->
                            <div class="space-y-4 p-4 glass rounded-xl">
                                <label class="flex items-center gap-4">
                                    <input type="radio" name="address_type" value="new" @guest checked @endguest class="accent-green-500">
                                    <span class="text-white font-medium">Alamat Baru</span>
                                </label>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-white/80 text-sm font-medium mb-2">Nama Penerima *</label>
                                        <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name ?? '') }}" required
                                            class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-white/60 @error('recipient_name') border-red-500 @enderror">
                                        @error('recipient_name')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-white/80 text-sm font-medium mb-2">Nomor Telepon *</label>
                                        <input type="tel" name="recipient_phone" value="{{ old('recipient_phone', auth()->user()->phone ?? '') }}" required
                                            class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-white/60 @error('recipient_phone') border-red-500 @enderror">
                                        @error('recipient_phone')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-white/80 text-sm font-medium mb-2">Alamat Lengkap *</label>
                                    <textarea name="shipping_address" rows="3" required
                                        class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-white/60 resize-none @error('shipping_address') border-red-500 @enderror"
                                        placeholder="Jl. jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos">{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="glass-card p-6">
                        <h3 class="text-white text-xl font-semibold mb-4 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-sm font-bold">2</span>
                            Catatan Pesanan
                        </h3>
                        <textarea name="notes" rows="3"
                            class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-white/60 resize-none"
                            placeholder="Tambahkan catatan untuk pesanan ini (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Order Summary -->
                <div>
                    <div class="glass-card p-6 sticky top-24">
                        <h3 class="text-white text-xl font-semibold mb-6">Ringkasan Belanja</h3>

                        <!-- Items -->
                        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                            @foreach($items as $item)
                                <div class="flex gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-green-600/20 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-box text-green-400/60"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-white text-sm font-medium truncate">{{ $item['name'] }}</p>
                                        <p class="text-white/60 text-xs">{{ $item['quantity'] }}x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-green-400 text-sm">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-3 mb-6 pt-4 border-t border-white/10">
                            <div class="flex justify-between text-white/80 text-sm">
                                <span>Subtotal ({{ count($items) }} item)</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-white/80 text-sm">
                                <span>Ongkos Kirim</span>
                                <span class="{{ $shipping == 0 ? 'text-green-400' : '' }}">
                                    {{ $shipping == 0 ? 'GRATIS' : 'Rp ' . number_format($shipping, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="border-t border-white/10 pt-3 flex justify-between">
                                <span class="text-white font-semibold">Total</span>
                                <span class="text-green-400 font-bold text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full glass-btn py-4 rounded-xl text-white font-semibold text-center flex items-center justify-center gap-2">
                            <i class="fas fa-lock"></i>
                            Pilih Metode Pembayaran
                        </button>

                        <p class="text-white/50 text-xs text-center mt-4">
                            Pembayaran aman dengan <span class="text-green-400 font-medium">Midtrans</span>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
