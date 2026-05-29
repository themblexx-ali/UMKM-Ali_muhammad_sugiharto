<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">Belanja</p>
            <h2 class="text-2xl font-black leading-tight text-slate-950">Keranjang</h2>
        </div>
    </x-slot>

    <div class="bg-[#f7f6f2] py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ session('error') }}</div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1fr_390px]">
                <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                        <h3 class="font-black text-slate-950">Produk di keranjang</h3>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $items->count() }} item</span>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($items as $item)
                            <div class="grid gap-4 p-5 sm:grid-cols-[112px_1fr_auto] sm:items-center">
                                <div class="h-28 overflow-hidden rounded-md bg-slate-100">
                                    @if ($item->gambar_url)
                                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_produk }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full items-center justify-center bg-emerald-50 p-2 text-center text-xs font-bold">{{ $item->nama_produk }}</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wide text-emerald-700">{{ $item->kategori->nama_kategori ?? '-' }}</div>
                                    <h4 class="mt-1 font-black text-slate-950">{{ $item->nama_produk }}</h4>
                                    <div class="mt-2 text-sm text-slate-600">Rp {{ number_format($item->harga, 0, ',', '.') }} / item</div>
                                    <div class="mt-1 text-base font-black text-slate-950">Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                                    <form action="{{ route('pembeli.cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="jumlah" min="1" max="{{ $item->stok }}" value="{{ $item->jumlah_keranjang }}" class="w-20 rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                        <button class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-bold hover:bg-slate-50">Update</button>
                                    </form>
                                    <form action="{{ route('pembeli.cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md bg-red-50 px-3 py-2 text-sm font-bold text-red-700 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <h3 class="text-lg font-black text-slate-950">Keranjang masih kosong</h3>
                                <p class="mt-2 text-sm text-slate-600">Pilih produk dari etalase untuk mulai checkout.</p>
                                <a href="{{ route('pembeli.dashboard') }}" class="mt-5 inline-flex rounded-md bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">Lihat etalase</a>
                            </div>
                        @endforelse
                    </div>
                </section>

                <form action="{{ route('pembeli.checkout') }}" method="POST" class="h-fit rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    @csrf
                    <h3 class="text-lg font-black text-slate-950">Ringkasan checkout</h3>
                    <p class="mt-1 text-sm text-slate-600">Lengkapi pengiriman dan metode pembayaran.</p>
                    <div class="mt-5 space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700">Metode pembayaran</label>
                            <select name="metode_pembayaran" required class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="COD">COD</option>
                                <option value="E-Wallet">E-Wallet</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700">Metode pengiriman</label>
                            <select name="metode_pengiriman" required class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="Kurir">Kurir</option>
                                <option value="Ambil di Tempat">Ambil di Tempat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700">Alamat pengiriman</label>
                            <textarea name="alamat_pengiriman" rows="4" required class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('alamat_pengiriman') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-5 rounded-lg bg-slate-50 p-4">
                        <div class="flex items-center justify-between text-sm font-medium text-slate-600">
                            <span>Total biaya</span>
                            <span class="text-2xl font-black text-slate-950">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button @disabled($items->isEmpty()) class="mt-5 w-full rounded-md bg-slate-950 px-4 py-3 text-sm font-black text-white shadow-sm hover:bg-slate-800 disabled:cursor-not-allowed disabled:bg-slate-300">
                        Beli Sekarang
                    </button>
                    <a href="{{ route('pembeli.dashboard') }}" class="mt-3 block rounded-md border border-slate-300 bg-white px-4 py-3 text-center text-sm font-bold text-slate-800 hover:bg-slate-50">Pilih produk lain</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
