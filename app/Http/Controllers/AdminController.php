<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $totalKategori = Kategori::count();
        $totalProduk = Produk::count();
        $totalUser = User::where('role', 'pembeli')->count();
        $totalTransaksi = Transaksi::distinct('invoice_code')->count('invoice_code');
        $totalPendapatan = Transaksi::sum('total_harga');
        $transaksis = Transaksi::with(['user', 'produk'])
            ->latest()
            ->get()
            ->groupBy(fn ($transaksi) => $transaksi->invoice_code ?: 'TRX-'.$transaksi->id);

        return view('admin.dashboard', compact('totalKategori', 'totalProduk', 'totalUser', 'totalTransaksi', 'totalPendapatan', 'transaksis'));
    }

    public function kategori()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori', compact('kategoris'));
    }
    public function storeKategori(Request $req)
    {
        $req->validate(['nama_kategori' => ['required', 'string', 'max:255']]);

        Kategori::create($req->only('nama_kategori'));
        return back()->with('success', 'Kategori berhasil ditambahkan');
    }
    public function destroyKategori($id)
    {
        Kategori::destroy($id);
        return back()->with('success', 'Kategori berhasil dihapus');
    }
    public function editKategori($id)
    {
        $kategori = Kategori::find($id);
        return view('admin.edit_kategori', compact('kategori'));
    }
    public function updateKategori(Request $req, $id)
    {
        $k = Kategori::findOrFail($id);
        $k->update($req->all());
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diupdate');
    }
    // user
    public function user()
    {
        $users = User::all();
        $userRole = User::where('role', 'pembeli')->get();
        return view('admin.user', compact('users', 'userRole'));
    }
    public function storeUser(Request $req)
    {
        $data = $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'hp' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(['admin', 'karyawan', 'pembeli'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return back()->with('success', 'User berhasil ditambahkan');
    }
    public function destroyUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus');
    }
    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.edit_user', compact('user'));
    }
    public function updateUser(Request $req, $id)
    {
        $u = User::findOrFail($id);
        $data = $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users', 'username')->ignore($u->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($u->id)],
            'hp' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(['admin', 'karyawan', 'pembeli'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);
        if ($req->password) {
            $data['password'] = Hash::make($req->password);
        } else {
            unset($data['password']);
        }
        $u->update($data);

        return redirect()->route('admin.user')->with('success', 'User berhasil diupdate');
    }
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make('password')]);

        return redirect()->route('admin.user')->with('success', 'Password berhasil direset menjadi "password"');
    }
    //produk
    public function produk()
    {
        $produks = Produk::with('kategori')->get();
        $kategoris = Kategori::all();
        return view('admin.produk', compact('produks', 'kategoris'));
    }
    public function storeProduk(Request $req)
    {
        $data = $req->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($req->hasFile('gambar')) {
            $data['gambar'] = $req->file('gambar')->store('produk', 'public');
        }

        Produk::create($data);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }
    public function destroyProduk($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }
    public function editProduk($id)
    {
        $produk = Produk::find($id);
        $kategoris = Kategori::all();
        return view('admin.edit_produk', compact('produk', 'kategoris'));
    }
    public function updateProduk(Request $req, $id)
    {
        $p = Produk::findOrFail($id);
        $data = $req->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($req->hasFile('gambar')) {
            if ($p->gambar) {
                Storage::disk('public')->delete($p->gambar);
            }

            $data['gambar'] = $req->file('gambar')->store('produk', 'public');
        } else {
            unset($data['gambar']);
        }

        $p->update($data);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diupdate');
    }

    public function transaksi()
    {
        $transaksis = Transaksi::with(['user', 'produk'])
            ->latest()
            ->get()
            ->groupBy(fn ($transaksi) => $transaksi->invoice_code ?: 'TRX-'.$transaksi->id);

        return view('admin.transaksi', compact('transaksis'));
    }

    public function detailTransaksi(string $invoice)
    {
        $items = Transaksi::with(['user', 'produk'])
            ->where('invoice_code', $invoice)
            ->get();

        if ($items->isEmpty() && str_starts_with($invoice, 'TRX-')) {
            $items = Transaksi::with(['user', 'produk'])
                ->where('id', (int) str_replace('TRX-', '', $invoice))
                ->get();
        }

        abort_if($items->isEmpty(), 404);

        return view('admin.detail_transaksi', [
            'invoice' => $invoice,
            'items' => $items,
        ]);
    }

    public function destroyTransaksi(string $invoice)
    {
        $query = Transaksi::where('invoice_code', $invoice);

        if (! $query->exists() && str_starts_with($invoice, 'TRX-')) {
            $query = Transaksi::where('id', (int) str_replace('TRX-', '', $invoice));
        }

        $query->delete();

        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil dihapus');
    }
}
