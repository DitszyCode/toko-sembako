@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.categories') }}/create" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-medium transition-all">
            <i class="fas fa-plus"></i>
            Tambah Kategori
        </a>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-700/50">
                <tr class="text-left text-gray-400 text-sm">
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-300 text-sm divide-y divide-gray-700/50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-700/20">
                    <td class="px-6 py-4 font-medium text-white">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $category->slug }}</td>
                    <td class="px-6 py-4">{{ $category->products_count ?? 0 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.categories') }}/{{ $category->id }}/edit" class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories') }}/{{ $category->id }}" method="POST" onsubmit="return confirm('Yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
