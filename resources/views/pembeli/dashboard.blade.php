<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">Etalase online</p>
                <h2 class="text-2xl font-black leading-tight text-slate-950">Etalase Produk</h2>
            </div>
            @auth
                <a href="{{ route('pembeli.cart') }}" class="relative inline-flex h-11 w-11 items-center justify-center rounded-md bg-emerald-600 text-white shadow-sm hover:bg-emerald-700" aria-label="Keranjang" title="Keranjang">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L21 7H6" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h.01M18 21h.01" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -right-1.5 -top-1.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-slate-950 px-1 text-[10px] font-black leading-none text-white">{{ $cartCount }}</span>
                    @endif
                    <span class="sr-only">Keranjang</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-gray-500 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-green-500">
                    Login untuk membeli
                </a>
            @endauth
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

            <section class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="grid gap-6 p-5 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <h3 class="text-lg font-black text-slate-950">Cari berdasarkan kategori</h3>
                        <p class="mt-1 text-sm text-slate-600">Pilih kategori untuk menyaring produk yang tersedia di toko.</p>
                    </div>
                    <form method="GET" action="{{ route('pembeli.dashboard') }}" class="grid gap-3 sm:grid-cols-[240px_auto]">
                        <select name="kategori" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected((string) $kategoriId === (string) $kategori->id)>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <button class="rounded-md bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">Terapkan</button>
                    </form>
                </div>
            </section>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($produks as $produk)
                    <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                        <a href="{{ route('pembeli.produk.show', $produk) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                @if ($produk->gambar_url)
                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100 p-4 text-center font-bold text-slate-800">
                                        {{ $produk->nama_produk }}
                                    </div>
                                @endif
                                <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-xs font-bold text-slate-700 shadow-sm">Stok {{ $produk->stok }}</span>
                            </div>
                        </a>

                        <div class="p-4">
                            <div class="text-xs font-bold uppercase tracking-wide text-emerald-700">{{ $produk->kategori->nama_kategori ?? '-' }}</div>
                            <a href="{{ route('pembeli.produk.show', $produk) }}" class="mt-1 block">
                                <h3 class="line-clamp-2 min-h-12 font-black leading-6 text-slate-950 group-hover:text-emerald-700">{{ $produk->nama_produk }}</h3>
                            </a>
                            <p class="mt-2 line-clamp-2 min-h-12 text-sm leading-6 text-slate-600">{{ $produk->deskripsi }}</p>
                            <div class="mt-4 text-xl font-black text-slate-950">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a href="{{ route('pembeli.produk.show', $produk) }}" class="rounded-md border border-slate-300 bg-white px-3 py-2.5 text-center text-sm font-bold text-slate-800 hover:bg-slate-50">Detail</a>
                                @auth
                                    <form action="{{ route('pembeli.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button @disabled($produk->stok < 1) class="w-full rounded-md bg-emerald-600 px-3 py-2.5 text-sm font-bold text-white hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-slate-300">
                                            Beli
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="rounded-md bg-emerald-600 px-3 py-2.5 text-center text-sm font-bold text-white hover:bg-emerald-700">
                                        Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 sm:col-span-2 lg:col-span-4">
                        Produk tidak ditemukan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
