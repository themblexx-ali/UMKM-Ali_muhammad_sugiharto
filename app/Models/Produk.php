<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    protected $fillable = ['kategori_id', 'nama_produk', 'deskripsi', 'harga', 'gambar', 'stok'];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        return Storage::url($this->gambar);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
