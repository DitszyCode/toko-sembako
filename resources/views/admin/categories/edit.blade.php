@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="max-w-md">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.categories') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-semibold text-white">Edit Kategori</h1>
        </div>
        <form action="{{ route('admin.categories') }}/{{ $category->id }}" method="POST" class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6 space-y-6">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-gray-300 text-sm mb-2">Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-xl transition-all">Simpan</button>
                <a href="{{ route('admin.categories') }}" class="text-gray-400 hover:text-white">Batal</a>
            </div>
        </form>
    </div>
@endsection
