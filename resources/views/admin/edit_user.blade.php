<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-4 rounded-lg bg-white p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama User</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <input type="text" name="hp" value="{{ old('hp', $user->hp) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm">
                        <option value="pembeli" @selected(old('role', $user->role) === 'pembeli')>Pembeli</option>
                        <option value="karyawan" @selected(old('role', $user->role) === 'karyawan')>Karyawan</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password baru</label>
                    <input type="password" name="password" class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="Kosongkan jika tidak diubah">
                </div>
                <div class="flex items-center gap-4">
                    <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Update User</button>
                    <a href="{{ route('admin.user') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-950">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
