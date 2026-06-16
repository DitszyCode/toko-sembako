@extends('layouts.customer')

@section('title', 'Beranda')

@push('styles')
<style>
    html { scroll-behavior: smooth; }

    /* =============================================
       SCROLL REVEAL - Smooth Animation
    ============================================= */
    .reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                    transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .reveal.is-visible {
        opacity: 1 !important;
        transform: translate(0) !important;
    }
    .delay-100 { transition-delay: 0.10s !important; }
    .delay-200 { transition-delay: 0.20s !important; }
    .delay-300 { transition-delay: 0.30s !important; }
    .delay-400 { transition-delay: 0.40s !important; }
    .delay-500 { transition-delay: 0.50s !important; }
    .delay-600 { transition-delay: 0.60s !important; }

    /* Fade In Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(32px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.85); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-12px); }
    }
    @keyframes floatSlow {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50%       { transform: translateY(-8px) rotate(3deg); }
    }
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
        50%       { box-shadow: 0 0 24px 6px rgba(52, 211, 153, 0.25); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }
    @keyframes bounce-in {
        0%   { opacity: 0; transform: scale(0.3); }
        50%  { transform: scale(1.08); }
        70%  { transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    @keyframes count-flip {
        0%   { transform: translateY(-100%); opacity: 0; }
        100% { transform: translateY(0);    opacity: 1; }
    }
    @keyframes gradient-shift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes ripple {
        0%   { transform: scale(1); opacity: 0.6; }
        100% { transform: scale(2.5); opacity: 0; }
    }

    /* =============================================
       SCROLL REVEAL — initial hidden state
    ============================================= */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.65s cubic-bezier(0.22,1,0.36,1),
                    transform 0.65s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.reveal-left  { transform: translateX(-28px); }
    .reveal.reveal-right { transform: translateX(28px); }
    .reveal.reveal-scale { transform: scale(0.88); }
    .reveal.is-visible {
        opacity: 1 !important;
        transform: translate(0) scale(1) !important;
    }
    /* staggered delay helpers */
    .delay-100 { transition-delay: 0.10s !important; }
    .delay-150 { transition-delay: 0.15s !important; }
    .delay-200 { transition-delay: 0.20s !important; }
    .delay-250 { transition-delay: 0.25s !important; }
    .delay-300 { transition-delay: 0.30s !important; }
    .delay-350 { transition-delay: 0.35s !important; }
    .delay-400 { transition-delay: 0.40s !important; }
    .delay-500 { transition-delay: 0.50s !important; }
    .delay-600 { transition-delay: 0.60s !important; }

    /* =============================================
       HERO
    ============================================= */
    .hero-section {
        background: linear-gradient(135deg, #14532d 0%, #166534 40%, #0f766e 100%);
        background-size: 300% 300%;
        animation: gradient-shift 8s ease infinite;
    }
    .hero-badge {
        animation: fadeInDown 0.6s ease both;
    }
    .hero-title {
        animation: fadeInUp 0.7s 0.15s ease both;
    }
    .hero-subtitle {
        animation: fadeInUp 0.7s 0.25s ease both;
    }
    .hero-search {
        animation: fadeInUp 0.7s 0.35s ease both;
    }
    .hero-tags {
        animation: fadeInUp 0.7s 0.45s ease both;
    }
    .hero-stat-card {
        animation: scaleIn 0.5s ease both;
    }
    .hero-stat-card:nth-child(1) { animation-delay: 0.5s; }
    .hero-stat-card:nth-child(2) { animation-delay: 0.6s; }
    .hero-stat-card:nth-child(3) { animation-delay: 0.7s; }
    .hero-stat-card:nth-child(4) { animation-delay: 0.8s; }

    /* floating blobs di hero */
    .hero-blob {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.12;
    }
    .hero-blob-1 {
        width: 320px; height: 320px;
        background: white;
        top: -80px; right: -80px;
        animation: floatSlow 7s ease-in-out infinite;
    }
    .hero-blob-2 {
        width: 180px; height: 180px;
        background: white;
        bottom: -40px; left: 10%;
        animation: floatSlow 9s 1s ease-in-out infinite;
    }
    .hero-blob-3 {
        width: 100px; height: 100px;
        background: #6ee7b7;
        top: 30%; left: 50%;
        animation: float 6s 0.5s ease-in-out infinite;
        opacity: 0.08;
    }

    /* =============================================
       SEARCH BAR
    ============================================= */
    .search-wrapper {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .search-wrapper:focus-within {
        box-shadow: 0 0 0 3px rgba(52,211,153,0.4);
        transform: translateY(-2px);
    }
    .search-tag-link {
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .search-tag-link:hover {
        transform: translateY(-2px);
    }

    /* =============================================
       CATEGORY CARDS
    ============================================= */
    .cat-card {
        transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1),
                    box-shadow 0.3s ease;
    }
    .cat-card:hover {
        transform: translateY(-6px) scale(1.04);
        box-shadow: 0 16px 40px rgba(0,0,0,0.25);
    }
    .cat-icon-wrap {
        transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
    }
    .cat-card:hover .cat-icon-wrap {
        transform: scale(1.18) rotate(-6deg);
    }

    /* =============================================
       PRODUCT CARDS
    ============================================= */
    .product-card {
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }
    .product-img-wrap img {
        transition: transform 0.5s cubic-bezier(0.22,1,0.36,1);
    }
    .product-card:hover .product-img-wrap img {
        transform: scale(1.08);
    }
    .product-overlay {
        transition: opacity 0.3s ease;
    }
    .product-overlay-btn {
        transition: background 0.2s ease, color 0.2s ease,
                    transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
        transform: scale(0.7);
    }
    .product-card:hover .product-overlay-btn {
        transform: scale(1);
    }
    .product-card:hover .product-overlay-btn:nth-child(2) {
        transition-delay: 0.06s;
    }
    .btn-tambah {
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }
    .btn-tambah:hover {
        transform: scale(1.05);
    }
    .btn-tambah:active {
        transform: scale(0.96);
    }

    /* badge pulse */
    .badge-feat {
        animation: pulse-glow 2.5s ease-in-out infinite;
    }

    /* =============================================
       PROMO BANNER
    ============================================= */
    .promo-icon-wrap {
        animation: float 4s ease-in-out infinite;
    }
    .promo-disc-badge {
        animation: spin-slow 8s linear infinite;
    }
    .promo-btn {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .promo-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.25) 50%, transparent 100%);
        background-size: 200% 100%;
        animation: shimmer 2.5s infinite;
    }
    .promo-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    /* countdown flip */
    .cd-number {
        display: inline-block;
        animation: count-flip 0.3s ease;
    }

    /* =============================================
       WHY US CARDS
    ============================================= */
    .why-card {
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.3s ease;
    }
    .why-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.2);
    }
    .why-icon-wrap {
        transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
    }
    .why-card:hover .why-icon-wrap {
        transform: scale(1.15) rotate(6deg);
    }

    /* =============================================
       TESTIMONIALS
    ============================================= */
    .testi-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .testi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.2);
    }

    /* ripple on avatar */
    .testi-avatar {
        position: relative;
    }
    .testi-avatar::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 2px solid rgba(52,211,153,0.5);
        animation: ripple 2.5s ease-out infinite;
    }

    /* =============================================
       NEWSLETTER
    ============================================= */
    .nl-input {
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .nl-input:focus {
        box-shadow: 0 0 0 3px rgba(52,211,153,0.35);
        transform: translateY(-1px);
        outline: none;
    }
    .nl-btn {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .nl-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }
    .nl-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* =============================================
       SECTION HEADING UNDERLINE ANIMATE
    ============================================= */
    .section-heading {
        position: relative;
        display: inline-block;
    }
    .section-heading::after {
        content: '';
        position: absolute;
        left: 0; bottom: -6px;
        height: 3px;
        width: 0;
        background: linear-gradient(90deg, #34d399, #0d9488);
        border-radius: 99px;
        transition: width 0.6s 0.3s cubic-bezier(0.22,1,0.36,1);
    }
    .is-visible .section-heading::after,
    .reveal.is-visible .section-heading::after {
        width: 100%;
    }

    /* global smooth scroll */
    html { scroll-behavior: smooth; }
</style>
@endpush

@section('content')

    {{-- ==================== HERO ==================== --}}
    <section class="relative overflow-hidden">
        <div class="container mx-auto px-4 lg:px-8 pt-8">
            <div class="hero-section glass-card rounded-3xl overflow-hidden relative p-8 lg:p-14">

                {{-- decorative blobs --}}
                <div class="hero-blob hero-blob-1"></div>
                <div class="hero-blob hero-blob-2"></div>
                <div class="hero-blob hero-blob-3"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center gap-10">

                    {{-- Left --}}
                    <div class="flex-1 w-full">
                        {{-- Welcome Message (Only for logged in users) --}}
                        @auth
                            <div class="hero-badge inline-flex items-center gap-2 bg-green-500/30 border border-green-400/30 text-green-300 text-sm px-4 py-2 rounded-full mb-5 animate-fadeInDown">
                                <i class="fas fa-hand-wave text-yellow-400"></i>
                                Selamat datang, <span class="font-bold text-white">{{ auth()->user()->name }}</span>! 👋
                            </div>
                        @endauth

                        <span class="hero-badge inline-flex items-center gap-2 bg-white/20 text-white text-sm px-4 py-1.5 rounded-full mb-5">
                            <i class="fas fa-shield-halved"></i> Terpercaya & Berkualitas
                        </span>

                        <h1 class="hero-title text-3xl lg:text-5xl font-bold text-white mb-3 leading-tight">
                            Sembako Segar, <br class="hidden lg:block"> Harga Bersahabat
                        </h1>

                        <p class="hero-subtitle text-white/80 text-lg mb-8">
                            Belanja kebutuhan dapur dengan mudah — dikirim langsung ke pintu rumah Anda.
                        </p>

                        {{-- Search Bar --}}
                        <div class="hero-search search-wrapper flex items-center gap-2 bg-white/15 border border-white/30 rounded-2xl p-2 backdrop-blur-sm mb-4">
                            <select class="bg-transparent border-none text-white text-sm px-3 py-2 outline-none cursor-pointer border-r border-white/30 pr-4 flex-shrink-0"
                                    id="hero-category-select"
                                    style="background-color:transparent;">
                                <option class="text-green-800 bg-white" value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option class="text-green-800 bg-white" value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <form action="{{ route('products') }}" method="GET" class="flex flex-1 items-center gap-2">
                                <input type="hidden" name="category" id="search-category-input">
                                <input type="text"
                                       name="search"
                                       placeholder="Cari produk, merek, atau kategori…"
                                       class="flex-1 bg-transparent border-none text-white placeholder-white/60 text-sm px-2 py-2 outline-none">
                                <button type="submit"
                                        class="flex-shrink-0 bg-white text-green-700 font-semibold text-sm px-6 py-2.5 rounded-xl hover:bg-green-50 transition-all duration-200 flex items-center gap-2 hover:scale-105 active:scale-95">
                                    <i class="fas fa-search"></i>
                                    <span class="hidden sm:inline">Cari</span>
                                </button>
                            </form>
                        </div>

                        {{-- Quick Tags --}}
                        <div class="hero-tags flex flex-wrap gap-2">
                            <span class="text-white/60 text-sm self-center">Populer:</span>
                            @php $popularSearches = ['Beras 5kg', 'Minyak Goreng', 'Gula Pasir', 'Indomie', 'Sabun Cuci']; @endphp
                            @foreach($popularSearches as $i => $keyword)
                                <a href="{{ route('products', ['search' => $keyword]) }}"
                                   class="search-tag-link bg-white/15 hover:bg-white/30 border border-white/25 text-white/85 text-xs px-3 py-1.5 rounded-full"
                                   style="animation: fadeInUp 0.5s {{ 0.55 + $i * 0.08 }}s ease both;">
                                    {{ $keyword }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right Stats --}}
                    <div class="flex-shrink-0 hidden lg:grid grid-cols-2 gap-4">
                        @foreach([['500+','Produk'],['10rb+','Pelanggan'],['4.9 ★','Rating'],['<24 jam','Pengiriman']] as $s)
                        <div class="hero-stat-card glass-card rounded-2xl p-5 text-center hover:scale-105 transition-transform duration-300 cursor-default">
                            <div class="text-3xl font-bold text-white">{{ $s[0] }}</div>
                            <div class="text-white/70 text-sm mt-1">{{ $s[1] }}</div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- ==================== BANNER SLIDER ==================== --}}
    @if($banners->count() > 0)
    <section class="py-6 reveal" x-data="{
        currentSlide: 0,
        total: {{ $banners->count() }},
        autoplay() { setInterval(() => { this.currentSlide = this.currentSlide === this.total - 1 ? 0 : this.currentSlide + 1; }, 5000); }
    }" x-init="autoplay">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="glass-card rounded-2xl overflow-hidden relative min-h-[180px]">
                @foreach($banners as $index => $banner)
                    <div x-show="currentSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-400"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="absolute inset-0 flex items-center bg-gradient-to-r from-green-600 to-emerald-500 px-8">
                        <div class="flex flex-col lg:flex-row items-center gap-6 w-full">
                            <div class="flex-1">
                                <h2 class="text-xl lg:text-3xl font-bold text-white mb-2">{{ $banner->title }}</h2>
                                @if($banner->subtitle)<p class="text-white/80 mb-4">{{ $banner->subtitle }}</p>@endif
                                <a href="{{ $banner->link ?? route('products') }}"
                                   class="inline-flex items-center gap-2 bg-white text-green-600 px-6 py-2.5 rounded-xl font-semibold hover:bg-green-50 hover:scale-105 transition-all duration-200 text-sm">
                                    {{ $banner->button_text ?? 'Belanja Sekarang' }} <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            @if($banner->image)
                                <img src="{{ $banner->image }}" alt="{{ $banner->title }}" class="w-40 h-40 object-cover rounded-xl hidden lg:block" style="animation: float 5s ease-in-out infinite;">
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                    @foreach($banners as $index => $banner)
                        <button @click="currentSlide = {{ $index }}"
                                class="h-2 rounded-full transition-all duration-300"
                                :class="currentSlide === {{ $index }} ? 'bg-white w-6' : 'bg-white/40 w-2 hover:bg-white/60'">
                        </button>
                    @endforeach
                </div>
                <button @click="currentSlide = currentSlide === 0 ? total - 1 : currentSlide - 1"
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full glass flex items-center justify-center hover:bg-white/20 hover:scale-110 transition-all">
                    <i class="fas fa-chevron-left text-white text-xs"></i>
                </button>
                <button @click="currentSlide = currentSlide === total - 1 ? 0 : currentSlide + 1"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full glass flex items-center justify-center hover:bg-white/20 hover:scale-110 transition-all">
                    <i class="fas fa-chevron-right text-white text-xs"></i>
                </button>
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== CATEGORIES ==================== --}}
    <section class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between mb-8 reveal">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-white section-heading">Kategori Produk</h2>
                    <p class="text-white/70 mt-2">Temukan berbagai kebutuhan sembako Anda</p>
                </div>
                <a href="{{ route('categories') }}" class="flex items-center gap-2 text-green-400 hover:text-green-300 hover:gap-3 transition-all text-sm">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $iconMap = [
                        'beras-grain'      => ['icon' => 'fa-wheat-awn',      'color' => 'from-amber-500 to-yellow-500'],
                        'beras'            => ['icon' => 'fa-wheat-awn',      'color' => 'from-amber-500 to-yellow-500'],
                        'gandum'           => ['icon' => 'fa-wheat-awn',      'color' => 'from-amber-500 to-yellow-500'],
                        'minyak'           => ['icon' => 'fa-droplet',        'color' => 'from-orange-500 to-red-500'],
                        'bahan-masak'      => ['icon' => 'fa-droplet',        'color' => 'from-orange-500 to-red-500'],
                        'telur'            => ['icon' => 'fa-egg',            'color' => 'from-yellow-400 to-orange-400'],
                        'susu'             => ['icon' => 'fa-glass-water',     'color' => 'from-blue-300 to-cyan-400'],
                        'bumbu'            => ['icon' => 'fa-pepper-hot',     'color' => 'from-yellow-600 to-amber-500'],
                        'masakan'          => ['icon' => 'fa-pepper-hot',     'color' => 'from-yellow-600 to-amber-500'],
                        'rempah'           => ['icon' => 'fa-pepper-hot',     'color' => 'from-yellow-600 to-amber-500'],
                        'mie'              => ['icon' => 'fa-bowl-food',       'color' => 'from-red-500 to-orange-500'],
                        'makanan-instan'   => ['icon' => 'fa-bowl-food',       'color' => 'from-red-500 to-orange-500'],
                        'minuman'          => ['icon' => 'fa-wine-bottle',     'color' => 'from-blue-500 to-cyan-500'],
                        'gula'             => ['icon' => 'fa-cube',           'color' => 'from-pink-500 to-rose-500'],
                        'garam'            => ['icon' => 'fa-cube',           'color' => 'from-pink-500 to-rose-500'],
                        'snack'            => ['icon' => 'fa-cookie',         'color' => 'from-pink-400 to-purple-500'],
                        'kue'              => ['icon' => 'fa-cookie',         'color' => 'from-pink-400 to-purple-500'],
                        'saus'             => ['icon' => 'fa-wine-glass',     'color' => 'from-red-700 to-red-500'],
                        'kecap'            => ['icon' => 'fa-wine-glass',      'color' => 'from-red-700 to-red-500'],
                        'sabun'            => ['icon' => 'fa-bottle-droplet', 'color' => 'from-teal-500 to-emerald-500'],
                        'deterjen'         => ['icon' => 'fa-bottle-droplet', 'color' => 'from-teal-500 to-emerald-500'],
                        'kebersihan'       => ['icon' => 'fa-bottle-droplet', 'color' => 'from-teal-500 to-emerald-500'],
                        'perawatan-rumah'  => ['icon' => 'fa-spray-can',      'color' => 'from-cyan-500 to-blue-500'],
                        'perlengkapan-dapur'=> ['icon' => 'fa-utensils',      'color' => 'from-gray-500 to-gray-700'],
                        'kaleng'           => ['icon' => 'fa-can-food',       'color' => 'from-purple-500 to-indigo-500'],
                    ];
                @endphp
                @forelse($categories as $i => $category)
                    @php
                        $mapped = null;
                        foreach ($iconMap as $key => $val) {
                            if (str_contains(strtolower($category->slug), $key) || str_contains(strtolower($category->name), $key)) {
                                $mapped = $val;
                                break;
                            }
                        }
                        $iconClass = $mapped['icon'] ?? ($category->icon ?? 'fa-box');
                        $iconColor = $mapped['color'] ?? 'from-green-500 to-emerald-500';
                    @endphp
                    <a href="{{ route('products', ['category' => $category->slug]) }}"
                       class="group reveal delay-{{ min(($i+1)*50, 400) }}">
                        <div class="cat-card glass-card rounded-2xl p-5 text-center">
                            <div class="cat-icon-wrap w-14 h-14 mx-auto mb-3 rounded-2xl bg-gradient-to-br {{ $iconColor }} flex items-center justify-center">
                                <i class="fas {{ $iconClass }} text-white text-xl"></i>
                            </div>
                            <h3 class="text-white font-medium text-sm leading-tight">{{ $category->name }}</h3>
                            <p class="text-white/50 text-xs mt-1">{{ $category->products_count ?? 0 }} produk</p>
                        </div>
                    </a>
                @empty
                    @php
                        $defaultCategories = [
                            ['name'=>'Beras & Gandum',      'icon'=>'fa-wheat-awn',      'color'=>'from-amber-500 to-yellow-500'],
                            ['name'=>'Minyak & Goreng',     'icon'=>'fa-droplet',        'color'=>'from-orange-500 to-red-500'],
                            ['name'=>'Gula & Garam',        'icon'=>'fa-cube',           'color'=>'from-pink-500 to-rose-500'],
                            ['name'=>'Makanan Kaleng',      'icon'=>'fa-can-food',       'color'=>'from-purple-500 to-indigo-500'],
                            ['name'=>'Minuman',             'icon'=>'fa-wine-bottle',     'color'=>'from-blue-500 to-cyan-500'],
                            ['name'=>'Mie & Pasta',         'icon'=>'fa-bowl-food',       'color'=>'from-red-500 to-orange-500'],
                            ['name'=>'Bumbu & Rempah',     'icon'=>'fa-pepper-hot',     'color'=>'from-yellow-600 to-amber-500'],
                            ['name'=>'Saus & Kecap',        'icon'=>'fa-wine-glass',     'color'=>'from-red-700 to-red-500'],
                            ['name'=>'Snack & Kue',        'icon'=>'fa-cookie',         'color'=>'from-pink-400 to-purple-500'],
                            ['name'=>'Sabun & Deterjen',   'icon'=>'fa-bottle-droplet', 'color'=>'from-teal-500 to-emerald-500'],
                            ['name'=>'Perawatan Rumah',     'icon'=>'fa-spray-can',      'color'=>'from-cyan-500 to-blue-500'],
                            ['name'=>'Perlengkapan Dapur', 'icon'=>'fa-utensils',       'color'=>'from-gray-500 to-gray-700'],
                        ];
                    @endphp
                    @foreach($defaultCategories as $i => $category)
                        <a href="{{ route('products') }}" class="group reveal delay-{{ min(($i+1)*50+100, 500) }}">
                            <div class="cat-card glass-card rounded-2xl p-5 text-center">
                                <div class="cat-icon-wrap w-14 h-14 mx-auto mb-3 rounded-2xl bg-gradient-to-br {{ $category['color'] }} flex items-center justify-center">
                                    <i class="fas {{ $category['icon'] }} text-white text-xl"></i>
                                </div>
                                <h3 class="text-white font-medium text-sm">{{ $category['name'] }}</h3>
                            </div>
                        </a>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    {{-- ==================== FEATURED PRODUCTS ==================== --}}
    <section class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between mb-8 reveal">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-white section-heading">Produk Unggulan</h2>
                    <p class="text-white/70 mt-2">Pilihan terbaik untuk kebutuhan harian Anda</p>
                </div>
                <a href="{{ route('products') }}" class="flex items-center gap-2 text-green-400 hover:text-green-300 hover:gap-3 transition-all text-sm">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $i => $product)
                    <div class="product-card glass-card rounded-2xl overflow-hidden group reveal delay-{{ min($i*100, 400) }}">
                        <div class="relative">
                            <div class="product-img-wrap aspect-square bg-gradient-to-br from-green-700/30 to-emerald-700/30 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-box text-white/40 text-6xl"></i>
                                @endif
                            </div>
                            <div class="absolute top-3 left-3 flex flex-col gap-1">
                                @if($product->is_featured)
                                    <span class="badge-feat bg-green-500 text-white text-xs font-semibold px-2 py-0.5 rounded-lg">Unggulan</span>
                                @endif
                            </div>
                            @if($product->original_price && $product->original_price > $product->price)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-lg">
                                        -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                    </span>
                                </div>
                            @endif
                            <div class="product-overlay absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center gap-3">
                                <a href="{{ route('product', $product->slug) }}"
                                   class="product-overlay-btn w-11 h-11 rounded-full bg-white flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors">
                                    <i class="fas fa-eye text-green-600 group-hover:text-current"></i>
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="product-overlay-btn w-11 h-11 rounded-full bg-white flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors">
                                        <i class="fas fa-shopping-cart text-green-600"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', $product->slug) }}">
                                <h3 class="text-white font-semibold mb-2 line-clamp-2 hover:text-green-400 transition-colors text-sm">{{ $product->name }}</h3>
                            </a>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-green-400 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <span class="text-white/40 text-xs line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            @if($product->unit)<span class="text-white/50 text-xs">/ {{ $product->unit }}</span>@endif
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center gap-1 text-yellow-400">
                                    <i class="fas fa-star text-xs"></i>
                                    <span class="text-white/60 text-xs">{{ number_format($product->rating, 1) }}
                                        @if($product->reviews_count ?? false)({{ $product->reviews_count }})@endif
                                    </span>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-tambah text-xs flex items-center gap-1 bg-green-500/20 hover:bg-green-500 text-green-400 hover:text-white px-3 py-1.5 rounded-lg">
                                        <i class="fas fa-cart-plus text-xs"></i> Tambah
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 reveal">
                        <i class="fas fa-box-open text-white/30 text-5xl mb-4"></i>
                        <p class="text-white/60">Belum ada produk unggulan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ==================== NEW PRODUCTS ==================== --}}
    <section class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between mb-8 reveal">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-white section-heading">Produk Terbaru</h2>
                    <p class="text-white/70 mt-2">Baru saja ditambahkan untuk Anda</p>
                </div>
                <a href="{{ route('products', ['sort' => 'latest']) }}" class="flex items-center gap-2 text-green-400 hover:text-green-300 hover:gap-3 transition-all text-sm">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($newProducts as $i => $product)
                    <div class="product-card glass-card rounded-2xl overflow-hidden group reveal delay-{{ min($i*100, 400) }}">
                        <div class="relative">
                            <div class="product-img-wrap aspect-square bg-gradient-to-br from-green-700/30 to-emerald-700/30 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-box text-white/40 text-6xl"></i>
                                @endif
                            </div>
                            <div class="absolute top-3 left-3">
                                <span class="bg-teal-500 text-white text-xs font-semibold px-2 py-0.5 rounded-lg">Baru</span>
                            </div>
                            @if($product->original_price && $product->original_price > $product->price)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-lg">
                                        -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                    </span>
                                </div>
                            @endif
                            <div class="product-overlay absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center gap-3">
                                <a href="{{ route('product', $product->slug) }}"
                                   class="product-overlay-btn w-11 h-11 rounded-full bg-white flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors">
                                    <i class="fas fa-eye text-green-600"></i>
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="product-overlay-btn w-11 h-11 rounded-full bg-white flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors">
                                        <i class="fas fa-shopping-cart text-green-600"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product', $product->slug) }}">
                                <h3 class="text-white font-semibold mb-2 line-clamp-2 hover:text-green-400 transition-colors text-sm">{{ $product->name }}</h3>
                            </a>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-green-400 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <span class="text-white/40 text-xs line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            @if($product->unit)<span class="text-white/50 text-xs">/ {{ $product->unit }}</span>@endif
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center gap-1 text-yellow-400">
                                    <i class="fas fa-star text-xs"></i>
                                    <span class="text-white/60 text-xs">{{ number_format($product->rating, 1) }}
                                        @if($product->reviews_count ?? false)({{ $product->reviews_count }})@endif
                                    </span>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-tambah text-xs flex items-center gap-1 bg-green-500/20 hover:bg-green-500 text-green-400 hover:text-white px-3 py-1.5 rounded-lg">
                                        <i class="fas fa-cart-plus text-xs"></i> Tambah
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 reveal">
                        <i class="fas fa-box-open text-white/30 text-5xl mb-4"></i>
                        <p class="text-white/60">Belum ada produk terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ==================== PROMO BANNER ==================== --}}
    <section class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="reveal">
                <div class="glass-card rounded-3xl overflow-hidden bg-gradient-to-r from-green-600 via-emerald-500 to-teal-500">
                    <div class="flex flex-col lg:flex-row items-center gap-8 p-8 lg:p-12">
                        <div class="flex-1 text-center lg:text-left">
                            <span class="inline-block bg-white/20 text-white px-4 py-1 rounded-full text-sm font-medium mb-4">
                                <i class="fas fa-fire mr-2"></i>Promo Terbatas
                            </span>
                            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-3">Diskon Hingga 50%</h2>
                            <p class="text-white/80 mb-6">Jangan lewatkan promo mingguan spesial untuk produk pilihan!</p>

                            {{-- Live Countdown --}}
                            <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-8"
                                 x-data="{
                                     seconds: 7 * 3600 + 32 * 60 + 45,
                                     get h() { return String(Math.floor(this.seconds / 3600)).padStart(2, '0') },
                                     get m() { return String(Math.floor((this.seconds % 3600) / 60)).padStart(2, '0') },
                                     get s() { return String(this.seconds % 60).padStart(2, '0') },
                                     init() { setInterval(() => { if (this.seconds > 0) this.seconds-- }, 1000) }
                                 }"
                                 x-init="init">
                                <div class="glass-card px-5 py-3 text-center min-w-[68px]">
                                    <span class="text-2xl font-bold text-white cd-number" x-text="h"></span>
                                    <p class="text-xs text-white/70 mt-0.5">Jam</p>
                                </div>
                                <div class="glass-card px-5 py-3 text-center min-w-[68px]">
                                    <span class="text-2xl font-bold text-white cd-number" x-text="m"></span>
                                    <p class="text-xs text-white/70 mt-0.5">Menit</p>
                                </div>
                                <div class="glass-card px-5 py-3 text-center min-w-[68px]">
                                    <span class="text-2xl font-bold text-white cd-number" x-text="s"></span>
                                    <p class="text-xs text-white/70 mt-0.5">Detik</p>
                                </div>
                            </div>

                            <a href="{{ route('products') }}"
                               class="promo-btn inline-flex items-center gap-2 bg-white text-green-600 px-8 py-3.5 rounded-xl font-semibold">
                                Belanja Sekarang <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="flex-1 hidden lg:flex justify-center">
                            <div class="promo-icon-wrap relative">
                                <div class="w-56 h-56 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-tags text-white text-8xl"></i>
                                </div>
                                <div class="promo-disc-badge absolute -top-3 -right-3 w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <span class="text-green-800 font-bold text-lg">50%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== WHY US ==================== --}}
    <section class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-10 reveal">
                <h2 class="text-2xl lg:text-3xl font-bold text-white section-heading inline-block">Mengapa Pilih Kami?</h2>
                <p class="text-white/70 mt-3">Keunggulan yang kami jamin untuk setiap pelanggan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $whyUs = [
                        ['icon'=>'fas fa-truck-fast',   'color'=>'from-green-500 to-emerald-500',  'title'=>'Pengiriman Cepat',   'desc'=>'Express ke seluruh Indonesia, sampai kurang dari 24 jam'],
                        ['icon'=>'fas fa-shield-halved','color'=>'from-blue-500 to-cyan-500',       'title'=>'Produk Original',   'desc'=>'100% original, kualitas terjamin dan terverifikasi'],
                        ['icon'=>'fas fa-headset',      'color'=>'from-purple-500 to-pink-500',     'title'=>'Layanan 24/7',      'desc'=>'Tim support siap membantu kapan pun Anda butuh'],
                        ['icon'=>'fas fa-tags',         'color'=>'from-orange-500 to-red-500',      'title'=>'Harga Bersaing',    'desc'=>'Harga terbaik dengan promo spesial setiap minggu'],
                    ];
                @endphp
                @foreach($whyUs as $i => $item)
                    <div class="why-card glass-card rounded-2xl p-6 text-center reveal delay-{{ $i*100 }}">
                        <div class="why-icon-wrap w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br {{ $item['color'] }} flex items-center justify-center">
                            <i class="{{ $item['icon'] }} text-white text-2xl"></i>
                        </div>
                        <h3 class="text-white font-semibold mb-2">{{ $item['title'] }}</h3>
                        <p class="text-white/60 text-sm">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== TESTIMONIALS ==================== --}}
    <section class="py-16">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-10 reveal">
                <h2 class="text-2xl lg:text-3xl font-bold text-white section-heading inline-block">Kata Pelanggan Kami</h2>
                <p class="text-white/70 mt-3">Lebih dari 10.000 pelanggan puas berbelanja di sini</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @php
                    $testimonials = [
                        ['name'=>'Budi Santoso', 'location'=>'Jakarta',  'comment'=>'Pelayanan sangat memuaskan! Barang datang tepat waktu dan kondisinya sempurna.', 'rating'=>5],
                        ['name'=>'Siti Rahayu',  'location'=>'Bandung',  'comment'=>'Harga sangat terjangkau, cocok banget buat belanja bulanan keluarga besar.', 'rating'=>5],
                        ['name'=>'Ahmad Fauzi',  'location'=>'Surabaya', 'comment'=>'Recommend banget! Stok selalu lengkap dan proses checkoutnya mudah sekali.', 'rating'=>4],
                    ];
                @endphp
                @foreach($testimonials as $i => $t)
                    <div class="testi-card glass-card rounded-2xl p-6 reveal delay-{{ $i*150 }}">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="testi-avatar w-11 h-11 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold">{{ substr($t['name'], 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-sm">{{ $t['name'] }}</h4>
                                <p class="text-white/60 text-xs">{{ $t['location'] }}</p>
                            </div>
                        </div>
                        <div class="flex gap-0.5 mb-3">
                            @for($j = 0; $j < 5; $j++)
                                <i class="fas fa-star text-sm {{ $j < $t['rating'] ? 'text-yellow-400' : 'text-white/20' }}"
                                   style="{{ $j < $t['rating'] ? 'animation: bounce-in 0.4s '.($j*0.08+0.2).'s ease both;' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="text-white/75 text-sm italic leading-relaxed">"{{ $t['comment'] }}"</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== SCRIPTS ==================== --}}
    <script>
        // Smooth Scroll Reveal via IntersectionObserver
        (function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -80px 0px'
            });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        })();
    </script>

@endsection