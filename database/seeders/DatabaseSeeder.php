<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin UMKM',
            'username' => 'admin',
            'hp' => '081234567890',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::updateOrCreate(['email' => 'pelanggan@example.com'], [
            'name' => 'Pelanggan UMKM',
            'username' => 'pelanggan',
            'hp' => '081298765432',
            'role' => 'pembeli',
            'password' => bcrypt('password'),
        ]);

        $makanan = Kategori::firstOrCreate(['nama_kategori' => 'Makanan']);
        $kerajinan = Kategori::firstOrCreate(['nama_kategori' => 'Kerajinan']);

        Produk::updateOrCreate(['nama_produk' => 'Keripik Singkong Original'], [
            'kategori_id' => $makanan->id,
            'deskripsi' => 'Keripik singkong renyah produksi UMKM lokal dengan bumbu gurih.',
            'harga' => 18000,
            'stok' => 30,
        ]);

        Produk::updateOrCreate(['nama_produk' => 'Tas Anyaman Mini'], [
            'kategori_id' => $kerajinan->id,
            'deskripsi' => 'Tas anyaman handmade yang cocok untuk hadiah dan kebutuhan harian.',
            'harga' => 75000,
            'stok' => 12,
        ]);
    }
}
