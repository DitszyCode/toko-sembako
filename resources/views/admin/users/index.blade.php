@extends('layouts.admin')

@section('title', 'Pengguna')

@push('styles')
<style>
    .modal { display: none; }
    .modal.active { display: flex; }
</style>
@endpush

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-white">Daftar Pengguna</h2>
        <p class="text-gray-400 text-sm mt-1">{{ $users->total() }} pengguna terdaftar</p>
    </div>
</div>

<div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-700/50">
                <tr class="text-left text-gray-400 text-sm">
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Pesanan</th>
                    <th class="px-6 py-4">Bergabung</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-300 text-sm divide-y divide-gray-700/50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-700/20">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                                @if($user->avatar && file_exists(public_path('uploads/avatars/' . $user->avatar)))
                                    <img src="{{ asset('uploads/avatars/' . $user->avatar) }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <span class="text-white text-sm font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="font-medium text-white">{{ $user->name }}</span>
                                @if($user->phone)
                                    <p class="text-gray-400 text-xs">{{ $user->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.users') }}/{{ $user->id }}/role" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="bg-gray-700 border border-gray-600 text-white rounded-lg px-2 py-1 text-xs">
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-700/50 rounded-lg text-xs">{{ $user->orders->count() }} pesanan</span>
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="mailto:{{ $user->email }}" class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Kirim Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->phone ?? '' }}', '{{ $user->address ?? '' }}')"
                                    class="p-2 text-yellow-400 hover:bg-yellow-500/10 rounded-lg transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada pengguna</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-700">{{ $users->links() }}</div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-lg">
        <div class="flex items-center justify-between p-6 border-b border-gray-700">
            <h3 class="text-xl font-bold text-white">Edit Pengguna</h3>
            <button onclick="closeEditModal()" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" required
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" required
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">No. Telepon</label>
                    <input type="tel" id="edit_phone" name="phone"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none"
                           placeholder="08xxxxxxxxxx">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Alamat</label>
                    <textarea id="edit_address" name="address" rows="2"
                              class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:border-green-500 focus:outline-none resize-none"
                              placeholder="Alamat lengkap"></textarea>
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
            <h3 class="text-xl font-bold text-white mb-2">Hapus Pengguna?</h3>
            <p class="text-gray-400 text-sm">Yakin ingin menghapus <strong id="deleteUserName" class="text-white"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
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
function openEditModal(id, name, email, phone, address) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone;
    document.getElementById('edit_address').value = address;
    document.getElementById('editForm').action = '/admin/users/' + id;
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

function confirmDelete(id, name) {
    document.getElementById('deleteUserName').textContent = name;
    document.getElementById('deleteForm').action = '/admin/users/' + id;
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