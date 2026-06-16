@extends('layouts.admin')

@section('title', 'Tambah Banner')

@section('content')
    <div class="max-w-md">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.banners') }}" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-semibold text-white">Tambah Banner</h1>
        </div>
        <form action="{{ route('admin.banners') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-gray-300 text-sm mb-2">Judul Banner *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Gambar Banner *</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3" required>
            </div>
            <div>
                <label class="block text-gray-300 text-sm mb-2">Link (opsional)</label>
                <input type="text" name="link" value="{{ old('link') }}" placeholder="https://..." class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-600 bg-gray-700 text-green-500 focus:ring-green-500">
                <label for="is_active" class="text-gray-300">Aktifkan Banner</label>
            </div>
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-xl transition-all">Simpan</button>
                <a href="{{ route('admin.banners') }}" class="text-gray-400 hover:text-white">Batal</a>
            </div>
        </form>
    </div>
@endsection
