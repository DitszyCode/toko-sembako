@extends('layouts.customer')

@section('title', 'Detail Produk')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm mb-8">
        <a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Beranda</a>
        <i class="fas fa-chevron-right text-white/30 text-xs"></i>
        <a href="{{ route('products') }}" class="text-white/60 hover:text-white transition">Produk</a>
        <i class="fas fa-chevron-right text-white/30 text-xs"></i>
        <span class="text-green-400">Beras Premium 5kg</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        <!-- Product Image -->
        <div class="glass-card rounded-3xl p-8" x-data="{ selectedImage: 0 }">
            <div class="relative mb-6">
                <div class="aspect-square bg-gradient-to-br from-green-700/30 to-emerald-700/30 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-wheat-awn text-white/50 text-[10rem]"></i>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-lg">-12%</span>
                </div>
            </div>
            <div class="flex gap-4">
                @for($i = 0; $i < 4; $i++)
                    <button @click="selectedImage = {{ $i }}"
                            class="w-20 h-20 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition"
                            :class="selectedImage === {{ $i }} ? 'ring-2 ring-green-500' : ''">
                        <i class="fas fa-wheat-awn text-white/50"></i>
                    </button>
                @endfor
            </div>
        </div>

        <!-- Product Info -->
        <div>
            <span class="inline-block bg-green-500/20 text-green-400 text-sm px-3 py-1 rounded-full mb-4">
                <i class="fas fa-tag mr-1"></i> Bebas Ongkir
            </span>
            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4">Beras Premium 5kg</h1>

            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center gap-1 text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="text-white/60 ml-2">4.5 (128 ulasan)</span>
                </div>
                <span class="text-white/30">|</span>
                <span class="text-white/60">150 Terjual</span>
            </div>

            <div class="glass-card rounded-2xl p-6 mb-6">
                <span class="text-white/60 line-through text-lg">Rp 85.000</span>
                <div class="flex items-end gap-3 mt-2">
                    <span class="text-4xl font-bold text-green-400">Rp 75.000</span>
                    <span class="bg-red-500 text-white text-sm px-2 py-1 rounded-lg font-medium">HEMAT 12%</span>
                </div>
            </div>

            <div class="space-y-4 mb-8">
                <!-- Quantity -->
                <div>
                    <label class="text-white/80 text-sm font-medium mb-3 block">Jumlah</label>
                    <div class="flex items-center gap-4" x-data="{ qty: 1 }">
                        <div class="flex items-center">
                            <button @click="qty > 1 ? qty-- : qty = 1"
                                    class="w-12 h-12 rounded-l-xl glass flex items-center justify-center hover:bg-white/20 transition">
                                <i class="fas fa-minus text-white"></i>
                            </button>
                            <input type="number" x-model="qty" min="1" max="100"
                                   class="w-16 h-12 glass-input text-center text-white font-medium text-lg">
                            <button @click="qty++"
                                    class="w-12 h-12 rounded-r-xl glass flex items-center justify-center hover:bg-white/20 transition">
                                <i class="fas fa-plus text-white"></i>
                            </button>
                        </div>
                        <span class="text-white/60 text-sm">Stok: <span class="text-green-400">500</span></span>
                    </div>
                </div>

                <!-- Size -->
                <div>
                    <label class="text-white/80 text-sm font-medium mb-3 block">Ukuran</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach(['1kg', '2kg', '5kg', '10kg'] as $index => $size)
                            <button class="px-6 py-3 rounded-xl glass hover:bg-white/20 transition {{ $index === 2 ? 'ring-2 ring-green-500' : '' }}">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-8" x-data="{ added: false }">
                <button @click="added = true; setTimeout(() => added = false, 2000)"
                        class="flex-1 glass-btn px-6 py-4 rounded-xl text-white font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span x-text="added ? 'Ditambahkan!' : 'Tambah ke Keranjang'"></span>
                </button>
                <button class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4 rounded-xl text-white font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition">
                    <i class="fas fa-bolt"></i>
                    Beli Sekarang
                </button>
            </div>

            <!-- Features -->
            <div class="grid grid-cols-2 gap-4">
                <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                    <i class="fas fa-truck text-green-400 text-xl"></i>
                    <div>
                        <p class="text-white text-sm font-medium">Gratis Ongkir</p>
                        <p class="text-white/50 text-xs">Min. Belanja Rp 100rb</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                    <i class="fas fa-shield-halved text-green-400 text-xl"></i>
                    <div>
                        <p class="text-white text-sm font-medium">Garansi 7 Hari</p>
                        <p class="text-white/50 text-xs">Pengembalian Dana</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                    <i class="fas fa-certificate text-green-400 text-xl"></i>
                    <div>
                        <p class="text-white text-sm font-medium">Produk Original</p>
                        <p class="text-white/50 text-xs">100% Autentik</p>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                    <i class="fas fa-headset text-green-400 text-xl"></i>
                    <div>
                        <p class="text-white text-sm font-medium">Support 24/7</p>
                        <p class="text-white/50 text-xs">Selalu Online</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <section class="mt-12">
        <div class="glass-card rounded-3xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Deskripsi Produk</h2>
            <div class="prose prose-invert max-w-none text-white/80">
                <p>Beras Premium 5kg adalah pilihan sempurna untuk kebutuhan dapur Anda sehari-hari. Dibuat dari beras pilihan berkualitas tinggi, memastikan setiap butir nasi memiliki tekstur yang pulen dan aroma yang sedap.</p>
                <h3 class="text-white font-semibold mt-6">Keunggulan:</h3>
                <ul class="list-disc list-inside space-y-2">
                    <li>Beras pilihan grade A dengan mutu terjamin</li>
                    <li>Tekstur nasi pulen dan tidak lengket</li>
                    <li>Aroma wangi alami saat dimasak</li>
                    <li>Cocok untuk semua jenis masakan Indonesia</li>
                    <li>Dikemas dalam kemasan kedap udara untuk menjaga kesegaran</li>
                </ul>
                <h3 class="text-white font-semibold mt-6">Informasi Produk:</h3>
                <ul class="list-disc list-inside space-y-2">
                    <li>Berat: 5kg</li>
                    <li>Jenis: Premium</li>
                    <li>Asal: Jawa Barat</li>
                    <li>Expired: 12 bulan dari tanggal produksi</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Reviews -->
    <section class="mt-12">
        <div class="glass-card rounded-3xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Ulasan Produk</h2>
                <button class="glass-btn px-4 py-2 rounded-xl text-white font-medium text-sm">
                   Tulis Ulasan
                </button>
            </div>

            <!-- Rating Summary -->
            <div class="flex items-center gap-8 mb-8 pb-8 border-b border-white/10">
                <div class="text-center">
                    <div class="text-5xl font-bold text-green-400">4.5</div>
                    <div class="flex gap-1 text-yellow-400 my-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-white/60 text-sm">128 Ulasan</p>
                </div>
                <div class="flex-1 space-y-2">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        <div class="flex items-center gap-3">
                            <span class="text-white/60 text-sm w-12">{{ $star }} Star</span>
                            <div class="flex-1 h-2 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $star == 5 ? '60' : ($star == 4 ? '25' : ($star == 3 ? '10' : ($star == 2 ? '3' : '2'))) }}%"></div>
                            </div>
                            <span class="text-white/60 text-sm w-8">{{ $star == 5 ? '77' : ($star == 4 ? '32' : ($star == 3 ? '13' : ($star == 2 ? '4' : '2'))) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Reviews List -->
            <div class="space-y-6">
                @php
                    $reviews = [
                        ['name' => 'Andi Wijaya', 'date' => '2 hari lalu', 'rating' => 5, 'comment' => 'Berasnya sangat berkualitas! Nasinya pulen dan wangi. Sudah berulang kali beli di sini dan selalu puas.'],
                        ['name' => 'Dewi Lestari', 'date' => '1 minggu lalu', 'rating' => 4, 'comment' => 'Produk sesuai ekspektasi. Pengiriman cepat dan kemasan aman. Kurang satu bintang karena harga naik sedikit.'],
                        ['name' => 'Budi Santoso', 'date' => '2 minggu lalu', 'rating' => 5, 'comment' => 'Recommended banget! Harga lebih murah dari toko lain dan kualitas tetap bagus.'],
                    ];
                @endphp

                @foreach($reviews as $review)
                    <div class="border-b border-white/10 pb-6 last:border-0">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold">{{ substr($review['name'], 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h4 class="text-white font-medium">{{ $review['name'] }}</h4>
                                    <span class="text-white/50 text-sm">{{ $review['date'] }}</span>
                                </div>
                                <div class="flex gap-1 mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star {{ $i < $review['rating'] ? 'text-yellow-400' : 'text-white/30' }} text-sm"></i>
                                    @endfor
                                </div>
                                <p class="text-white/70 text-sm">{{ $review['comment'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Load More -->
            <div class="text-center mt-8">
                <button class="glass px-6 py-3 rounded-xl text-white hover:bg-white/20 transition">
                    Lihat Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="mt-12">
        <h2 class="text-2xl font-bold text-white mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $relatedProducts = [
                    ['name' => 'Beras Medium 5kg', 'price' => 'Rp 65.000', 'image' => 'fa-wheat-awn'],
                    ['name' => 'Beras Organik 5kg', 'price' => 'Rp 95.000', 'image' => 'fa-wheat-awn'],
                    ['name' => 'Minyak Goreng 2L', 'price' => 'Rp 32.000', 'image' => 'fa-droplet'],
                    ['name' => 'Tepung Beras 1kg', 'price' => 'Rp 18.000', 'image' => 'fa-wheat-awn'],
                ];
            @endphp

            @foreach($relatedProducts as $product)
                <div class="glass-card rounded-2xl overflow-hidden group">
                    <div class="aspect-square bg-gradient-to-br from-green-700/30 to-emerald-700/30 flex items-center justify-center">
                        <i class="fas {{ $product['image'] }} text-white/50 text-4xl"></i>
                    </div>
                    <div class="p-4">
                        <h3 class="text-white font-medium mb-2 line-clamp-2 text-sm">{{ $product['name'] }}</h3>
                        <span class="text-green-400 font-bold">{{ $product['price'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection