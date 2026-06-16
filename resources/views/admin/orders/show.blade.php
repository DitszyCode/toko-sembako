@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-semibold text-white">Detail Pesanan #{{ $order->id }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Item Pesanan</h2>
                <div class="space-y-4">
                    @forelse($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-700/30 rounded-xl">
                            <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-600 flex-shrink-0">
                                @if($item->product_name)
                                    <i class="fas fa-box text-gray-400 flex items-center justify-center w-full h-full"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-white">{{ $item->product_name ?? 'Produk' }}</p>
                                <p class="text-gray-400 text-sm">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-white font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-4">Tidak ada item</p>
                    @endforelse
                </div>
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-white">Total</span>
                        <span class="text-green-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Informasi Pesanan</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                            @elseif($order->status === 'processing') bg-blue-500/20 text-blue-400
                            @elseif($order->status === 'shipped') bg-purple-500/20 text-purple-400
                            @elseif($order->status === 'delivered') bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400
                            @endif">
                            {{ $order->status_label }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Pembayaran</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            @if($order->payment_status === 'paid') bg-green-500/20 text-green-400
                            @else bg-yellow-500/20 text-yellow-400
                            @endif">
                            {{ $order->payment_status_label }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tanggal</span>
                        <span class="text-white">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.orders') }}/{{ $order->id }}/status" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <label class="block text-gray-400 text-sm mb-2">Ubah Status</label>
                    <select name="status" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-2 text-sm focus:outline-none">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="mt-3 w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 rounded-xl transition-all text-sm">Update Status</button>
                </form>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Pelanggan</h2>
                <p class="text-white font-medium">{{ $order->user->name ?? 'N/A' }}</p>
                <p class="text-gray-400 text-sm">{{ $order->user->email ?? '' }}</p>
                @if($order->user->phone)
                    <p class="text-gray-400 text-sm">{{ $order->user->phone }}</p>
                @endif
            </div>

            <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Alamat Pengiriman</h2>
                <p class="text-gray-300 text-sm">{{ $order->shipping_address }}</p>
                @if($order->recipient_name)
                    <p class="text-gray-400 text-sm mt-2">{{ $order->recipient_name }} - {{ $order->recipient_phone }}</p>
                @endif
                @if($order->notes)
                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <h3 class="text-gray-400 text-sm mb-2">Catatan</h3>
                        <p class="text-gray-300 text-sm">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
