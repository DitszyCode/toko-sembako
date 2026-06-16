<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-xl font-bold text-green-400 mb-4">🛒 Toko Sembako</h3>
                <p class="text-gray-400 mb-4">
                    Toko sembako terpercaya untuk kebutuhan sehari-hari keluarga Indonesia.
                    Produk berkualitas dengan harga terjangkau.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-green-400 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.3c.685-1.304 2.313-1.857 3.699-1.24l14.24 6.207c2.096.914 2.524 3.515.957 5.802L17.79 24H.057zm13.392-6.04c-.098-.032-.16-.014-.276.035-1.525.677-2.747 1.021-4.16 1.021-1.413 0-2.635-.344-4.16-1.021-.116-.049-.178-.067-.276-.035C2.245 18.48 1 19.517 1 21.163v2.167c0 1.646 1.245 2.683 2.809 2.683l13.617-.001c1.564 0 2.809-1.037 2.809-2.683v-2.167c0-1.646-1.245-2.683-2.809-2.683z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-green-400 transition">Beranda</a></li>
                    <li><a href="{{ route('products') }}" class="text-gray-400 hover:text-green-400 transition">Produk</a></li>
                    <li><a href="{{ route('categories') }}" class="text-gray-400 hover:text-green-400 transition">Kategori</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-green-400 transition">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-green-400 transition">Kontak</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Layanan Pelanggan</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('orders') }}" class="text-gray-400 hover:text-green-400 transition">Pesanan Saya</a></li>
                    <li><a href="{{ route('cart') }}" class="text-gray-400 hover:text-green-400 transition">Keranjang Belanja</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-green-400 transition">Kebijakan Pengiriman</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-green-400 transition">Kebijakan Pengembalian</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-green-400 transition">FAQ</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-3">
                    <li class="flex items-start space-x-3">
                        <span class="text-green-400">📍</span>
                        <span class="text-gray-400">Jl. Pasar tradisional No. 123, Jakarta Selatan</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-green-400">📞</span>
                        <span class="text-gray-400">(021) 1234-5678</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-green-400">📱</span>
                        <span class="text-gray-400">+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-green-400">✉️</span>
                        <span class="text-gray-400">info@toko-sembako.com</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-green-400">🕐</span>
                        <span class="text-gray-400">Senin - Sabtu: 07:00 - 21:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Newsletter -->
        <div class="mt-8 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h4 class="text-lg font-semibold mb-2">Berlangganan Newsletter</h4>
                    <p class="text-gray-400">Dapatkan promo dan informasi terbaru dari kami</p>
                </div>
                <form class="flex w-full md:w-auto">
                    <input
                        type="email"
                        placeholder="Masukkan email Anda"
                        class="px-4 py-2 rounded-l-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-500 w-full md:w-64"
                    >
                    <button type="submit" class="bg-green-600 px-6 py-2 rounded-r-lg hover:bg-green-700 transition font-medium">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 pt-8 border-t border-gray-800 text-center">
            <p class="text-gray-500">
                &copy; {{ $currentYear }} Toko Sembako. Semua hak dilindungi.
            </p>
        </div>
    </div>
</footer>
