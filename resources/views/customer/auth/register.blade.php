@extends('layouts.customer')

@section('title', 'Daftar')

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
            <h1 class="text-3xl font-bold text-white">Daftar Akun Baru</h1>
            <p class="text-white/70 mt-2">Bergabunglah dengan Toko Sembako</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="glass-card bg-red-500/20 border border-red-400/30 mb-6 p-4 rounded-xl">
                <ul class="text-red-200 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <div class="glass-card rounded-3xl p-8">
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full glass-input px-4 py-3 text-white placeholder-white/60 @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full glass-input px-4 py-3 text-white placeholder-white/60 @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                        class="w-full glass-input px-4 py-3 text-white placeholder-white/60 @error('phone') border-red-500 @enderror"
                        placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Alamat</label>
                    <textarea name="address" rows="3"
                        class="w-full glass-input px-4 py-3 text-white placeholder-white/60 resize-none @error('address') border-red-500 @enderror"
                        placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Password</label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full glass-input px-4 py-3 pr-12 text-white placeholder-white/60 @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-white/80 text-sm font-medium mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full glass-input px-4 py-3 text-white placeholder-white/60"
                        placeholder="Ulangi password">
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full glass-btn px-6 py-4 rounded-xl text-white font-semibold">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center text-white/70 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-medium transition">
                    Masuk di sini
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
