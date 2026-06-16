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
        @php
            $categories = [
                [
                    'name' => 'Beras & Gandum',
                    'icon' => 'fa-wheat-awn',
                    'color' => 'from-amber-500 to-yellow-500',
                    'bg' => 'bg-amber-500/20',
                    'count' => 45,
                    'description' => 'Beras premium, beras medium, tepung terigu, tepung beras, dan lainnya'
                ],
                [
                    'name' => 'Minyak & Goreng',
                    'icon' => 'fa-droplet',
                    'color' => 'from-orange-500 to-red-500',
                    'bg' => 'bg-orange-500/20',
                    'count' => 28,
                    'description' => 'Minyak goreng, minyak zaitun, minyak kelapa, dan bahan masakan lainnya'
                ],
                [
                    'name' => 'Gula & Garam',
                    'icon' => 'fa-cube',
                    'color' => 'from-pink-500 to-rose-500',
                    'bg' => 'bg-pink-500/20',
                    'count' => 32,
                    'description' => 'Gula pasir, gula merah, garam dapur, garam himalaya'
                ],
                [
                    'name' => 'Makanan Kaleng',
                    'icon' => 'fa-can-food',
                    'color' => 'from-purple-500 to-indigo-500',
                    'bg' => 'bg-purple-500/20',
                    'count' => 56,
                    'description' => 'Sarden, Kornet, Sayuran kaleng, Buah kaleng'
                ],
                [
                    'name' => 'Minuman',
                    'icon' => 'fa-wine-bottle',
                    'color' => 'from-blue-500 to-cyan-500',
                    'bg' => 'bg-blue-500/20',
                    'count' => 78,
                    'description' => 'Kopi, Teh, Susu, Minuman kemasan, Sari buah'
                ],
                [
                    'name' => 'Mie & Pasta',
                    'icon' => 'fa-bowl-food',
                    'color' => 'from-red-500 to-orange-500',
                    'bg' => 'bg-red-500/20',
                    'count' => 42,
                    'description' => 'Mie instan, Mie telur, Spaghetti, Makaroni'
                ],
                [
                    'name' => 'Bumbu & Rempah',
                    'icon' => 'fa-pepper-hot',
                    'color' => 'from-yellow-600 to-amber-500',
                    'bg' => 'bg-yellow-600/20',
                    'count' => 65,
                    'description' => 'Bumbu dapur, Lada, Ketumbar, Jintan, Kayu manis'
                ],
                [
                    'name' => 'Saus & Kecap',
                    'icon' => 'fa-wine-glass',
                    'color' => 'from-red-700 to-red-500',
                    'bg' => 'bg-red-700/20',
                    'count' => 38,
                    'description' => 'Saus sambal, Saus tiram, Kecap manis, Kecap asin'
                ],
                [
                    'name' => 'Snack & Kue',
                    'icon' => 'fa-cookie',
                    'color' => 'from-pink-400 to-purple-500',
                    'bg' => 'bg-pink-400/20',
                    'count' => 89,
                    'description' => 'Biskuit, Keripik, Permen, Cokelat, Kue kering'
                ],
                [
                    'name' => 'Sabun & Deterjen',
                    'icon' => 'fa-bottle-droplet',
                    'color' => 'from-teal-500 to-emerald-500',
                    'bg' => 'bg-teal-500/20',
                    'count' => 54,
                    'description' => 'Sabun mandi, Sabun cuci, Deterjen, Pewangi'
                ],
                [
                    'name' => 'Perawatan Rumah',
                    'icon' => 'fa-spray-can',
                    'color' => 'from-cyan-500 to-blue-500',
                    'bg' => 'bg-cyan-500/20',
                    'count' => 47,
                    'description' => 'Pembersih lantai, Pengharum ruangan, Pembasmi serangga'
                ],
                [
                    'name' => 'Perlengkapan Dapur',
                    'icon' => 'fa-utensils',
                    'color' => 'from-gray-500 to-gray-700',
                    'bg' => 'bg-gray-500/20',
                    'count' => 36,
                    'description' => 'Peralatan masak, Wadah makanan, Al面 foil, Plastik'
                ],
            ];
        @endphp

        @foreach($categories as $category)
            <a href="{{ route('products') }}" class="glass-card rounded-2xl p-6 group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $category['color'] }} flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fas {{ $category['icon'] }} text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-white group-hover:text-green-400 transition">{{ $category['name'] }}</h3>
                            <span class="{{ $category['bg'] }} text-green-400 text-sm px-2 py-1 rounded-lg">{{ $category['count'] }} items</span>
                        </div>
                        <p class="text-white/60 text-sm">{{ $category['description'] }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Popular Brands -->
    <section class="mt-16">
        <h2 class="text-2xl font-bold text-white mb-8 text-center">Brand Populer</h2>
        <div class="flex flex-wrap justify-center gap-6">
            @php
                $brands = ['Beras Rojo', 'Minyak Bimoli', 'Gula Gulaku', 'Kopi Luwak', 'Teh Sariwangi', 'Mie Sedap', 'Saus Del Monte', 'Sabun Lux'];
            @endphp
            @foreach($brands as $brand)
                <a href="#" class="glass-card px-6 py-3 rounded-xl text-white hover:bg-white/20 transition flex items-center gap-2">
                    <i class="fas fa-award text-green-400"></i>
                    {{ $brand }}
                </a>
            @endforeach
        </div>
    </section>
</div>
@endsection