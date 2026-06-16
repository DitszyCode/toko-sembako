@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-white">Daftar Pesanan</h2>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-md border border-gray-700 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700/50">
                    <tr class="text-left text-gray-400 text-sm">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Pembayaran</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-sm divide-y divide-gray-700/50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-700/20">
                            <td class="px-6 py-4 font-medium text-white">#{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-green-400 font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                                    @elseif($order->status === 'processing') bg-blue-500/20 text-blue-400
                                    @elseif($order->status === 'shipped') bg-purple-500/20 text-purple-400
                                    @elseif($order->status === 'delivered') bg-green-500/20 text-green-400
                                    @else bg-red-500/20 text-red-400
                                    @endif">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($order->payment_status === 'paid') bg-green-500/20 text-green-400
                                    @elseif($order->payment_status === 'pending') bg-yellow-500/20 text-yellow-400
                                    @else bg-red-500/20 text-red-400
                                    @endif">
                                    {{ $order->payment_status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders') }}/{{ $order->id }}" class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-700">{{ $orders->links() }}</div>
    </div>
@endsection
