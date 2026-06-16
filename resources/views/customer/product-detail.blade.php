@extends('layouts.customer')

@section('title', $product->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-400 via-green-500 to-green-600 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm mb-8">
            <a href="{{ route('home') }}" class="text-green-200/60 hover:text-white transition">Beranda</a>
            <svg class="w-3 h-3 text-green-200/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('products') }}" class="text-green-200/60 hover:text-white transition">Produk</a>
            <svg class="w-3 h-3 text-green-200/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-green-400">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Product Image -->
            <div class="glass-card" x-data="{ selectedImage: 0 }">
                <div class="relative mb-6">
                    <div class="aspect-square bg-gradient-to-br from-green-600/30 to-green-700/30 rounded-2xl flex items-center justify-center">
                        @if ($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <svg class="w-32 h-32 text-green-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        @endif
                    </div>
                    @if ($product->discount > 0)
                        <div class="absolute top-4 left-4">
                            <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-lg">-{{ $product->discount }}%</span>
                        </div>
                    @endif
                </div>

                @if ($product->images && count($product->images) > 1)
                    <div class="flex gap-4">
                        @foreach ($product->images as $index => $image)
                            <button @click="selectedImage = {{ $index }}"
                                class="w-20 h-20 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition"
                                :class="selectedImage === {{ $index }} ? 'ring-2 ring-green-500' : ''">
                                <img src="{{ $image }}" alt="" class="w-full h-full object-cover rounded-xl">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <span class="inline-block bg-green-500/20 text-green-400 text-sm px-3 py-1 rounded-full mb-4">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.404.549l.355.355A.511.511 0 0113 4.11v4.89a4.511 4.511 0 01-4.11 4.11H7"></path>
                    </svg>
                    {{ $product->category->name ?? 'Sembako' }}
                </span>
                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4">{{ $product->name }}</h1>

                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-1 text-yellow-400">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5" fill="{{ $i <= round($product->rating) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        @endfor
                        <span class="text-green-200/60 ml-2">({{ $product->reviews_count ?? 0 }} ulasan)</span>
                    </div>
                    <span class="text-green-200/30">|</span>
                    <span class="text-green-200/60">{{ $product->sold_count ?? 0 }} Terjual</span>
                </div>

                <div class="glass-card rounded-2xl p-6 mb-6">
                    @if ($product->original_price > $product->price)
                        <span class="text-green-200/60 line-through text-lg">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    @endif
                    <div class="flex items-end gap-3 mt-2">
                        <span class="text-4xl font-bold text-green-400">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if ($product->unit)
                            <span class="text-green-200/60 text-lg">/ {{ $product->unit }}</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-4 mb-8" x-data="{ quantity: 1, maxStock: {{ $product->stock }} }">
                    <!-- Quantity -->
                    <div>
                        <label class="text-green-200/80 text-sm font-medium mb-3 block">Jumlah</label>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <button @click="quantity > 1 ? quantity-- : quantity = 1"
                                    class="w-12 h-12 rounded-l-xl glass flex items-center justify-center hover:bg-white/20 transition">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" x-model="quantity" min="1" :max="maxStock"
                                    class="w-20 h-12 glass-input text-center text-white font-medium text-lg">
                                <button @click="quantity < maxStock ? quantity++ : quantity = maxStock"
                                    class="w-12 h-12 rounded-r-xl glass flex items-center justify-center hover:bg-white/20 transition">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-green-200/60 text-sm">Stok: <span class="text-green-400">{{ $product->stock }}</span></span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8" x-data="{ added: false }">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1" @submit.prevent="addToCart">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1" x-ref="quantity">
                        <button type="submit" @click="added = true; setTimeout(() => added = false, 2000)"
                            class="w-full glass-btn px-6 py-4 rounded-xl text-white font-semibold flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                    <a href="{{ route('checkout') }}" class="flex-1">
                        <button type="button" class="w-full bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-xl text-white font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Beli Sekarang
                        </button>
                    </a>
                </div>

                <!-- Features -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <div>
                            <p class="text-white text-sm font-medium">Gratis Ongkir</p>
                            <p class="text-green-200/50 text-xs">Min. Belanja Rp 100rb</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div>
                            <p class="text-white text-sm font-medium">Garansi 7 Hari</p>
                            <p class="text-green-200/50 text-xs">Pengembalian Dana</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-white text-sm font-medium">Produk Original</p>
                            <p class="text-green-200/50 text-xs">100% Autentik</p>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <div>
                            <p class="text-white text-sm font-medium">Support 24/7</p>
                            <p class="text-green-200/50 text-xs">Selalu Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <section class="mt-12">
            <div class="glass-card rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">Deskripsi Produk</h2>
                <div class="prose prose-invert max-w-none text-green-100">
                    {!! $product->description !!}
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
                        <div class="text-5xl font-bold text-green-400">{{ number_format($product->rating, 1) }}</div>
                        <div class="flex gap-1 text-yellow-400 my-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5" fill="{{ $i <= round($product->rating) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-green-200/60 text-sm">{{ $product->reviews_count ?? 0 }} Ulasan</p>
                    </div>
                    <div class="flex-1 space-y-2">
                        @foreach([5, 4, 3, 2, 1] as $star)
                            <div class="flex items-center gap-3">
                                <span class="text-green-200/60 text-sm w-12">{{ $star }} Star</span>
                                <div class="flex-1 h-2 bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $star == 5 ? '60' : ($star == 4 ? '25' : ($star == 3 ? '10' : ($star == 2 ? '3' : '2'))) }}%"></div>
                                </div>
                                <span class="text-green-200/60 text-sm w-8">{{ $star == 5 ? '77' : ($star == 4 ? '32' : ($star == 3 ? '13' : ($star == 2 ? '4' : '2'))) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="space-y-6">
                    @forelse ($product->reviews as $review)
                        <div class="border-b border-white/10 pb-6 last:border-0">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">{{ substr($review->user->name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="text-white font-medium">{{ $review->user->name ?? 'Customer' }}</h4>
                                        <span class="text-green-200/50 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex gap-1 mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-white/30' }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-green-100 text-sm">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-green-200/60 text-center py-8">Belum ada ulasan untuk produk ini.</p>
                    @endforelse
                </div>

                @if ($product->reviews_count > 3)
                    <div class="text-center mt-8">
                        <button class="glass px-6 py-3 rounded-xl text-white hover:bg-white/20 transition">
                            Lihat Lebih Banyak
                        </button>
                    </div>
                @endif
            </div>
        </section>

        <!-- Related Products -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="mt-12">
                <h2 class="text-2xl font-bold text-white mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('product', $related->slug) }}" class="glass-card rounded-2xl overflow-hidden group">
                            <div class="aspect-square bg-gradient-to-br from-green-600/30 to-green-700/30 flex items-center justify-center">
                                @if ($related->image)
                                    <img src="{{ $related->image }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-green-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-2 line-clamp-2 text-sm">{{ $related->name }}</h3>
                                <span class="text-green-400 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
