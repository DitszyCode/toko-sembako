@extends('layouts.customer')

@section('title', 'Profil Saya')

@push('styles')
<style>
    .tab-btn.active {
        background: rgba(34, 197, 94, 0.3);
        border-color: #22c55e;
        color: #fff;
    }
    .profile-avatar-upload {
        position: relative;
        overflow: hidden;
    }
    .profile-avatar-upload:hover .avatar-overlay {
        opacity: 1;
    }
    .avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        border-radius: 50%;
        cursor: pointer;
    }
    .order-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: scale(1.03);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen pb-16">
    <div class="container mx-auto px-4 lg:px-8 py-8">

        {{-- ==================== PROFILE HEADER ==================== --}}
        <div class="glass-card rounded-3xl p-6 lg:p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                {{-- Avatar --}}
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-4xl font-bold text-white overflow-hidden">
                        @if(Auth::user()->avatar && file_exists(public_path('uploads/avatars/' . Auth::user()->avatar)))
                            <img src="{{ asset('uploads/avatars/' . Auth::user()->avatar) }}?t={{ time() }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <label for="avatar-upload" class="profile-avatar-upload absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center cursor-pointer hover:bg-green-600 transition shadow-lg">
                        <i class="fas fa-camera text-white text-sm"></i>
                    </label>
                    <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="hidden">
                        @csrf
                        @method('PATCH')
                        <input type="file" id="avatar-upload" name="avatar" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
                    </form>
                </div>

                {{-- Info --}}
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl lg:text-3xl font-bold text-white">{{ Auth::user()->name }}</h1>
                    <p class="text-green-200/80 mt-1">{{ Auth::user()->email }}</p>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-4">
                        @if(Auth::user()->phone)
                            <span class="glass px-3 py-1.5 rounded-full text-sm text-white/80 flex items-center gap-2">
                                <i class="fas fa-phone text-green-400 text-xs"></i>
                                {{ Auth::user()->phone }}
                            </span>
                        @endif
                        <span class="glass px-3 py-1.5 rounded-full text-sm text-white/80 flex items-center gap-2">
                            <i class="fas fa-calendar text-green-400 text-xs"></i>
                            Bergabung {{ Auth::user()->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="flex gap-4">
                    <div class="stat-card glass-card rounded-2xl p-4 text-center min-w-[90px]">
                        <div class="text-2xl font-bold text-white">{{ $orderCount ?? 0 }}</div>
                        <div class="text-white/60 text-xs mt-1">Pesanan</div>
                    </div>
                    <div class="stat-card glass-card rounded-2xl p-4 text-center min-w-[90px]">
                        <div class="text-2xl font-bold text-white">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</div>
                        <div class="text-white/60 text-xs mt-1">Total Belanja</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== TABS ==================== --}}
        <div x-data="{ activeTab: 'profile' }">
            <div class="flex flex-wrap gap-2 mb-6">
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'active' : ''"
                    class="tab-btn glass px-5 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-user"></i> Profil
                </button>
                <button @click="activeTab = 'password'" :class="activeTab === 'password' ? 'active' : ''"
                    class="tab-btn glass px-5 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-lock"></i> Keamanan
                </button>
                <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'active' : ''"
                    class="tab-btn glass px-5 py-2.5 rounded-xl text-sm font-medium text-white/70 hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-box"></i> Riwayat Pesanan
                </button>
                <button @click="activeTab = 'delete'" :class="activeTab === 'delete' ? 'active' : ''"
                    class="tab-btn glass px-5 py-2.5 rounded-xl text-sm font-medium text-red-400/70 hover:text-red-300 transition flex items-center gap-2">
                    <i class="fas fa-trash-alt"></i> Hapus Akun
                </button>
            </div>

            {{-- ==================== TAB: PROFIL ==================== --}}
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="grid lg:grid-cols-2 gap-6">
                    {{-- Info Profil --}}
                    <div class="glass-card rounded-2xl p-6 lg:p-8" x-data="{ saving: false }">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-user-circle text-green-400"></i>
                            Informasi Profil
                        </h2>

                        @if (session('success'))
                            <div id="success-alert" class="glass bg-green-500/30 border border-green-400/30 mb-4 p-4 rounded-xl transition-opacity duration-500">
                                <p class="text-green-100 text-sm flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                                </p>
                            </div>
                            <script>setTimeout(function(){ var el = document.getElementById('success-alert'); if(el){ el.style.opacity='0'; setTimeout(function(){ el.style.display='none'; }, 500); } }, 4000);</script>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}" @submit="saving = true">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-5">
                                <div>
                                    <label for="name" class="block text-white/90 text-sm font-medium mb-2">Nama Lengkap *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                        class="glass-input w-full px-4 py-3 text-white rounded-xl @error('name') border border-red-400 @enderror"
                                        placeholder="Nama lengkap">
                                    @error('name')
                                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-white/90 text-sm font-medium mb-2">Email</label>
                                    <input type="email" id="email" value="{{ Auth::user()->email }}"
                                        class="glass-input w-full px-4 py-3 text-white bg-green-500/10 cursor-not-allowed rounded-xl"
                                        placeholder="Email" readonly>
                                    <p class="text-green-200/50 text-xs mt-1"><i class="fas fa-info-circle text-xs"></i> Email tidak dapat diubah</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="phone" class="block text-white/90 text-sm font-medium mb-2">No. Telepon</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                            class="glass-input w-full px-4 py-3 text-white rounded-xl @error('phone') border border-red-400 @enderror"
                                            placeholder="08xxxxxxxxxx">
                                        @error('phone')
                                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="date_of_birth" class="block text-white/90 text-sm font-medium mb-2">Tanggal Lahir</label>
                                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth?->format('Y-m-d')) }}"
                                            class="glass-input w-full px-4 py-3 text-white rounded-xl @error('date_of_birth') border border-red-400 @enderror">
                                        @error('date_of_birth')
                                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="gender" class="block text-white/90 text-sm font-medium mb-2">Jenis Kelamin</label>
                                    <select id="gender" name="gender"
                                        class="glass-input w-full px-4 py-3 text-white rounded-xl @error('gender') border border-red-400 @enderror">
                                        <option value="">Pilih</option>
                                        <option value="male" {{ (old('gender', Auth::user()->gender) == 'male') ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ (old('gender', Auth::user()->gender) == 'female') ? 'selected' : '' }}>Perempuan</option>
                                        <option value="other" {{ (old('gender', Auth::user()->gender) == 'other') ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('gender')
                                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address" class="block text-white/90 text-sm font-medium mb-2">Alamat Lengkap</label>
                                    <textarea id="address" name="address" rows="3"
                                        class="glass-input w-full px-4 py-3 text-white rounded-xl resize-none @error('address') border border-red-400 @enderror"
                                        placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan, Kecamatan">{{ old('address', Auth::user()->address) }}</textarea>
                                    @error('address')
                                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="city" class="block text-white/90 text-sm font-medium mb-2">Kota</label>
                                        <input type="text" id="city" name="city" value="{{ old('city', Auth::user()->city) }}"
                                            class="glass-input w-full px-4 py-3 text-white rounded-xl @error('city') border border-red-400 @enderror"
                                            placeholder="Kota">
                                        @error('city')
                                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="postal_code" class="block text-white/90 text-sm font-medium mb-2">Kode Pos</label>
                                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}"
                                            class="glass-input w-full px-4 py-3 text-white rounded-xl @error('postal_code') border border-red-400 @enderror"
                                            placeholder="xxxxx">
                                        @error('postal_code')
                                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" :disabled="saving"
                                class="w-full mt-6 px-6 py-3.5 rounded-xl text-white font-semibold transition flex items-center justify-center gap-2"
                                style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                                <i class="fas fa-save"></i>
                                <span x-show="!saving">Simpan Perubahan</span>
                                <span x-show="saving">Menyimpan...</span>
                            </button>
                        </form>
                    </div>

                    {{-- Info Akun --}}
                    <div class="glass-card rounded-2xl p-6 lg:p-8">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-shield-alt text-green-400"></i>
                            Info Akun
                        </h2>

                        <div class="space-y-4">
                            <div class="glass-card rounded-xl p-4 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-green-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/50 text-xs">Email</p>
                                    <p class="text-white font-medium">{{ Auth::user()->email }}</p>
                                </div>
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>

                            <div class="glass-card rounded-xl p-4 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-check text-green-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/50 text-xs">Bergabung</p>
                                    <p class="text-white font-medium">{{ Auth::user()->created_at->format('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="glass-card rounded-xl p-4 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shopping-bag text-green-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/50 text-xs">Total Pesanan</p>
                                    <p class="text-white font-medium">{{ $orderCount ?? 0 }} pesanan</p>
                                </div>
                            </div>

                            <div class="glass-card rounded-xl p-4 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-wallet text-green-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/50 text-xs">Total Belanja</p>
                                    <p class="text-white font-medium">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== TAB: KEAMANAN ==================== --}}
            <div x-show="activeTab === 'password'" x-transition>
                <div class="max-w-xl">
                    <div class="glass-card rounded-2xl p-6 lg:p-8" x-data="{ saving: false, showCurrent: false, showNew: false, showConfirm: false }">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i class="fas fa-lock text-green-400"></i>
                            Ubah Password
                        </h2>

                        @if ($errors->has('current_password'))
                            <div class="glass bg-red-500/30 border border-red-400/30 mb-4 p-4 rounded-xl">
                                <p class="text-red-100 text-sm flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first('current_password') }}
                                </p>
                            </div>
                        @endif

                        @if (session('password_success'))
                            <div id="pw-success" class="glass bg-green-500/30 border border-green-400/30 mb-4 p-4 rounded-xl transition-opacity duration-500">
                                <p class="text-green-100 text-sm flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> {{ session('password_success') }}
                                </p>
                            </div>
                            <script>setTimeout(function(){ var el = document.getElementById('pw-success'); if(el){ el.style.opacity='0'; setTimeout(function(){ el.style.display='none'; }, 500); } }, 4000);</script>
                        @endif

                        <form method="POST" action="{{ route('profile.password') }}" @submit="saving = true">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-5">
                                <div>
                                    <label for="current_password" class="block text-white/90 text-sm font-medium mb-2">Password Saat Ini *</label>
                                    <div class="relative">
                                        <input :type="showCurrent ? 'text' : 'password'" id="current_password" name="current_password" required
                                            class="glass-input w-full px-4 py-3 text-white pr-12 rounded-xl @error('current_password') border border-red-400 @enderror"
                                            placeholder="Masukkan password saat ini">
                                        <button type="button" @click="showCurrent = !showCurrent"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-green-200/60 hover:text-white transition">
                                            <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'" class="fas text-sm"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label for="password" class="block text-white/90 text-sm font-medium mb-2">Password Baru *</label>
                                    <div class="relative">
                                        <input :type="showNew ? 'text' : 'password'" id="password" name="password" required minlength="8"
                                            class="glass-input w-full px-4 py-3 text-white pr-12 rounded-xl @error('password') border border-red-400 @enderror"
                                            placeholder="Minimal 8 karakter">
                                        <button type="button" @click="showNew = !showNew"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-green-200/60 hover:text-white transition">
                                            <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'" class="fas text-sm"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-white/90 text-sm font-medium mb-2">Konfirmasi Password Baru *</label>
                                    <div class="relative">
                                        <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                            class="glass-input w-full px-4 py-3 text-white pr-12 rounded-xl"
                                            placeholder="Ulangi password baru">
                                        <button type="button" @click="showConfirm = !showConfirm"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-green-200/60 hover:text-white transition">
                                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="fas text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" :disabled="saving"
                                class="w-full mt-6 px-6 py-3.5 rounded-xl text-white font-semibold transition flex items-center justify-center gap-2"
                                style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                                <i class="fas fa-key"></i>
                                <span x-show="!saving">Ubah Password</span>
                                <span x-show="saving">Menyimpan...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ==================== TAB: RIWAYAT PESANAN ==================== --}}
            <div x-show="activeTab === 'orders'" x-transition>
                <div class="space-y-4">
                    @forelse($orders ?? [] as $order)
                        <div class="order-card glass-card rounded-2xl p-5">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-box text-green-400 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold">#{{ $order->order_number }}</p>
                                        <p class="text-white/50 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                                        @if($order->status === 'delivered') bg-green-500/30 text-green-400
                                        @elseif($order->status === 'processing') bg-blue-500/30 text-blue-400
                                        @elseif($order->status === 'shipped') bg-purple-500/30 text-purple-400
                                        @elseif($order->status === 'cancelled') bg-red-500/30 text-red-400
                                        @else bg-yellow-500/30 text-yellow-400 @endif">
                                        @if($order->status === 'pending') Menunggu Pembayaran
                                        @elseif($order->status === 'processing') Diproses
                                        @elseif($order->status === 'shipped') Dikirim
                                        @elseif($order->status === 'delivered') Selesai
                                        @elseif($order->status === 'cancelled') Dibatalkan
                                        @endif
                                    </span>
                                    <span class="text-white font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    <a href="{{ route('orders.show', $order) }}" class="glass px-4 py-2 rounded-xl text-white/80 hover:text-white text-sm transition">
                                        Detail <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="glass-card rounded-2xl p-12 text-center">
                            <i class="fas fa-shopping-bag text-white/20 text-5xl mb-4"></i>
                            <p class="text-white/60">Belum ada pesanan</p>
                            <a href="{{ route('products') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 rounded-xl text-white text-sm font-medium transition" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
                                <i class="fas fa-shopping-cart"></i> Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ==================== TAB: HAPUS AKUN ==================== --}}
            <div x-show="activeTab === 'delete'" x-transition>
                <div class="max-w-xl">
                    <div class="glass-card rounded-2xl p-6 lg:p-8 border border-red-500/30" x-data="{ showConfirm: false, deleting: false }">
                        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                            Hapus Akun
                        </h2>

                        <div class="glass bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
                            <p class="text-red-200 text-sm leading-relaxed">
                                <strong>Perhatian:</strong> Menghapus akun akan menghilangkan semua data Anda secara permanen, termasuk:
                            </p>
                            <ul class="text-red-200/80 text-sm mt-2 space-y-1 list-disc list-inside">
                                <li>Riwayat pesanan</li>
                                <li>Alamat tersimpan</li>
                                <li>Data profil</li>
                            </ul>
                            <p class="text-red-200 text-sm mt-2">Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>
                        </div>

                        <div x-show="!showConfirm">
                            <button @click="showConfirm = true"
                                class="w-full px-6 py-3.5 rounded-xl text-red-300 font-semibold transition flex items-center justify-center gap-2 border border-red-500/50 hover:bg-red-500/20">
                                <i class="fas fa-trash-alt"></i> Hapus Akun Saya
                            </button>
                        </div>

                        <div x-show="showConfirm" x-cloak>
                            <p class="text-white/80 text-sm mb-4">Ketik <strong class="text-red-400">HAPUS</strong> untuk konfirmasi:</p>
                            <form method="POST" action="{{ route('profile.destroy') }}" @submit="deleting = true">
                                @csrf
                                @method('DELETE')

                                <div class="mb-4">
                                    <input type="text" id="delete_confirm" name="delete_confirm" required
                                        class="glass-input w-full px-4 py-3 text-white rounded-xl @error('delete_confirm') border border-red-400 @enderror"
                                        placeholder="Ketik HAPUS">
                                    @error('delete_confirm')
                                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="delete_password" class="block text-white/90 text-sm font-medium mb-2">Password Anda *</label>
                                    <input type="password" id="delete_password" name="password" required
                                        class="glass-input w-full px-4 py-3 text-white rounded-xl @error('password') border border-red-400 @enderror"
                                        placeholder="Masukkan password untuk konfirmasi">
                                    @error('password')
                                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex gap-3">
                                    <button type="button" @click="showConfirm = false"
                                        class="flex-1 px-6 py-3 rounded-xl text-white/80 font-medium transition glass hover:bg-white/10">
                                        Batal
                                    </button>
                                    <button type="submit" :disabled="deleting"
                                        class="flex-1 px-6 py-3 rounded-xl text-white font-semibold transition bg-red-600 hover:bg-red-700 disabled:opacity-50 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash-alt"></i>
                                        <span x-show="!deleting">Ya, Hapus</span>
                                        <span x-show="deleting">Menghapus...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
