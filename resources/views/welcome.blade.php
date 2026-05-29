<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko SRC Ali</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f7f6f2] text-slate-950">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-600 text-lg font-black text-white">A</span>
                <span>
                    <span class="block text-lg font-black leading-5 tracking-tight">Toko SRC Ali</span>
                    <span class="block text-xs font-medium text-slate-500">Belanja kebutuhan harian</span>
                </span>
            </a>
            <nav class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Login</a>
                <a href="{{ route('register') }}" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">Registrasi</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="border-b border-slate-200 bg-white">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:py-14">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700 ring-1 ring-emerald-200">
                        Toko online UMKM
                    </div>
                    <h1 class="mt-2 max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-6xl">
                        Belanja produk lokal dengan cepat dan rapi.
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                        Temukan produk, lihat detail tanpa login, masukkan ke keranjang, checkout, lalu cetak invoice langsung dari akun pelanggan.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('pembeli.dashboard') }}" class="rounded-md bg-slate-950 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-slate-800">Lihat etalase</a>
                        <a href="{{ route('login') }}" class="rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-800 hover:bg-slate-50">Masuk akun</a>
                    </div>
                    <div class="mt-8 grid max-w-xl grid-cols-3 gap-4 border-t border-slate-200 pt-6">
                        <div>
                            <div class="text-2xl font-black">{{ $produks->count() }}+</div>
                            <div class="text-xs font-medium text-slate-500">Produk</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black">{{ $kategoris->count() }}</div>
                            <div class="text-xs font-medium text-slate-500">Kategori</div>
                        </div>
                        <div>
                            <div class="text-2xl font-black">24/7</div>
                            <div class="text-xs font-medium text-slate-500">Etalase online</div>
                        </div>
                    </div>
                </div>

                <div class="relative" x-data="{ active: 0, total: {{ max($produks->take(4)->count(), 1) }} }" x-init="setInterval(() => active = (active + 1) % total, 3500)">
                    <div class="absolute -left-4 -top-4 z-10 hidden rounded-md bg-amber-300 px-4 py-3 text-sm font-black text-slate-900 shadow-sm lg:block">Produk pilihan</div>
                    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-xl">
                        @if ($produks->take(4)->count())
                            <div class="flex transition-transform duration-500 ease-out" :style="`transform: translateX(-${active * 100}%);`">
                                @foreach ($produks->take(4)->values() as $produk)
                                    <article class="group min-w-full">
                                        <a href="{{ route('pembeli.produk.show', $produk) }}" class="block">
                                            <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                                @if ($produk->gambar_url)
                                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                                @else
                                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100 p-8 text-center text-2xl font-black text-slate-800">
                                                        {{ $produk->nama_produk }}
                                                    </div>
                                                @endif
                                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/85 to-transparent p-5 pt-20 text-white">
                                                    <div class="text-xs font-bold uppercase tracking-wide text-emerald-200">{{ $produk->kategori->nama_kategori ?? 'Produk' }}</div>
                                                    <h3 class="mt-1 text-2xl font-black">{{ $produk->nama_produk }}</h3>
                                                    <div class="mt-2 text-lg font-black">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="flex aspect-[4/3] items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100 p-8 text-center text-xl font-black">
                                Produk UMKM
                            </div>
                        @endif

                        @if ($produks->take(4)->count() > 1)
                            <div class="flex items-center justify-between border-t border-slate-200 bg-white px-4 py-3">
                                <button type="button" @click="active = (active - 1 + total) % total" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-black text-slate-700 hover:bg-slate-50">Prev</button>
                                <div class="flex items-center gap-2">
                                    @foreach ($produks->take(4)->values() as $produk)
                                        <button type="button" @click="active = {{ $loop->index }}" class="h-2.5 w-2.5 rounded-full" :class="active === {{ $loop->index }} ? 'bg-emerald-600' : 'bg-slate-300'"></button>
                                    @endforeach
                                </div>
                                <button type="button" @click="active = (active + 1) % total" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-black text-slate-700 hover:bg-slate-50">Next</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wide text-emerald-700">Etalase terbaru</p>
                    <h2 class="mt-2 text-3xl font-black tracking-tight">Produk Populer</h2>
                </div>
                <a href="{{ route('pembeli.dashboard') }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-800">Lihat semua produk</a>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($produks as $produk)
                    <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <a href="{{ route('pembeli.produk.show', $produk) }}" class="block">
                            <div class="aspect-square overflow-hidden bg-slate-100">
                                @if ($produk->gambar_url)
                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-emerald-100 via-white to-amber-100 p-4 text-center font-bold">{{ $produk->nama_produk }}</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="text-xs font-bold uppercase text-slate-500">{{ $produk->kategori->nama_kategori ?? 'Tanpa kategori' }}</div>
                                <h3 class="mt-1 line-clamp-2 min-h-12 font-bold leading-6">{{ $produk->nama_produk }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">{{ $produk->deskripsi }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="font-black text-emerald-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">Stok {{ $produk->stok }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 sm:col-span-2 lg:col-span-4">
                        Belum ada produk.
                    </div>
                @endforelse
            </div>
        </section>
    </main>
</body>

</html>
