<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toko Sembako')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 font-poppins">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Toko Sembako</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition font-medium">Beranda</a>
                    <a href="{{ route('products') }}" class="text-gray-700 hover:text-green-600 transition font-medium">Produk</a>
                    <a href="{{ route('categories') }}" class="text-gray-700 hover:text-green-600 transition font-medium">Kategori</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-green-600 transition font-medium">Tentang</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-green-600 transition font-medium">Kontak</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart') }}" class="relative w-10 h-10 rounded-lg hover:bg-gray-100 flex items-center justify-center transition">
                        <i class="fas fa-shopping-cart text-gray-700"></i>
                        @auth
                            @if(\Cart::count() > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full text-xs flex items-center justify-center font-bold text-white">
                                    {{ \Cart::count() }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 px-5 py-2 rounded-lg text-white font-medium transition">
                            Masuk
                        </a>
                    @endguest

                    @auth
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="hidden md:block text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                                 class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-lg border overflow-hidden">
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                    <i class="fas fa-user-circle"></i>
                                    Profil
                                </a>
                                <a href="{{ route('orders') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                    <i class="fas fa-box"></i>
                                    Pesanan
                                </a>
                                <hr class="border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-gray-50 transition">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="container mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-store text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold">Toko Sembako</span>
                    </a>
                    <p class="text-gray-400 text-sm">Toko sembako terpercaya，提供优质日常用品和食品。</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('products') }}" class="hover:text-white transition">Produk</a></li>
                        <li><a href="{{ route('categories') }}" class="hover:text-white transition">Kategori</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kategori</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Beras & Gandum</a></li>
                        <li><a href="#" class="hover:text-white transition">Minyak & Goreng</a></li>
                        <li><a href="#" class="hover:text-white transition">Sembako Umum</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-phone mr-2"></i>+62 812-3456-7890</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@tokosembako.com</li>
                    </ul>
                </div>
            </div>
            <hr class="border-gray-800 my-8">
            <p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} Toko Sembako. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
