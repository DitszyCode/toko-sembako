<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
    <!-- Image Container -->
    <div class="relative overflow-hidden">
        <a href="{{ route('product', ['slug' => $product->slug]) }}">
            @if($product->image)
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                >
            @else
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118l-.625-10.632m1.5 0l2.124-6.451m-2.124 6.451l2.124 6.451" />
                    </svg>
                </div>
            @endif
        </a>

        <!-- Featured Badge -->
        @if($product->is_featured)
            <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                Unggulan
            </div>
        @endif

        <!-- Out of Stock Overlay -->
        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="bg-red-500 text-white px-4 py-2 rounded-full font-semibold">Stok Habis</span>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4">
        <!-- Category Badge -->
        <span class="inline-block bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full mb-2">
            {{ $product->category->name ?? 'Tanpa Kategori' }}
        </span>

        <!-- Product Name -->
        <a href="{{ route('product', ['slug' => $product->slug]) }}" class="block">
            <h3 class="font-semibold text-gray-800 mb-1 line-clamp-2 hover:text-green-600 transition">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Price -->
        <div class="mb-2">
            <span class="text-xl font-bold text-green-600">{{ $formattedPrice }}</span>
            <span class="text-xs text-gray-500 block">{{ $product->unit }} {{ $product->stock }} {{ $product->stock > 0 ? 'tersedia' : 'habis' }}</span>
        </div>

        <!-- Add to Cart -->
        @if($product->stock > 0)
            <button
                wire:click="addToCart"
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition font-medium flex items-center justify-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah
            </button>
        @else
            <button disabled class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                Stok Habis
            </button>
        @endif
    </div>
</div>
