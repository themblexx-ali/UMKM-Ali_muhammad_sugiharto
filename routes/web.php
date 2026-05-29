<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembeliController;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::user()) {
        $role = Auth::user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'karyawan') return redirect()->route('karyawan.dashboard');
        return redirect()->route('pembeli.dashboard');
    }
    $produks = Produk::with('kategori')->latest()->take(6)->get();
    $kategoris = Kategori::withCount('produk')->get();

    return view('welcome', compact('produks', 'kategoris'));
})->name('home');

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'karyawan') return redirect()->route('karyawan.dashboard');

    return redirect()->route('pembeli.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pembeli/dashboard', [PembeliController::class, 'index'])->name('pembeli.dashboard');
Route::get('/pembeli/produk/{produk}', [PembeliController::class, 'show'])->name('pembeli.produk.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    //Kategori
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::delete('/admin/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');
    Route::get('/admin/kategori/{id}/edit', [AdminController::class, 'editKategori'])->name('admin.kategori.edit');
    Route::put('/admin/kategori/{id}', [AdminController::class, 'updateKategori'])->name('admin.kategori.update');
    //user
    Route::get('/admin/user', [AdminController::class, 'user'])->name('admin.user');
    Route::post('/admin/user', [AdminController::class, 'storeUser'])->name('admin.user.store');
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
    Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::get('/admin/user/{id}/reset', [AdminController::class, 'resetPassword'])->name('admin.user.reset');
    //produk
    Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
    Route::post('/admin/produk', [AdminController::class, 'storeProduk'])->name('admin.produk.store');
    Route::delete('/admin/produk/{id}', [AdminController::class, 'destroyProduk'])->name('admin.produk.destroy');
    Route::get('/admin/produk/{id}/edit', [AdminController::class, 'editProduk'])->name('admin.produk.edit');
    Route::put('/admin/produk/{id}', [AdminController::class, 'updateProduk'])->name('admin.produk.update');
    //transaksi
    Route::get('/admin/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/admin/transaksi/{invoice}', [AdminController::class, 'detailTransaksi'])->name('admin.transaksi.detail');
    Route::delete('/admin/transaksi/{invoice}', [AdminController::class, 'destroyTransaksi'])->name('admin.transaksi.destroy');
});
//karyawan
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'index'])->name('karyawan.dashboard');
});
//pembeli
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::post('/pembeli/keranjang', [PembeliController::class, 'addToCart'])->name('pembeli.cart.add');
    Route::get('/pembeli/keranjang', [PembeliController::class, 'cart'])->name('pembeli.cart');
    Route::patch('/pembeli/keranjang/{produk}', [PembeliController::class, 'updateCart'])->name('pembeli.cart.update');
    Route::delete('/pembeli/keranjang/{produk}', [PembeliController::class, 'removeCart'])->name('pembeli.cart.remove');
    Route::post('/pembeli/checkout', [PembeliController::class, 'checkout'])->name('pembeli.checkout');
    Route::get('/pembeli/invoice/{invoice}', [PembeliController::class, 'invoice'])->name('pembeli.invoice');
    Route::post('/pembeli/produk', [PembeliController::class, 'store'])->name('pembeli.store');
    Route::get('/pembeli/riwayat', [PembeliController::class, 'riwayat'])->name('pembeli.riwayat');
});

require __DIR__.'/auth.php';
