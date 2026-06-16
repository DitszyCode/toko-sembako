<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Toko Sembako</title>

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

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #064e3b 0%, #022c22 100%);
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(34, 197, 94, 0.2);
        }

        .sidebar-link.active {
            background: rgba(34, 197, 94, 0.3);
            border-left: 3px solid #22c55e;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(34, 197, 94, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(34, 197, 94, 0.7);
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
    </style>

    @stack('styles')
</head>
<body class="bg-gray-900 text-white font-poppins">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="sidebar fixed lg:static inset-y-0 left-0 z-30 w-64 transform transition-transform duration-300"
               :class="{ '-translate-x-full lg:translate-x-0': !sidebarOpen }">
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b border-white/10">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl glass-btn flex items-center justify-center">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white">Toko Sembako</span>
                        <p class="text-xs text-green-400">Admin Panel</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <p class="text-xs text-white/40 uppercase tracking-wider mb-4 px-3">Dashboard</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    Dashboard
                </a>

                <p class="text-xs text-white/40 uppercase tracking-wider my-4 px-3">Manajemen</p>

                <a href="{{ route('admin.products') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    Produk
                </a>

                <a href="{{ route('admin.categories') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    Kategori
                </a>

                <a href="{{ route('admin.orders') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag w-5"></i>
                    Pesanan
                </a>

                <a href="{{ route('admin.users') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    Pengguna
                </a>

                <a href="{{ route('admin.banners') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white {{ request()->routeIs('admin.banners') ? 'active' : '' }}">
                    <i class="fas fa-images w-5"></i>
                    Banner
                </a>

                <p class="text-xs text-white/40 uppercase tracking-wider my-4 px-3">Lainnya</p>

                <a href="{{ route('home') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white">
                    <i class="fas fa-external-link-alt w-5"></i>
                    Lihat Website
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        Keluar
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Overlay -->
        <div x-show="!sidebarOpen" @click="sidebarOpen = true" class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="h-16 bg-gray-800 border-b border-white/10 flex items-center justify-between px-4 lg:px-6">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden w-10 h-10 rounded-lg hover:bg-white/10 flex items-center justify-center">
                        <i class="fas fa-bars text-white"></i>
                    </button>
                    <h1 class="text-lg lg:text-xl font-semibold text-white">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Real-time Notifications -->
                    <div class="relative" x-data="{
                        notifOpen: false,
                        notifications: [],
                        loading: false,
                        async fetchNotifications() {
                            try {
                                let response = await fetch('/api/admin/notifications');
                                if (response.ok) {
                                    this.notifications = await response.json();
                                }
                            } catch (e) { console.error(e); }
                        },
                        init() {
                            this.fetchNotifications();
                            setInterval(() => this.fetchNotifications(), 10000);
                        }
                    }">
                        <button @click="notifOpen = !notifOpen" class="relative w-10 h-10 rounded-lg hover:bg-white/10 flex items-center justify-center">
                            <i class="fas fa-bell text-white"></i>
                            <span x-show="notifications.length > 0" x-text="notifications.length"
                                  class="absolute top-0 right-0 w-5 h-5 bg-red-500 rounded-full text-xs flex items-center justify-center font-bold text-white animate-pulse">
                            </span>
                        </button>
                        <div x-show="notifOpen" @click.away="notifOpen = false"
                             class="absolute right-0 top-12 w-80 glass-card rounded-xl overflow-hidden z-40">
                            <div class="p-4 border-b border-white/10 flex items-center justify-between">
                                <h4 class="font-semibold text-white">Notifikasi</h4>
                                <button @click="fetchNotifications()" class="text-gray-400 hover:text-white text-xs">
                                    <i class="fas fa-sync-alt" :class="{'fa-spin': loading}"></i>
                                </button>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                <template x-for="notif in notifications" :key="notif.id">
                                    <a :href="notif.url" class="flex items-start gap-3 p-4 hover:bg-white/10 transition border-b border-white/5">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                             :class="notif.bg_class">
                                            <i :class="notif.icon" :class="notif.icon_color"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-white" x-text="notif.message"></p>
                                            <p class="text-xs text-white/60" x-text="notif.time"></p>
                                        </div>
                                        <div x-show="!notif.read" class="w-2 h-2 rounded-full bg-green-400 flex-shrink-0 mt-2"></div>
                                    </a>
                                </template>
                                <div x-show="notifications.length === 0" class="p-8 text-center text-gray-400">
                                    <i class="fas fa-bell-slash text-2xl mb-2 opacity-30"></i>
                                    <p class="text-sm">Tidak ada notifikasi baru</p>
                                </div>
                            </div>
                            <div class="p-3 border-t border-white/10 text-center">
                                <a href="{{ route('admin.orders') }}" class="text-green-400 hover:text-green-300 text-xs font-medium">
                                    Lihat Semua Pesanan <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-green-400">Administrator</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-6 bg-gray-900">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
