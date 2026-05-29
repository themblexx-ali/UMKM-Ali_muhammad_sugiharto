<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $invoice }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-950">
    <main class="mx-auto max-w-4xl px-4 py-8">
        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 print:hidden">{{ session('success') }}</div>
        @endif

        <section class="rounded-lg bg-white p-8 shadow-sm print:shadow-none" id="invoice">
            <div class="flex flex-col gap-4 border-b pb-6 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Toko SRC Ali</div>
                    <h1 class="mt-1 text-3xl font-bold">Invoice</h1>
                    <div class="mt-2 text-sm text-gray-600">{{ $invoice }}</div>
                </div>
                <button onclick="window.print()" class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 print:hidden">Cetak / Download</button>
            </div>

            @php($first = $items->first())
            <div class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                <div>
                    <div class="font-semibold">Pelanggan</div>
                    <div>{{ $first->user->name }}</div>
                    <div>{{ $first->user->email }}</div>
                    <div>{{ $first->user->hp }}</div>
                </div>
                <div class="sm:text-right">
                    <div>Tanggal: {{ optional($first->tanggal_beli)->format('d M Y') }}</div>
                    <div>Pembayaran: {{ $first->metode_pembayaran }}</div>
                    <div>Pengiriman: {{ $first->metode_pengiriman }}</div>
                </div>
            </div>
            <div class="mt-4 rounded-md bg-gray-50 p-4 text-sm">
                <div class="font-semibold">Alamat pengiriman</div>
                <div>{{ $first->alamat_pengiriman }}</div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Produk</th>
                            <th class="px-4 py-3 text-right font-semibold">Harga</th>
                            <th class="px-4 py-3 text-right font-semibold">Qty</th>
                            <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->produk->nama_produk }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right">{{ $item->jumlah }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-right font-bold">Total</td>
                            <td class="px-4 py-4 text-right text-lg font-bold">Rp {{ number_format($items->sum('total_harga'), 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <a href="{{ route('pembeli.dashboard') }}" class="mt-6 inline-block text-sm font-semibold text-indigo-700 hover:text-indigo-900 print:hidden">Kembali etalase</a>
        </section>
    </main>
</body>
</html>
