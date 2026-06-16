@extends('layouts.customer')

@section('title', 'Kontak')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #contact-map { width: 100%; height: 400px; border-radius: 16px; z-index: 1; }
    .leaflet-control-zoom a { background: #166534 !important; color: #fff !important; border-color #166534 !important; }
    .leaflet-control-zoom a:hover { background: #14532d !important; }
    .leaflet-popup-content-wrapper { background: #1a2e1a; color: #fff; border-radius: 12px; }
    .leaflet-popup-tip { background: #1a2e1a; }
    .leaflet-popup-content { margin: 14px 18px; }
    .map-popup-title { font-weight: 700; font-size: 15px; margin-bottom: 4px; color: #34d399; }
    .map-popup-desc { font-size: 13px; color: #bbf7d0; margin: 0; }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="py-16 lg:py-24">
    <div class="container mx-auto px-4 lg:px-8 text-center">
        <span class="inline-block bg-green-500/20 text-green-400 px-4 py-2 rounded-full text-sm font-medium mb-6">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Hubungi Kami
        </span>
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-6">Kami Siap Membantu</h1>
        <p class="text-green-100 text-lg max-w-2xl mx-auto">
            Ada pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi tim kami. Kami siap membantu Anda 24/7.
        </p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="pb-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-2">Alamat</h3>
                            <p class="text-green-100">
                                Jl. Tembok Dukuh V/50<br>
                                RT 01/RW 02, Kelurahan Bubutan<br>
                                Kecamatan Bubutan, Kota Surabaya<br>
                                Jawa timur 60173
                            </p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-2">Telepon</h3>
                            <p class="text-green-100 mb-2">+62 857-7116-8204</p>
                            <p class="text-green-200/60 text-sm">WhatsApp juga tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-2">Email</h3>
                            <p class="text-green-100 mb-2">adityaramadhanikita.x13@gmail.com</p>
                            <p class="text-green-200/60 text-sm">Respon dalam 1x24 jam</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-2">Jam Operasional</h3>
                            <p class="text-green-100 mb-1">Senin - Sabtu: 08:00 - 21:00 WIB</p>
                            <p class="text-green-100">Minggu: 09:00 - 17:00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-white font-semibold text-lg mb-4">Ikuti Kami</h3>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.98-.72-.02-.1-.04-.21-.04-.33 0-.26.15-1.52.27-2.73.12-1.26.22-2.98.13-4.04-.01-1.19-.07-2.37-.24-3.51-.17-1.15-.53-2.25-.92-3.19-.41-.96-1.02-1.81-1.73-2.46-.72-.66-1.53-1.19-2.5-1.35-.97-.16-2.09-.09-3.11.14-.51.12-1.02.31-1.5.52-.97.44-1.81 1.08-2.52 1.71-.71.63-1.33 1.39-1.82 2.22-.49.83-.86 1.77-1.07 2.76-.21 1-.25 2.16-.08 3.24.17 1.08.63 2.13 1.22 3.05.6.93 1.42 1.69 2.33 2.21.91.52 2.01.79 3.18.75 1.17-.04 2.28-.45 3.23-.96.95-.51 1.76-1.25 2.29-2.11.53-.86.86-1.89.92-2.96.06-1.07-.05-2.21-.29-3.2z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="glass-card rounded-2xl p-6 lg:p-8" x-data="{ submitting: false, success: false }">
                <h2 class="text-2xl font-bold text-white mb-6">Kirim Pesan</h2>

                @if (session('success'))
                    <div id="success-alert" class="glass bg-green-500/30 border border-green-400/30 mb-4 p-4 rounded-xl transition-opacity duration-500">
                        <p class="text-green-100">{{ session('success') }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            var el = document.getElementById('success-alert');
                            if (el) {
                                el.style.opacity = '0';
                                setTimeout(function() { el.style.display = 'none'; }, 500);
                            }
                        }, 4000);
                    </script>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-green-200/80 text-sm font-medium mb-2">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Masukkan nama Anda" required
                                class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-green-200/60 @error('name') border border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-green-200/80 text-sm font-medium mb-2">Email</label>
                            <input type="email" name="email" placeholder="email@contoh.com" required
                                class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-green-200/60 @error('email') border border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-green-200/80 text-sm font-medium mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" placeholder="08xxxxxxxxxx"
                            class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-green-200/60">
                    </div>
                    <div>
                        <label class="block text-green-200/80 text-sm font-medium mb-2">Subjek</label>
                        <select name="subject" class="w-full glass-input px-4 py-3 rounded-xl text-white">
                            <option value="">Pilih Subjek</option>
                            <option value="order" {{ old('subject') == 'order' ? 'selected' : '' }}>Pertanyaan Pesanan</option>
                            <option value="product" {{ old('subject') == 'product' ? 'selected' : '' }}>Informasi Produk</option>
                            <option value="complaint" {{ old('subject') == 'complaint' ? 'selected' : '' }}>Keluhan</option>
                            <option value="suggestion" {{ old('subject') == 'suggestion' ? 'selected' : '' }}>Saran</option>
                            <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Kemitraan</option>
                            <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-green-200/80 text-sm font-medium mb-2">Pesan</label>
                        <textarea name="message" rows="5" placeholder="Tulis pesan Anda di sini..." required
                            class="w-full glass-input px-4 py-3 rounded-xl text-white placeholder-green-200/60 resize-none @error('message') border border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" :disabled="submitting"
                        class="w-full glass-btn px-6 py-4 rounded-xl text-white font-semibold disabled:opacity-50">
                        <span x-show="!submitting">Kirim Pesan</span>
                        <span x-show="submitting">Mengirim...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="pb-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Pertanyaan Umum</h2>
            <p class="text-green-100">Jawaban untuk pertanyaan yang sering ditanyakan</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4" x-data="{ openFaq: null }">
            @php
                $faqs = [
                    ['question' => 'Bagaimana cara memesan di Toko Sembako?', 'answer' => 'Anda dapat memesan dengan memilih produk yang diinginkan, menambah ke keranjang, lalu checkout. Pembayaran dapat dilakukan melalui transfer bank, e-wallet, atau COD.'],
                    ['question' => 'Berapa lama pengiriman dilakukan?', 'answer' => 'Waktu pengiriman bervariasi tergantung lokasi dan metode pengiriman yang dipilih. Umumnya 1-5 hari kerja untuk wilayah Jawa, dan 3-7 hari kerja untuk luar Jawa.'],
                    ['question' => 'Apakah ada minimal pembelian?', 'answer' => 'Tidak ada minimal pembelian. Namun, untuk pengiriman gratis, Anda perlu belanja minimal Rp 100.000.'],
                    ['question' => 'Bagaimana jika produk yang diterima rusak?', 'answer' => 'Jika produk yang diterima rusak atau tidak sesuai, Anda dapat menghubungi kami dalam 1x24 jam setelah pengiriman. Kami akan memberikan penggantian atau refund.'],
                    ['question' => 'Metode pembayaran apa saja yang tersedia?', 'answer' => 'Kami menerima pembayaran melalui transfer bank (BCA, Mandiri, BNI, BRI), e-wallet (GoPay, OVO, DANA, ShopeePay), kartu kredit/debit, dan bayar di tempat (COD).'],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="glass-card rounded-xl overflow-hidden">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                        class="w-full flex items-center justify-between p-5 text-left">
                        <span class="text-white font-medium pr-4">{{ $faq['question'] }}</span>
                        <svg class="w-5 h-5 text-green-400 transition-transform flex-shrink-0"
                            :class="{ 'rotate-180': openFaq === {{ $index }} }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="openFaq === {{ $index }}"
                        x-collapse
                        class="px-5 pb-5">
                        <p class="text-green-100">{{ $faq['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Map -->
<section class="pb-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div id="contact-map"></div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Koordinat toko
        var lat = -7.253639508431685;
        var lng = 112.72347948169569;

        var map = L.map('contact-map', {
            center: [lat, lng],
            zoom: 15,
            scrollWheelZoom: false,
        });

        // Dark theme tiles
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19,
        }).addTo(map);

        // Custom marker icon
        var icon = L.divIcon({
            html: '<div style="background:#059669;width:44px;height:44px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 4px 12px rgba(0,0,0,0.4);"><span style="transform:rotate(45deg);font-size:20px;">🛒</span></div>',
            className: '',
            iconSize: [44, 44],
            iconAnchor: [22, 44],
            popupAnchor: [0, -48],
        });

        L.marker([lat, lng], { icon: icon })
            .addTo(map)
            .bindPopup('<div class="map-popup-title">Toko Sembako</div><p class="map-popup-desc">Jl. Tembok Dukuh V/50, Surabaya</p>')
            .openPopup();
    });
</script>
@endpush
@endsection
