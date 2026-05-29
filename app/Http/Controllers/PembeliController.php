<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategoriId = $request->input('kategori');
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $produks = Produk::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('nama_produk', 'like', "%{$search}%");
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                $query->where('kategori_id', $kategoriId);
            })
            ->latest()
            ->get();

        $riwayats = Transaksi::with('produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        $cartCount = collect($request->session()->get('cart', []))->sum();

        return view('pembeli.dashboard', compact('produks', 'riwayats', 'kategoris', 'kategoriId', 'cartCount'));
    }

    public function show(Produk $produk)
    {
        $produk->load('kategori');

        return view('pembeli.detail_produk', compact('produk'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'produk_id' => ['required', 'exists:produks,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $produk = Produk::findOrFail($data['produk_id']);
        $cart = $request->session()->get('cart', []);
        $currentQuantity = $cart[$produk->id] ?? 0;
        $newQuantity = $currentQuantity + $data['jumlah'];

        if ($newQuantity > $produk->stok) {
            return back()->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        }

        $cart[$produk->id] = $newQuantity;
        $request->session()->put('cart', $cart);

        return redirect()->route('pembeli.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function cart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $items = Produk::with('kategori')
            ->whereIn('id', array_keys($cart))
            ->get()
            ->map(function ($produk) use ($cart) {
                $produk->jumlah_keranjang = $cart[$produk->id] ?? 0;
                $produk->subtotal = $produk->jumlah_keranjang * $produk->harga;

                return $produk;
            });
        $total = $items->sum('subtotal');

        return view('pembeli.cart', compact('items', 'total'));
    }

    public function updateCart(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:'.$produk->stok],
        ]);

        $cart = $request->session()->get('cart', []);
        $cart[$produk->id] = $data['jumlah'];
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function removeCart(Request $request, Produk $produk)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$produk->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'metode_pembayaran' => ['required', 'string', 'max:255'],
            'metode_pengiriman' => ['required', 'string', 'max:255'],
            'alamat_pengiriman' => ['required', 'string', 'max:1000'],
        ]);
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pembeli.cart')->with('error', 'Keranjang masih kosong.');
        }

        $invoiceCode = 'INV-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));

        DB::transaction(function () use ($cart, $data, $invoiceCode) {
            $produks = Produk::whereIn('id', array_keys($cart))->lockForUpdate()->get();

            foreach ($produks as $produk) {
                $jumlah = $cart[$produk->id] ?? 0;

                if ($jumlah < 1 || $jumlah > $produk->stok) {
                    abort(422, 'Stok produk '.$produk->nama_produk.' tidak mencukupi.');
                }

                Transaksi::create([
                    'invoice_code' => $invoiceCode,
                    'user_id' => Auth::id(),
                    'produk_id' => $produk->id,
                    'jumlah' => $jumlah,
                    'tanggal_beli' => now()->toDateString(),
                    'total_harga' => $jumlah * $produk->harga,
                    'status' => 'dibayar',
                    'metode_pembayaran' => $data['metode_pembayaran'],
                    'metode_pengiriman' => $data['metode_pengiriman'],
                    'alamat_pengiriman' => $data['alamat_pengiriman'],
                ]);

                $produk->decrement('stok', $jumlah);
            }
        });

        $request->session()->forget('cart');

        return redirect()->route('pembeli.invoice', $invoiceCode)->with('success', 'Pembelian berhasil. Invoice siap dicetak.');
    }

    public function invoice(string $invoice)
    {
        $items = Transaksi::with(['produk.kategori', 'user'])
            ->where('user_id', Auth::id())
            ->where('invoice_code', $invoice)
            ->get();

        abort_if($items->isEmpty(), 404);

        return view('pembeli.invoice', compact('invoice', 'items'));
    }

    public function store(Request $request)
    {
        return $this->addToCart($request);
    }

    public function riwayat()
    {
        $riwayats = Transaksi::with(['produk.kategori'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->groupBy('invoice_code');

        return view('pembeli.riwayat', compact('riwayats'));
    }
}
