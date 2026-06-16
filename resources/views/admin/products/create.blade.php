@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700">
        <h1 class="text-2xl font-bold text-white mb-6">Tambah Produk Baru</h1>

        <form action="{{ route('admin.products') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Kategori</label>
                    <select name="category_id" id="category_id" required
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Masukkan nama produk">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="1"
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="0">
                    @error('price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-300 mb-2">Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required min="0"
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="0">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-300 mb-2">Satuan</label>
                    <select name="unit" id="unit" required
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Satuan</option>
                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kg</option>
                        <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>Gram</option>
                        <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                        <option value="ml" {{ old('unit') == 'ml' ? 'selected' : '' }}>ML</option>
                        <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="pack" {{ old('unit') == 'pack' ? 'selected' : '' }}>Pack</option>
                        <option value="botol" {{ old('unit') == 'botol' ? 'selected' : '' }}>Botol</option>
                        <option value="sachet" {{ old('unit') == 'sachet' ? 'selected' : '' }}>Sachet</option>
                        <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-300 mb-2">Merek</label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Contoh: Bimoli, Indomie, Gulaku">
                    @error('brand')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-600 bg-gray-700/50 text-green-500 focus:ring-green-500">
                            <span class="ml-2 text-gray-300">Produk Unggulan</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-600 bg-gray-700/50 text-green-500 focus:ring-green-500">
                            <span class="ml-2 text-gray-300">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Gambar Produk</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white">
                    @error('image')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full bg-gray-700/50 border border-gray-600 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:ring-2 focus:ring-green-500"
                    placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="px-6 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products') }}" class="px-6 py-2.5 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
