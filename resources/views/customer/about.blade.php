@extends('layouts.customer')

@section('title', 'Tentang Kami')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 lg:py-32">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <span class="inline-block bg-green-500/20 text-green-400 px-4 py-2 rounded-full text-sm font-medium mb-6">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Tentang Kami
        </span>
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-6">Melayani Kebutuhan Sembako Anda Sejak 2010</h1>
        <p class="text-green-100 text-lg max-w-3xl mx-auto">
            Toko Sembako adalah pilihan terpercaya untuk memenuhi kebutuhan sehari-hari keluarga Indonesia dengan produk berkualitas dan harga terjangkau.
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="glass-card rounded-3xl p-8 lg:p-12">
                <h2 class="text-3xl font-bold text-white mb-6">Cerita Kami</h2>
                <div class="space-y-4 text-green-100">
                    <p>
                        Berdiri sejak tahun 2010, Toko Sembako bermula dari sebuah toko kecil di pinggiran Bandung. Berkat kepercayaan pelanggan dan kerja keras, kini kami telah melayani ribuan keluarga di seluruh Indonesia.
                    </p>
                    <p>
                        Visi kami adalah menjadi toko sembako online terdepan yang menyediakan produk berkualitas dengan harga terjangkau dan pengiriman cepat ke seluruh pelosok Indonesia.
                    </p>
                    <p>
                        Dengan pengalaman lebih dari satu dekade, kami memahami kebutuhan keluarga Indonesia akan produk pokok yang berkualitas. Setiap produk yang kami jual melewati seleksi ketat untuk memastikan kualitasnya.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="glass-card rounded-3xl p-8">
                    <div class="aspect-video bg-gradient-to-br from-green-600/30 to-green-700/30 rounded-2xl flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-24 h-24 text-green-400/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <p class="text-green-200/60">Toko Sembako</p>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 glass-card rounded-2xl flex items-center justify-center">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-400">{{ $stats['orders'] > 0 ? floor($stats['orders'] / 365) . '+' : '1+' }}</p>
                        <p class="text-green-200/60 text-sm">Tahun</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Misi & Visi Kami</h2>
            <p class="text-green-100 max-w-2xl mx-auto">Komitmen kami untuk memberikan layanan terbaik bagi pelanggan</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <div class="glass-card rounded-2xl p-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Visi</h3>
                <p class="text-green-100">
                    Menjadi toko online terdepan yang menyediakan kebutuhan pokok berkualitas untuk setiap rumah tangga Indonesia, dengan jangkauan pengiriman ke seluruh pelosok Nusantara.
                </p>
            </div>

            <div class="glass-card rounded-2xl p-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Misi</h3>
                <ul class="space-y-3 text-green-100">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Menyediakan produk berkualitas dengan harga terjangkau</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Memberikan layanan pengiriman cepat dan aman</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Membangun hubungan baik dengan pelanggan dan supplier</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Terus berinovasi dalam layanan dan produk</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Nilai-Nilai Kami</h2>
            <p class="text-green-100">Prinsip yang kami pegang dalam menjalankan bisnis</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $values = [
                    ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Integritas', 'desc' => 'Jujur dan transparan'],
                    ['icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'title' => 'Kualitas', 'desc' => 'Produk terbaik pilihan'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364l-1.907 1.907', 'title' => 'Pelayanan', 'desc' => 'Prioritas pelanggan'],
                    ['icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'title' => 'Keberlanjutan', 'desc' => 'Ramah lingkungan'],
                ];
            @endphp

            @foreach($values as $value)
                <div class="glass-card rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"></path>
                        </svg>
                    </div>
                    <h4 class="text-white font-semibold mb-2">{{ $value['title'] }}</h4>
                    <p class="text-green-200/60 text-sm">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="glass-card rounded-3xl p-8 lg:p-12 bg-gradient-to-r from-green-600 to-green-700">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <p class="text-3xl lg:text-4xl font-bold text-white mb-2">{{ number_format($stats['customers']) }}+</p>
                    <p class="text-green-100">Pelanggan Puas</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl lg:text-4xl font-bold text-white mb-2">{{ number_format($stats['products']) }}+</p>
                    <p class="text-green-100">Produk Tersedia</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl lg:text-4xl font-bold text-white mb-2">{{ number_format($stats['orders']) }}+</p>
                    <p class="text-green-100">Pesanan Selesai</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl lg:text-4xl font-bold text-white mb-2">{{ $stats['categories'] }}+</p>
                    <p class="text-green-100">Kategori</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Siap Berbelanja?</h2>
        <p class="text-green-100 mb-8 max-w-2xl mx-auto">Bergabung dengan ribuan pelanggan puas yang telah mempercayakan kebutuhan dapur mereka kepada Toko Sembako</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('products') }}" class="glass-btn px-8 py-4 rounded-xl text-white font-semibold">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Mulai Belanja
            </a>
            <a href="{{ route('contact') }}" class="glass px-8 py-4 rounded-xl text-white font-semibold hover:bg-white/20 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
