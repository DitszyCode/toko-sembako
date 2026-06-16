<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group cursor-pointer">
    <a href="{{ route('categories') }}/{{ $category->slug }}">
        <div class="p-6 text-center">
            <!-- Icon -->
            <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors duration-300">
                <span class="text-4xl group-hover:text-white transition-colors duration-300">
                    @switch($category->icon)
                        @case('rice')
                            🍚
                        @break
                        @case('oil')
                            🛢️
                        @break
                        @case('sugar')
                            🍬
                        @break
                        @case('flour')
                            🌾
                        @break
                        @case('coffee')
                            ☕
                        @break
                        @case('snacks')
                            🍪
                        @break
                        @case('drinks')
                            🥤
                        @break
                        @case('toiletries')
                            🧴
                        @break
                        @case('detergents')
                            🧺
                        @break
                        @case('spices')
                            🌶️
                        @break
                        @default
                            📦
                    @endswitch
                </span>
            </div>

            <!-- Category Name -->
            <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-green-600 transition-colors duration-300">
                {{ $category->name }}
            </h3>

            <!-- Product Count -->
            <p class="text-sm text-gray-500 mb-4">
                {{ $productCount }} Produk
            </p>

            <!-- View Products Button -->
            <span class="inline-flex items-center text-green-600 font-medium group-hover:text-green-700 transition-colors duration-300">
                Lihat Produk
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </div>
    </a>
</div>
