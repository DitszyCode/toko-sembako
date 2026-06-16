@extends('layouts.customer')

@section('title', 'Kategori')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4">Kategori Produk</h1>
        <p class="text-white/70 max-w-2xl mx-auto">Telusuri berbagai kategori produk Sembako berkualitas tinggi untuk kebutuhan sehari-hari keluarga Anda</p>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <a href="{{ route('products', ['category' => $category->slug]) }}" class="glass-card rounded-2xl p-6 group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $category->color ?? 'from-green-500 to-emerald-500' }} flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas {{ $category->icon ?? 'fa-box' }} text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-white group-hover:text-green-400 transition">{{ $category->name }}</h3>
                            <span class="bg-green-500/20 text-green-400 text-sm px-2 py-1 rounded-lg">{{ $category->products_count ?? 0 }} items</span>
                        </div>
                        <p class="text-white/60 text-sm">{{ $category->description ?? 'Produk berkualitas untuk kebutuhan sehari-hari' }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-tags text-white/30 text-5xl mb-4"></i>
                <p class="text-white/60">Belum ada kategori</p>
            </div>
        @endforelse
    </div>

    <!-- Popular Brands -->
    @if($brands->count() > 0)
    <section class="mt-16">
        <h2 class="text-2xl font-bold text-white mb-8 text-center">Brand Populer</h2>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($brands as $brand)
                <a href="{{ route('products', ['search' => $brand]) }}" class="glass-card px-6 py-3 rounded-xl text-white hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-award text-green-400"></i>
                    {{ $brand }}
                </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection