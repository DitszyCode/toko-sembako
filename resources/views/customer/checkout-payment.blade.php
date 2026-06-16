@extends('layouts.customer')

@section('title', 'Pembayaran')

@push('styles')
<style>
    .payment-card {
        animation: fadeInUp 0.5s ease forwards;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .spinner {
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top: 3px solid #22c55e;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Pembayaran</h1>
            <p class="text-white/70 mt-2">Selesaikan pembayaran untuk pesanan Anda</p>
        </div>

        <!-- Order Info -->
        <div class="glass-card p-6 mb-6 payment-card">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-white/60 text-sm">Nomor Pesanan</p>
                    <p class="text-white text-xl font-bold">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-white/60 text-sm">Total Pembayaran</p>
                    <p class="text-green-400 text-2xl font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="glass-card p-6 mb-6 payment-card" style="animation-delay: 0.1s;">
            <h3 class="text-white text-xl font-semibold mb-4 flex items-center gap-3">
                <i class="fas fa-credit-card text-green-400"></i>
                Metode Pembayaran
            </h3>

            <div class="text-center py-8">
                <div id="loading-payment" class="mb-4">
                    <div class="spinner mx-auto"></div>
                    <p class="text-white/70 mt-4">Memuat metode pembayaran...</p>
                </div>

                <div id="payment-button-container"></div>

                <div id="payment-error" class="hidden">
                    <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-4"></i>
                    <p class="text-white/70 mb-4">Gagal memuat halaman pembayaran</p>
                    <button onclick="location.reload()" class="glass-btn px-6 py-2 rounded-xl text-white">
                        <i class="fas fa-redo mr-2"></i> Coba Lagi
                    </button>
                </div>
            </div>

            <div class="mt-6 p-4 bg-green-500/10 rounded-xl border border-green-500/20">
                <h4 class="text-green-400 font-medium mb-2">
                    <i class="fas fa-info-circle mr-2"></i>Petunjuk Pembayaran
                </h4>
                <ul class="text-white/70 text-sm space-y-1">
                    <li>• Klik tombol "Bayar Sekarang" untuk memilih metode pembayaran</li>
                    <li>• Anda akan diarahkan ke halaman pembayaran Midtrans</li>
                    <li>• Pilih metode pembayaran yang tersedia (Transfer, E-Wallet, dll)</li>
                    <li>• Setelah pembayaran berhasil, pesanan Anda akan diproses otomatis</li>
                </ul>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="glass-card p-6 payment-card" style="animation-delay: 0.2s;">
            <h3 class="text-white text-xl font-semibold mb-4">Ringkasan Pesanan</h3>

            <div class="space-y-4 mb-6">
                @foreach($items as $item)
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <div class="flex items-center gap-3">
                            <span class="text-white/60 text-sm">{{ $item['quantity'] }}x</span>
                            <span class="text-white">{{ $item['product_name'] }}</span>
                        </div>
                        <span class="text-green-400">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between text-white/80 text-sm mb-2">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->total_amount - ($order->total_amount > 525000 ? 0 : 25000), 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-white/80 text-sm mb-4">
                <span>Ongkos Kirim</span>
                <span class="{{ $order->total_amount > 525000 ? 'text-green-400' : '' }}">
                    {{ $order->total_amount > 525000 ? 'GRATIS' : 'Rp 25.000' }}
                </span>
            </div>
            <div class="border-t border-white/10 pt-4 flex justify-between">
                <span class="text-white font-semibold text-lg">Total</span>
                <span class="text-green-400 font-bold text-xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-6">
            <a href="{{ route('orders.show', $order->id) }}" class="text-white/60 hover:text-white transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail Pesanan
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $midtransClientKey }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const snapToken = '{{ $snapToken }}';
    const container = document.getElementById('payment-button-container');
    const loading = document.getElementById('loading-payment');
    const errorDiv = document.getElementById('payment-error');

    if (!snapToken) {
        loading.classList.add('hidden');
        errorDiv.classList.remove('hidden');
        return;
    }

    // Hide loading and show payment button
    loading.classList.add('hidden');

    // Create payment button
    const payButton = document.createElement('button');
    payButton.className = 'glass-btn px-8 py-4 rounded-xl text-white font-semibold inline-flex items-center gap-3';
    payButton.innerHTML = '<i class="fas fa-credit-card"></i> Bayar Sekarang';
    payButton.onclick = function() {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                // Redirect to finish page
                window.location.href = '{{ route("checkout.finish", $order->id) }}?status_id=200&order_id=' + result.order_id;
            },
            onPending: function(result) {
                // Redirect to unfinish page
                window.location.href = '{{ route("checkout.unfinish", $order->id) }}?status_id=201&order_id=' + result.order_id;
            },
            onError: function(result) {
                // Redirect to error page
                window.location.href = '{{ route("checkout.error", $order->id) }}?status_id=202&order_id=' + result.order_id;
            },
            onClose: function() {
                // User closed the popup
                console.log('Customer closed the payment popup');
            }
        });
    };

    container.appendChild(payButton);
});
</script>
@endpush
