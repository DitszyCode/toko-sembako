@extends('layouts.admin')

@section('title', 'Banner')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">Daftar Banner</h2>
        <a href="{{ route('admin.banners') }}/create" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-medium transition-all">
            <i class="fas fa-plus"></i>
            Tambah Banner
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($banners as $banner)
        <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl overflow-hidden">
            <div class="aspect-[16/9] bg-gray-700">
                @if($banner->image)
                <img src="{{ $banner->image }}" class="w-full h-full object-cover" alt="">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <i class="fas fa-image text-4xl"></i>
                </div>
                @endif
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-medium text-white truncate">{{ $banner->title }}</h3>
                    @if($banner->is_active)
                    <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">Aktif</span>
                    @else
                    <span class="px-2 py-0.5 bg-gray-500/20 text-gray-400 text-xs rounded-full">Nonaktif</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.banners') }}/{{ $banner->id }}/edit" class="flex-1 text-center bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 py-2 rounded-lg text-sm transition-all">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.banners') }}/{{ $banner->id }}" method="POST" onsubmit="return confirm('Yakin?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500/20 text-red-400 hover:bg-red-500/30 py-2 rounded-lg text-sm transition-all">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-400">Belum ada banner</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $banners->links() }}</div>
@endsection
