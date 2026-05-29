<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Karyawan</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm">
                <h3 class="mb-4 border-b pb-2 text-lg font-bold text-gray-800">Data Transaksi</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Pelanggan</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Produk</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Jumlah</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transaksis as $t)
                                <tr>
                                    <td class="px-4 py-3">{{ $t->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $t->produk->nama_produk ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $t->jumlah }}</td>
                                    <td class="px-4 py-3">{{ optional($t->tanggal_beli)->format('d M Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
