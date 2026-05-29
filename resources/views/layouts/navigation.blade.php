@php
    $linkClass = 'flex items-center justify-between rounded-md px-3 py-2.5 text-sm font-bold transition';
    $inactiveClass = 'text-slate-600 hover:bg-slate-100 hover:text-slate-950';
    $activeClass = 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200';
@endphp

<nav x-data="{ open: false }">
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 border-r border-slate-200 bg-white lg:flex lg:flex-col">
        <div class="flex h-20 items-center border-b border-slate-200 px-5">
            <a href="{{ Auth::check() ? route('dashboard') : route('home') }}" class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-md bg-emerald-600 text-xl font-black text-white">A</span>
                <span class="leading-tight">
                    <span class="block text-base font-black text-slate-950">Toko SRC Ali</span>
                    <span class="block text-xs font-medium text-slate-500">Online store</span>
                </span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-5">
            <div class="mb-3 px-3 text-xs font-black uppercase tracking-wide text-slate-400">Menu</div>
            <div class="space-y-1">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a>
                        <a href="{{ route('admin.kategori') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.kategori') ? $activeClass : $inactiveClass }}">Kategori</a>
                        <a href="{{ route('admin.user') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.user') ? $activeClass : $inactiveClass }}">User</a>
                        <a href="{{ route('admin.produk') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.produk') ? $activeClass : $inactiveClass }}">Produk</a>
                        <a href="{{ route('admin.transaksi') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.transaksi*') ? $activeClass : $inactiveClass }}">Transaksi</a>
                    @elseif (Auth::user()->role === 'karyawan')
                        <a href="{{ route('karyawan.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('karyawan.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a>
                    @elseif (Auth::user()->role === 'pembeli')
                        <a href="{{ route('pembeli.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.dashboard') ? $activeClass : $inactiveClass }}">Etalase</a>
                        <a href="{{ route('pembeli.cart') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.cart') ? $activeClass : $inactiveClass }}">Keranjang</a>
                        <a href="{{ route('pembeli.riwayat') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.riwayat') ? $activeClass : $inactiveClass }}">Riwayat Pembelian</a>
                    @endif
                @else
                    <a href="{{ route('pembeli.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.dashboard') ? $activeClass : $inactiveClass }}">Etalase</a>
                @endauth
            </div>
        </div>

        <div class="border-t border-slate-200 p-4">
            <a href="{{ route('pembeli.dashboard') }}" class="block rounded-lg bg-slate-50 p-3 text-sm font-bold text-slate-700 hover:bg-slate-100">
                Browse catalog
            </a>
        </div>
    </aside>

    <div class="fixed right-6 top-5 z-50 hidden lg:block" x-data="{ profileOpen: false }">
        @auth
            <button type="button" @click="profileOpen = ! profileOpen" class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-3 py-2 shadow-sm hover:bg-slate-50">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-sm font-black text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                <span class="text-left">
                    <span class="block text-sm font-black leading-4 text-slate-950">{{ Auth::user()->name }}</span>
                    <span class="block max-w-40 truncate text-xs font-medium text-slate-500">{{ Auth::user()->email }}</span>
                </span>
            </button>

            <div x-show="profileOpen" x-transition @click.outside="profileOpen = false" class="absolute right-0 mt-2 w-56 rounded-lg border border-slate-200 bg-white p-2 shadow-lg">
                <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-md px-3 py-2 text-left text-sm font-bold text-red-600 hover:bg-red-50">Log Out</button>
                </form>
            </div>
        @else
            <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-white p-1 shadow-sm">
                <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100">Login</a>
                <a href="{{ route('register') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">Registrasi</a>
            </div>
        @endauth
    </div>

    <div class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur lg:hidden">
        <div class="flex h-16 items-center justify-between px-4">
            <a href="{{ Auth::check() ? route('dashboard') : route('home') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-600 text-lg font-black text-white">A</span>
                <span class="text-sm font-black text-slate-950">Toko SRC Ali</span>
            </a>
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('profile.edit') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-sm font-black text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</a>
                @endauth
                <button @click="open = ! open" class="rounded-md border border-slate-300 p-2 text-slate-700">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition class="border-t border-slate-200 bg-white px-4 py-4">
            <div class="space-y-1">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a>
                        <a href="{{ route('admin.kategori') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.kategori') ? $activeClass : $inactiveClass }}">Kategori</a>
                        <a href="{{ route('admin.user') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.user') ? $activeClass : $inactiveClass }}">User</a>
                        <a href="{{ route('admin.produk') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.produk') ? $activeClass : $inactiveClass }}">Produk</a>
                        <a href="{{ route('admin.transaksi') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.transaksi*') ? $activeClass : $inactiveClass }}">Transaksi</a>
                    @elseif (Auth::user()->role === 'karyawan')
                        <a href="{{ route('karyawan.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('karyawan.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a>
                    @elseif (Auth::user()->role === 'pembeli')
                        <a href="{{ route('pembeli.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.dashboard') ? $activeClass : $inactiveClass }}">Etalase</a>
                        <a href="{{ route('pembeli.cart') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.cart') ? $activeClass : $inactiveClass }}">Keranjang</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="{{ $linkClass }} {{ request()->routeIs('profile.edit') ? $activeClass : $inactiveClass }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-md px-3 py-2.5 text-left text-sm font-bold text-red-600 transition hover:bg-red-50">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('pembeli.dashboard') }}" class="{{ $linkClass }} {{ request()->routeIs('pembeli.dashboard') ? $activeClass : $inactiveClass }}">Etalase</a>
                    <a href="{{ route('login') }}" class="{{ $linkClass }} {{ request()->routeIs('login') ? $activeClass : $inactiveClass }}">Login</a>
                    <a href="{{ route('register') }}" class="{{ $linkClass }} {{ request()->routeIs('register') ? $activeClass : $inactiveClass }}">Registrasi</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
