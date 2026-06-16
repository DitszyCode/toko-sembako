@extends('layouts.customer')

@section('title', 'Produk')

@push('styles')
<style>
    /* Scroll Reveal Animation */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.65s cubic-bezier(0.22,1,0.36,1),
                    transform 0.65s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.is-visible {
        opacity: 1 !important;
        transform: translate(0) !important;
    }
    .delay-100 { transition-delay: 0.10s !important; }
    .delay-200 { transition-delay: 0.20s !important; }
    .delay-300 { transition-delay: 0.30s !important; }
    .delay-400 { transition-delay: 0.40s !important; }

    .product-card {
        transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease;
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
    .product-card:hover .product-overlay {
        opacity: 1 !important;
    }
    .btn-tambah {
        transition: all 0.2s ease;
    }
    .btn-tambah:hover {
        transform: scale(1.05);
    }
    .btn-tambah:active {
        transform: scale(0.96);
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Produk</h1>
            <p class="text-white/70 mt-2">Temukan kebutuhan dapur Anda</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="lg:w-72 flex-shrink-0" x-data="{ filtersOpen: false }">
            <!-- Mobile Filter Toggle -->
            <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full glass-btn px-4 py-3 rounded-xl text-white font-medium flex items-center justify-center gap-2 mb-4">
                <i class="fas fa-filter"></i>
                Filter
            </button>

            <div class="glass-card rounded-2xl p-6" :class="{ 'hidden lg:block': !filtersOpen }">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-white font-semibold text-lg">Filter</h3>
                    <a href="{{ route('products') }}" class="text-green-400 hover:text-green-300 text-sm">Reset</a>
                </div>

                <!-- Search -->
                <form action="{{ route('products') }}" method="GET">
                    <div class="mb-6">
                        <h4 class="text-white/80 text-sm font-medium mb-3">Cari Produk</h4>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                                   class="w-full glass-input px-4 py-3 pl-10 rounded-xl text-white placeholder-white/60 text-sm">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/60"></i>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="text-white/80 text-sm font-medium mb-3">Kategori</h4>
                        <div class="space-y-2">
                            @forelse($categories as $category)
                                @if(is_object($category) && isset($category->slug))
                                    <a href="{{ route('products', ['category' => $category->slug, 'search' => request('search')]) }}"
                                       class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-white/10 transition text-sm {{ request('category') == $category->slug ? 'bg-green-500/20 text-green-400' : 'text-white/70' }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="text-white/50 text-xs">({{ $category->products_count ?? 0 }})</span>
                                    </a>
                                @endif
                            @empty
                                <p class="text-white/50 text-sm py-2">Tidak ada kategori</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="text-white/80 text-sm font-medium mb-3">Rentang Harga</h4>
                        <div class="flex flex-col gap-3">
                            <div class="flex gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}"
                                       class="w-full glass-input px-3 py-2 rounded-lg text-white text-sm" placeholder="Min">
                                <input type="number" name="max_price" value="{{ request('max_price') }}"
                                       class="w-full glass-input px-3 py-2 rounded-lg text-white text-sm" placeholder="Max">
                            </div>
                            <button type="submit" class="w-full glass-btn px-4 py-2 rounded-lg text-white text-sm">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>

                <a href="{{ route('products') }}" class="block w-full text-center border border-green-500/30 text-green-400 hover:bg-green-500/10 px-4 py-3 rounded-xl text-sm transition">
                    Reset Semua Filter
                </a>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <!-- Sort & Results -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div class="text-white/70">
                    Menampilkan <span class="text-green-400 font-medium">{{ $products->count() }}</span> dari <span class="text-green-400 font-medium">{{ $products->total() }}</span> produk
                </div>
                <form action="{{ route('products') }}" method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    <select name="sort" onchange="this.form.submit()" class="glass-input px-4 py-2 rounded-xl text-white text-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </form>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('category') || request('min_price') || request('max_price'))
                <div class="flex flex-wrap gap-2 mb-6">
                    @if(request('search'))
                        <span class="inline-flex items-center gap-2 bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                            Pencarian: {{ request('search') }}
                            <a href="{{ route('products', array_filter(['category' => request('category'), 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'sort' => request('sort')])) }}" class="hover:text-white">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        </span>
                    @endif
                    @if(request('category') && $categories->where('slug', request('category'))->first())
                        <span class="inline-flex items-center gap-2 bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                            Kategori: {{ $categories->where('slug', request('category'))->first()->name }}
                            <a href="{{ route('products', array_filter(['search' => request('search'), 'min_price' => request('min_price'), 'max_price' => request('max_price'), 'sort' => request('sort')])) }}" class="hover:text-white">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        </span>
                    @endif
                </div>
            @endif

            <!-- Products -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="product-card glass-card rounded-2xl overflow-hidden group">
                            <div class="relative">
                                <div class="product-img-wrap aspect-square bg-gradient-to-br from-green-700/30 to-emerald-700/30 flex items-center justify-center overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-box text-white/40 text-6xl"></i>
                                    @endif
                                </div>

                                <!-- Badges -->
                                @if($product->is_featured)
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-lg">Unggulan</span>
                                    </div>
                                @endif

                                <!-- Stock Status -->
                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="bg-red-500 text-white px-4 py-2 rounded-full font-semibold text-sm">Stok Habis</span>
                                    </div>
                                @endif

                                <!-- Hover Overlay -->
                                <div class="product-overlay absolute inset-0 bg-black/50 opacity-0 flex items-center justify-center gap-3">
                                    <a href="{{ route('product', $product->slug) }}" class="w-12 h-12 rounded-full bg-white flex items-center justify-center hover:bg-green-500 hover:text-white transition-all">
                                        <i class="fas fa-eye text-green-600"></i>
                                    </a>
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-12 h-12 rounded-full bg-white flex items-center justify-center hover:bg-green-500 hover:text-white transition-all">
                                                <i class="fas fa-shopping-cart text-green-600"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="p-5">
                                <a href="{{ route('product', $product->slug) }}" class="block">
                                    <h3 class="text-white font-semibold mb-2 line-clamp-2 hover:text-green-400 transition text-sm">{{ $product->name }}</h3>
                                </a>
                                <p class="text-white/50 text-xs mb-2">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>

                                <div class="flex items-baseline gap-2 mb-3">
                                    <span class="text-green-400 font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @if($product->unit)
                                        <span class="text-white/50 text-xs">/ {{ $product->unit }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                        <i class="fas fa-star"></i>
                                        <span class="text-white/60">{{ number_format($product->rating, 1) }}</span>
                                    </div>
                                    @if($product->stock > 0)
                                        <span class="text-green-400 text-xs"><i class="fas fa-check-circle mr-1"></i>Tersedia</span>
                                    @else
                                        <span class="text-red-400 text-xs"><i class="fas fa-times-circle mr-1"></i>Habis</span>
                                    @endif
                                </div>

                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-tambah w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <div class="glass-card rounded-2xl p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-white/5 flex items-center justify-center">
                        <i class="fas fa-search text-white/30 text-4xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold mb-2">Tidak Ada Produk</h3>
                    <p class="text-white/60 mb-6">Maaf, tidak ada produk yang cocok dengan filter Anda.</p>
                    <a href="{{ route('products') }}" class="inline-block glass-btn px-6 py-3 rounded-xl text-white font-medium">
                        Lihat Semua Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
