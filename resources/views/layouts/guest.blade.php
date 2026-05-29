<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Toko SRC Ali') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto grid min-h-[calc(100vh-3rem)] w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200 lg:grid-cols-[0.95fr_1.05fr]">
                <div class="hidden bg-slate-950 px-10 py-12 text-white lg:flex lg:flex-col lg:justify-between">
                    <a href="/" class="inline-flex items-center gap-3">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500 text-lg font-black text-slate-950">
                            AU
                        </span>
                        <span>
                            <span class="block text-lg font-bold leading-tight">Toko SRC Ali</span>
                            <span class="block text-sm text-emerald-100">Toko Klontong Modern dan Kekinian</span>
                        </span>
                    </a>

                    <div class="space-y-6">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-300">Toko SRC Modern & Gaul</p>
                            <h1 class="mt-4 max-w-md text-4xl font-black leading-tight">
                                Masuk, pilih produk, dan kelola pembelian dengan rapi.
                            </h1>
                        </div>

                        <div class="grid gap-3 text-sm text-slate-200">
                            <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                <p class="font-bold text-white">Etalase produk</p>
                                <p class="mt-1 text-slate-300">Temukan produk UMKM dari kategori yang tersedia.</p>
                            </div>
                            <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                <p class="font-bold text-white">Riwayat pembelian</p>
                                <p class="mt-1 text-slate-300">Invoice dan transaksi tersimpan untuk dicek kembali.</p>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400">Akses khusus pembeli, karyawan, dan admin.</p>
                </div>

                <div class="flex min-h-full flex-col justify-center px-5 py-8 sm:px-10 lg:px-14">
                    <div class="mb-8 flex items-center justify-between lg:hidden">
                        <a href="/" class="inline-flex items-center gap-3">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-slate-950 text-sm font-black text-white">
                                AU
                            </span>
                            <span class="text-base font-bold">{{ config('app.name', 'Toko SRC Ali') }}</span>
                        </a>
                    </div>

                    <div class="mx-auto w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
