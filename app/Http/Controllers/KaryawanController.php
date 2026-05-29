<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'produk'])->latest()->get();
        return view('karyawan.dashboard', compact('transaksis'));
    }
}
