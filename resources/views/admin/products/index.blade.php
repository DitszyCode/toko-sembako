@extends('layouts.admin')

@section('title', 'Produk')

@push('styles')
<style>
    .modal { display: none; }
    .modal.active { display: flex; }
</style>
@endpush

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-medium transition-all">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
    <form action="{{ route('admin.products') }}" method="GET" class="flex items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
               class="bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        <select name="category" class="bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2 text-sm focus:outline-none">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm">Cari</button>
    </form>
</div>

<div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-700/50">
                <tr class="text-left text-gray-400 text-sm">
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-300 text-sm divide-y divide-gray-700/50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-700/20">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-700 flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ $product->image }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <i class="fas fa-box text-gray-500 flex items-center justify-center w-full h-full"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-white">{{ $product->name }}</p>
                                @if($product->is_featured)
                                    <span class="text-xs text-green-400">Unggulan</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="text-green-400">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="block text-xs text-gray-500">/ {{ $product->unit }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->stock > 10)
                            <span class="text-green-400">{{ $product->stock }} {{ $product->unit }}</span>
                        @elseif($product->stock > 0)
                            <span class="text-yellow-400">{{ $product->stock }} {{ $product->unit }}</span>
                        @else
                            <span class="text-red-400">Habis</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->category_id ?? 'null' }}, {{ $product->price }}, {{ $product->stock }}, '{{ addslashes($product->unit) }}', '{{ addslashes($product->description ?? '') }}', {{ $product->is_featured ? 'true' : 'false' }})"
                                    class="p-2 text-yellow-400 hover:bg-yellow-500/10 rounded-lg transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                    class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-700">{{ $products->links() }}</div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-6 border-b border-gray-700 sticky top-0 bg-gray-800">
            <h3 class="text-xl font-bold text-white">Edit Produk</h3>
            <button onclick="closeEditModal()" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Nama Produk *</label>
                    <input type="text" id="edit_name" name="name" required
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Kategori *</label>
                    <select id="edit_category" name="category_id" required
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Harga *</label>
                        <input type="number" id="edit_price" name="price" required min="0"
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Stok *</label>
                        <input type="number" id="edit_stock" name="stock" required min="0"
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Unit</label>
                    <input type="text" id="edit_unit" name="unit" placeholder="kg, pcs, liter..."
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Deskripsi</label>
                    <textarea id="edit_description" name="description" rows="3"
                              class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Gambar</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-500 file:text-white file:hover:bg-green-600">
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="edit_featured" name="is_featured" value="1" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-green-500 focus:ring-green-500">
                    <label for="edit_featured" class="text-gray-300 text-sm">Tampilkan sebagai Produk Unggulan</label>
                </div>
            </div>
            <div class="flex gap-3 p-6 border-t border-gray-700">
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-4 py-3 rounded-xl text-white/80 font-medium transition bg-gray-700 hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-3 rounded-xl text-white font-semibold transition bg-green-600 hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-md">
        <div class="text-center p-6">
            <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Hapus Produk?</h3>
            <p class="text-gray-400 text-sm">Yakin ingin menghapus <strong id="deleteProductName" class="text-white"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <form id="deleteForm" method="POST" class="p-6 pt-0">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-3 rounded-xl text-white/80 font-medium transition bg-gray-700 hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-3 rounded-xl text-white font-semibold transition bg-red-600 hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, categoryId, price, stock, unit, description, isFeatured) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_category').value = categoryId;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_stock').value = stock;
    document.getElementById('edit_unit').value = unit;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_featured').checked = isFeatured;
    document.getElementById('editForm').action = '/admin/products/' + id;
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

function confirmDelete(id, name) {
    document.getElementById('deleteProductName').textContent = name;
    document.getElementById('deleteForm').action = '/admin/products/' + id;
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Close modals on backdrop click
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection
