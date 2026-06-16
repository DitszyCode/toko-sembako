<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toko Sembako') - Toko Sembako</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    colors: {
                        primary: '#22c55e',
                        secondary: '#16a34a',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Glassmorphism Classes */
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-btn {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .glass-btn:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
            outline: none;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Gradient Background */
        .gradient-bg {
            background: linear-gradient(135deg, #065f46 0%, #064e3b 50%, #022c22 100%);
            min-height: 100vh;
        }

        /* Decorative Circles */
        .circle-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.3) 0%, rgba(22, 163, 74, 0.1) 100%);
            top: -100px;
            right: -100px;
            filter: blur(60px);
        }

        .circle-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(21, 128, 61, 0.1) 100%);
            bottom: -50px;
            left: -50px;
            filter: blur(40px);
        }

        .circle-3 {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.1) 100%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            filter: blur(30px);
        }

        /* Toast Notification */
        .toast {
            animation: slideIn 0.3s ease forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-close {
            animation: slideOut 0.3s ease forwards;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(34, 197, 94, 0.5);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(34, 197, 94, 0.7);
        }
    </style>

    @stack('styles')
</head>
<body class="gradient-bg text-white font-poppins">
    <!-- Decorative Background Circles -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
    </div>

    <!-- Toast Notifications Container -->
    <div x-data="{
        toasts: [],
        addToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => this.removeToast(id), 4000);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
        init() {
            // Listen for session toast event
            window.addEventListener('show-session-toast', () => {
                if (window.toastData) {
                    this.addToast(window.toastData.message, window.toastData.type);
                    window.toastData = null;
                }
            });
        }
    }" class="fixed top-20 right-4 z-50 space-y-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast"
                 x-transition:enter="toast transition ease-out duration-300"
                 x-transition:enter-start="transform translate-x-full opacity-0"
                 x-transition:enter-end="transform translate-x-0 opacity-100"
                 x-transition:leave="toast transition ease-in duration-300"
                 x-transition:leave-start="transform translate-x-0 opacity-100"
                 x-transition:leave-end="transform translate-x-full opacity-0"
                 :class="{
                     'bg-green-500/80': toast.type === 'success',
                     'bg-red-500/80': toast.type === 'error',
                     'bg-yellow-500/80': toast.type === 'warning',
                     'bg-blue-500/80': toast.type === 'info'
                 }"
                 class="glass-card px-6 py-3 rounded-xl flex items-center gap-3 min-w-[300px]">
                <i x-show="toast.type === 'success'" class="fas fa-check-circle text-white"></i>
                <i x-show="toast.type === 'error'" class="fas fa-times-circle text-white"></i>
                <i x-show="toast.type === 'warning'" class="fas fa-exclamation-circle text-white"></i>
                <i x-show="toast.type === 'info'" class="fas fa-info-circle text-white"></i>
                <span class="text-white font-medium" x-text="toast.message"></span>
                <button @click="removeToast(toast.id)" class="ml-auto text-white/70 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- Navbar -->
    <nav class="glass-nav fixed w-full top-0 z-40" x-data="{
        mobileMenuOpen: false,
        cartOpen: false,
        @auth
        cartCount: {{ App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }},
        @endauth
        @guest
        cartCount: {{ is_array(session('cart')) ? array_sum(array_column(session('cart'), 'quantity')) : 0 }},
        @endguest
    }">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl glass-btn flex items-center justify-center">
                        <i class="fas fa-store text-white text-lg lg:text-xl"></i>
                    </div>
                    <span class="text-xl lg:text-2xl font-bold text-white">Toko Sembako</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-white transition font-medium {{ request()->routeIs('home') ? 'text-white' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('products') }}" class="text-white/80 hover:text-white transition font-medium {{ request()->routeIs('products') ? 'text-white' : '' }}">
                        Produk
                    </a>
                    <a href="{{ route('categories') }}" class="text-white/80 hover:text-white transition font-medium {{ request()->routeIs('categories') ? 'text-white' : '' }}">
                        Kategori
                    </a>
                    <a href="{{ route('about') }}" class="text-white/80 hover:text-white transition font-medium {{ request()->routeIs('about') ? 'text-white' : '' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-green-500/20 hover:bg-green-500/30 text-green-400 px-4 py-2 rounded-full text-sm font-medium transition {{ request()->routeIs('contact') ? 'bg-green-500/30' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Search (Hanya di Home) -->
                    @if(request()->routeIs('home'))
                    <div class="hidden md:block relative" x-data="{ searchOpen: false }">
                        <button @click="searchOpen = !searchOpen" class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fas fa-search text-white"></i>
                        </button>
                        <div x-show="searchOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             @click.away="searchOpen = false"
                             class="absolute right-0 top-14 w-80">
                            <form action="{{ route('products') }}" method="GET" class="relative">
                                <input type="text" name="search" placeholder="Cari produk..."
                                       class="w-full glass-input px-4 py-3 pl-12 rounded-xl text-white placeholder-white/60">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-white/60"></i>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Cart -->
                    <a href="{{ route('cart') }}" class="relative w-10 h-10 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                        <i class="fas fa-shopping-cart text-white"></i>
                        <span x-show="cartCount > 0" x-text="cartCount"
                              class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full text-xs flex items-center justify-center font-bold text-white">
                        </span>
                    </a>

                    <!-- User Menu (Desktop Only) -->
                    @guest
                        <a href="{{ route('login') }}" class="hidden lg:flex glass-btn px-5 py-2 rounded-xl text-white font-medium items-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="hidden xl:inline">Masuk</span>
                        </a>
                    @endguest

                    @auth
                        <div class="relative hidden lg:block" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 glass px-3 py-2 rounded-xl hover:bg-white/20 transition">
                                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if(auth()->user()->avatar && file_exists(public_path('uploads/avatars/' . auth()->user()->avatar)))
                                        <img src="{{ asset('uploads/avatars/' . auth()->user()->avatar) }}?t={{ time() }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-white text-sm"></i>
                                    @endif
                                </div>
                                <span class="text-white font-medium max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-white/60 text-xs"></i>
                            </button>
                            <div x-show="userMenuOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 @click.away="userMenuOpen = false"
                                 class="absolute right-0 top-14 w-56 glass-card rounded-xl overflow-hidden">
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-white/80 hover:text-white hover:bg-white/10 transition">
                                    <i class="fas fa-user-circle"></i>
                                    Profil Saya
                                </a>
                                <a href="{{ route('orders') }}" class="flex items-center gap-3 px-4 py-3 text-white/80 hover:text-white hover:bg-white/10 transition">
                                    <i class="fas fa-box"></i>
                                    Pesanan Saya
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-green-400 hover:text-green-300 hover:bg-white/10 transition">
                                        <i class="fas fa-tachometer-alt"></i>
                                        Dashboard Admin
                                    </a>
                                @endif
                                <hr class="border-white/10">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-white/10 transition">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden w-10 h-10 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                        <i class="fas fa-bars text-white" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times text-white" x-show="mobileMenuOpen"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="lg:hidden pb-4">
                <div class="glass-card rounded-xl p-4 space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('home') ? 'bg-white/10 text-white' : '' }}">
                        <i class="fas fa-home w-5"></i>
                        Beranda
                    </a>
                    <a href="{{ route('products') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('products') ? 'bg-white/10 text-white' : '' }}">
                        <i class="fas fa-box w-5"></i>
                        Produk
                    </a>
                    <a href="{{ route('categories') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('categories') ? 'bg-white/10 text-white' : '' }}">
                        <i class="fas fa-tags w-5"></i>
                        Kategori
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('about') ? 'bg-white/10 text-white' : '' }}">
                        <i class="fas fa-info-circle w-5"></i>
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-green-500/20 text-green-400 hover:bg-green-500/30 transition {{ request()->routeIs('contact') ? 'bg-green-500/30' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Hubungi Kami
                    </a>

                    @auth
                        <hr class="border-white/10 my-2">
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('profile') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-user-circle w-5"></i>
                            Profil Saya
                        </a>
                        <a href="{{ route('orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition {{ request()->routeIs('orders') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-box w-5"></i>
                            Pesanan Saya
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-green-400 hover:text-green-300 hover:bg-white/10 transition">
                                <i class="fas fa-tachometer-alt w-5"></i>
                                Dashboard Admin
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-400 hover:text-red-300 hover:bg-white/10 transition">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                Keluar
                            </button>
                        </form>
                    @endauth

                    @guest
                        <hr class="border-white/10 my-2">
                        <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition">
                            <i class="fas fa-sign-in-alt w-5"></i>
                            Masuk
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16 lg:pt-20 min-h-screen relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="glass-nav mt-20 relative z-10">
        <div class="container mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl glass-btn flex items-center justify-center">
                            <i class="fas fa-store text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-white">Toko Sembako</span>
                    </a>
                    <p class="text-white/70 text-sm">
                        Toko Sembako terpercaya, menyediakan berbagai kebutuhan dapur dan pokok berkualitas untuk keluarga Anda.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-white/70 hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('products') }}" class="text-white/70 hover:text-white transition">Produk</a></li>
                        <li><a href="{{ route('categories') }}" class="text-white/70 hover:text-white transition">Kategori</a></li>
                        <li><a href="{{ route('about') }}" class="text-white/70 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white/70 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Kategori</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-white/70 hover:text-white transition">Beras & Gandum</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition">Minyak & Goreng</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition">Sembako Umum</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition">Makanan & Minuman</a></li>
                        <li><a href="#" class="text-white/70 hover:text-white transition">Kebersihan</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-green-400 mt-1"></i>
                            <span class="text-white/70 text-sm">Jl. Tembok Dukuh V/50, RT 01/RW 02, Kelurahan Bubutan, Kecamatan Bubutan, Kota Surabaya, Jawa Timur 60173</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-green-400"></i>
                            <span class="text-white/70 text-sm">+62 857-7116-8204</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-green-400"></i>
                            <span class="text-white/70 text-sm">adityaramadhanikita.x13@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-white/10 my-8">

            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-white/60 text-sm">
                    &copy; {{ date('Y') }} Toko Sembako. Hak Cipta Dilindungi.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-white/60 hover:text-white text-sm transition">Kebijakan Privasi</a>
                    <a href="#" class="text-white/60 hover:text-white text-sm transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <!-- Toast Session Handler -->
    @if(session('toast'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dispatch event untuk ditampilkan oleh Alpine.js toast container
            const toastData = @json(session('toast'));
            window.toastData = toastData;

            // Tunggu Alpine.js ready, lalu trigger toast
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('show-session-toast'));
            }, 200);
        });
    </script>
    @endif
</body>
</html>
