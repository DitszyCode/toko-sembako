<div x-data="{ isLoading: @entangle('isLoading') }">
    <!-- Loading Overlay -->
    <div x-show="isLoading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-8 w-8 text-green-600 mb-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-600">Memuat...</span>
        </div>
    </div>

    @if(count($items) > 0)
        <!-- Cart Items -->
        <div class="space-y-4">
            @foreach($items as $item)
                <div class="bg-white rounded-xl shadow-md p-4 flex flex-col sm:flex-row gap-4" wire:key="{{ $item['id'] }}">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        <img
                            src="{{ $item['image'] ? asset('storage/' . $item['image']) : asset('images/no-image.png') }}"
                            alt="{{ $item['name'] }}"
                            class="w-24 h-24 object-cover rounded-lg"
                        >
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('product'), $item['product_id']) }}" class="font-semibold text-gray-800 hover:text-green-600 transition line-clamp-1">
                            {{ $item['name'] }}
                        </a>
                        <p class="text-sm text-gray-500 mt-1">
                            @if($item['price'] < $item['original_price'])
                                <span class="text-green-600 font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                <span class="text-gray-400 line-through text-xs ml-1">Rp {{ number_format($item['original_price'], 0, ',', '.') }}</span>
                            @else
                                <span class="text-green-600 font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            @endif
                            <span class="text-xs">/ {{ $item['stock'] > 0 ? 'unit' : 'unit' }}</span>
                        </p>

                        <!-- Quantity Controls -->
                        <div class="flex items-center mt-3">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button
                                    wire:click="updateQuantity({{ $item['product_id'] }}, {{ max(1, $item['quantity'] - 1) }})"
                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition"
                                >
                                    -
                                </button>
                                <input
                                    type="number"
                                    wire:change="updateQuantity({{ $item['product_id'] }}, $event.target.value)"
                                    value="{{ $item['quantity'] }}"
                                    min="1"
                                    max="{{ $item['stock'] }}"
                                    class="w-16 text-center border-none focus:outline-none text-sm"
                                >
                                <button
                                    wire:click="updateQuantity({{ $item['product_id'] }}, {{ min($item['stock'], $item['quantity'] + 1) }})"
                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition"
                                >
                                    +
                                </button>
                            </div>

                            <button
                                wire:click="removeFromCart({{ $item['product_id'] }})"
                                wire:confirm="Hapus produk ini dari keranjang?"
                                class="ml-4 text-red-500 hover:text-red-700 transition"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-start">
                        <span class="text-sm text-gray-500 sm:hidden">Subtotal</span>
                        <span class="font-bold text-green-600 text-lg">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div class="mt-6 bg-white rounded-xl shadow-md p-6">
            <div class="space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal ({{ $itemCount }} item)</span>
                    <span>{{ $formattedSubtotal }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Ongkos Kirim</span>
                    <span class="{{ $shipping === 0 ? 'text-green-600 font-semibold' : '' }}">
                        {{ $formattedShipping }}
                    </span>
                </div>
                @if($shipping > 0)
                    <p class="text-xs text-gray-500">
                        💡 Belanja Rp 500.000 ke atas untuk gratis ongkir!
                    </p>
                @endif
                <hr>
                <div class="flex justify-between text-xl font-bold text-gray-800">
                    <span>Total</span>
                    <span class="text-green-600">{{ $formattedTotal }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 space-y-3">
                <a
                    href="{{ route('checkout') }}"
                    class="block w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition font-semibold text-center"
                >
                    Lanjutkan ke Pembayaran
                </a>
                <button
                    wire:click="clearCart"
                    wire:confirm="Kosongkan semua item di keranjang?"
                    class="block w-full border border-red-500 text-red-500 py-2 px-6 rounded-lg hover:bg-red-50 transition text-center"
                >
                    Kosongkan Keranjang
                </button>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Keranjang Kosong</h3>
            <p class="text-gray-500 mb-6">Belum ada produk di keranjang belanja Anda</p>
            <a
                href="{{ route('products') }}"
                class="inline-block bg-green-600 text-white py-3 px-8 rounded-lg hover:bg-green-700 transition font-semibold"
            >
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
