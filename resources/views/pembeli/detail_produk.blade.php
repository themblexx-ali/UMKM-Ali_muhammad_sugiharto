<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">Detail produk</p>
            <h2 class="text-2xl font-black leading-tight text-slate-950">{{ $produk->nama_produk }}</h2>
        </div>
    </x-slot>

    <div class="bg-[#f7f6f2] py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[1fr_440px]">
                <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="aspect-square bg-slate-100 lg:aspect-[5/4]">
                        @if ($produk->gambar_url)
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100 p-8 text-center text-3xl font-black">
                                {{ $produk->nama_produk }}
                            </div>
                        @endif
                    </div>
                </div>

                <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700 ring-1 ring-emerald-200">
                        {{ $produk->kategori->nama_kategori ?? 'Produk' }}
                    </span>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-950">{{ $produk->nama_produk }}</h1>
                    <div class="mt-4 flex items-end justify-between gap-4 border-b border-slate-200 pb-5">
                        <div>
                            <div class="text-sm font-medium text-slate-500">Harga</div>
                            <div class="text-3xl font-black text-emerald-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                        </div>
                        <div class="rounded-md bg-slate-100 px-3 py-2 text-sm font-bold text-slate-700">Stok {{ $produk->stok }}</div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-bold text-slate-950">Deskripsi</h3>
                        <p class="mt-2 leading-7 text-slate-600">{{ $produk->deskripsi }}</p>
                    </div>

                    @auth
                        <form action="{{ route('pembeli.cart.add') }}" method="POST" class="mt-6 space-y-4">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <div>
                                <label for="jumlah" class="block text-sm font-bold text-slate-700">Kuantiti</label>
                                <input id="jumlah" name="jumlah" type="number" min="1" max="{{ $produk->stok }}" value="1" required
                                    class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <button @disabled($produk->stok < 1) class="w-full rounded-md bg-emerald-600 px-4 py-3 text-sm font-black text-white shadow-sm hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-slate-300">
                                Tambah ke Keranjang
                            </button>
                            <a href="{{ route('pembeli.dashboard') }}" class="block rounded-md border border-slate-300 bg-white px-4 py-3 text-center text-sm font-bold text-slate-800 hover:bg-slate-50">
                                Kembali ke etalase
                            </a>
                        </form>
                    @else
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('login') }}" class="block rounded-md bg-emerald-600 px-4 py-3 text-center text-sm font-black text-white shadow-sm hover:bg-emerald-700">
                                Login untuk membeli
                            </a>
                            <a href="{{ route('pembeli.dashboard') }}" class="block rounded-md border border-slate-300 bg-white px-4 py-3 text-center text-sm font-bold text-slate-800 hover:bg-slate-50">
                                Etalase
                            </a>
                        </div>
                    @endauth
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
