<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah Produk</h3>
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    @csrf
                    <input type="text" name="nama_produk" placeholder="Nama Produk" required
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <input type="number" name="harga" placeholder="Harga" required
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <input type="number" name="stok" placeholder="Stok" required
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <select name="kategori_id" required
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @foreach ($kategoris as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="deskripsi" placeholder="Deskripsi" required
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp"
                        class="rounded-md border border-gray-300 px-3 py-2 text-sm">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-md text-sm transition md:col-span-6">
                        Tambah Produk
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Produk</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($produks as $p)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $p->nama_produk }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">
                                    @if ($p->gambar_url)
                                        <img src="{{ $p->gambar_url }}" alt="{{ $p->nama_produk }}" class="h-12 w-12 rounded object-cover">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $p->harga }}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">{{ $p->stok }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.produk.edit', $p->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">
                                    Belum ada produk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
