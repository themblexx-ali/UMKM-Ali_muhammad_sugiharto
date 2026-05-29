<form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Kategori
        </label>
        <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}"
            class="w-full rounded-md border-gray-300 shadow-sm focus: border-indigo-500 focus: ring-indigo-500 text-sm"
            required autofocus>
    </div>
    <div class="flex items-center gap-4">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md text-sm transition
focus:outline-none focus: ring-2 focus: ring-offset-2 focus: ring-indigo-500">
            Update Kategori
        </button>
        <a href="{{ route('admin.kategori') }}" class="text-smtext-gray-600 hover: text-gray-900 hover:underline">
            Batal
        </a>
    </div>
</form>