<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'invoice_code',
        'user_id',
        'produk_id',
        'jumlah',
        'tanggal_beli',
        'total_harga',
        'status',
        'metode_pembayaran',
        'metode_pengiriman',
        'alamat_pengiriman',
    ];

    protected $casts = [
        'tanggal_beli' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
