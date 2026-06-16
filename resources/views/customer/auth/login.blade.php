@extends('layouts.customer')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-14 h-14 rounded-2xl glass-btn flex items-center justify-center">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
            </a>
            <h1 class="text-3xl font-bold text-white">Selamat Datang</h1>
            <p class="text-white/70 mt-2">Masuk ke akun Toko Sembako Anda</p>
        </div>

        <!-- Login Form -->
        <div class="glass-card rounded-3xl p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Email atau Username</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                               class="w-full glass-input px-4 py-3 pl-12 rounded-xl text-white placeholder-white/60 @error('email') border-red-500 @enderror">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/60"></i>
                    </div>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Password</label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Masukkan password"
                               class="w-full glass-input px-4 py-3 pl-12 pr-12 rounded-xl text-white placeholder-white/60 @error('password') border-red-500 @enderror">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/60"></i>
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded border-white/30 bg-white/10 accent-green-500">
                        <span class="text-white/80 text-sm">Ingat saya</span>
                    </label>
                    <a href="#" class="text-green-400 hover:text-green-300 text-sm transition">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full glass-btn px-6 py-4 rounded-xl text-white font-semibold">
                    Masuk
                </button>

                <!-- Divider -->
                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-transparent text-white/50">atau masuk dengan</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-4">
                    <button type="button" class="glass px-4 py-3 rounded-xl text-white font-medium flex items-center justify-center gap-2 hover:bg-white/20 transition">
                        <i class="fab fa-google text-red-400"></i>
                        Google
                    </button>
                    <button type="button" class="glass px-4 py-3 rounded-xl text-white font-medium flex items-center justify-center gap-2 hover:bg-white/20 transition">
                        <i class="fab fa-facebook text-blue-400"></i>
                        Facebook
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <p class="text-center text-white/70 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 font-medium transition">
                    Daftar sekarang
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white/60 hover:text-white transition text-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
