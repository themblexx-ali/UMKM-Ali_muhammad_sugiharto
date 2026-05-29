<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Invoice</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Item</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500">Total</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transaksis as $invoice => $items)
                                @php($first = $items->first())
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $invoice }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $first->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ optional($first->tanggal_beli)->format('d M Y') ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $items->sum('jumlah') }}</td>
                                    <td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($items->sum('total_harga'), 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.transaksi.detail', $invoice) }}" class="font-semibold text-indigo-600 hover:text-indigo-900">Detail / Cetak</a>
                                        <form action="{{ route('admin.transaksi.destroy', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="ml-3 font-semibold text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
