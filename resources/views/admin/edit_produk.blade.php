<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" placeholder="Nama Produk" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                    <input type="number" name="harga" value="{{ $produk->harga }}" placeholder="Harga" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                    <input type="number" name="stok" value="{{ $produk->stok }}" placeholder="Stok" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                    <select name="kategori_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @foreach ($kategoris as $k)
                        <option value="{{ $k->id }}" @selected($produk->kategori_id === $k->id)>
                            {{ $k->nama_kategori }}
                        </option>
                        @endforeach
                    </select>

                    <input type="text" name="deskripsi" value="{{ $produk->deskripsi }}" placeholder="Deskripsi" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                    @if ($produk->gambar_url)
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-700">Gambar saat ini</p>
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="h-28 w-28 rounded object-cover">
                        </div>
                    @endif

                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
