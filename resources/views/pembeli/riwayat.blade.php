<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <h3 class="text-sm font-medium text-gray-500">Transaksi</h3>
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Invoice</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Item</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500">Total</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayats as $invoice => $items)
                                <tr>
                                    <td class="px-4 py-3 text-gray-800">{{ $invoice }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $items->first()->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-3 text-gray-800">
                                        {{ $items->count() }} item<br>
                                        <span class="text-xs text-gray-500">{{ $items->pluck('produk.nama_produk')->join(', ') }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-900">Rp {{ number_format($items->sum('total_harga'), 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('pembeli.invoice', $invoice) }}" class="inline-flex rounded-md bg-emerald-600 px-3 py-2 text-sm font-bold text-white hover:bg-emerald-700">Lihat detail</a>
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
