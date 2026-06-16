@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="max-w-2xl">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.products') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-semibold text-white">Edit Produk</h1>
        </div>
        <form action="{{ route('admin.products') }}/{{ $product->id }}" method="POST" enctype="multipart/form-data" class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6 space-y-6">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-gray-300 text-sm mb-2">Nama Produk *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Kategori *</label>
                <select name="category_id" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-300 text-sm mb-2">Harga *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div>
                    <label class="block text-gray-300 text-sm mb-2">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Satuan *</label>
                <select name="unit" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3" required>
                    @foreach(['kg', 'gram', 'liter', 'ml', 'pcs', 'pack', 'botol', 'sachet', 'box'] as $unit)
                    <option value="{{ $unit }}" {{ $product->unit == $unit ? 'selected' : '' }}>{{ strtoupper($unit) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Merek</label>
                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Contoh: Bimoli, Indomie, Gulaku">
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Gambar Produk</label>
                @if($product->image)
                <div class="mb-3"><img src="{{ $product->image }}" class="w-24 h-24 object-cover rounded-xl"></div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3">
                <p class="text-gray-500 text-xs mt-1">Kosongkan jika tidak ingin mengubah</p>
            </div>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-600 bg-gray-700 text-green-500 focus:ring-green-500">
                    <span class="text-gray-300">Produk Unggulan</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-600 bg-gray-700 text-green-500 focus:ring-green-500">
                    <span class="text-gray-300">Aktif</span>
                </label>
            </div>
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-xl transition-all">Simpan</button>
                <a href="{{ route('admin.products') }}" class="text-gray-400 hover:text-white">Batal</a>
            </div>
        </form>
    </div>
@endsection
