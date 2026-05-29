<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User') }}
    </h2>
    </x-slot>
    
<div class="py-12">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah User</h3>
        <form action="{{ route('admin.user.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" required
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus: ring-indigo-500 text-sm">
            <input type="email" name="email" placeholder="Email" required
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus: ring-indigo-500 text-sm">
            <input type="text" name="hp" placeholder="No. HP"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus: ring-indigo-500 text-sm">
            <input type="password" name="password" placeholder="Password" required
                class="rounded-md border-gray-300 shadow-smfocus:border-indigo-500 focus: ring-indigo-500 text-sm">
            <select name="role"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus: ring-indigo-500 text-sm">
                <option value="pembeli">Pembeli</option>
                <option value="karyawan">Karyawan</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-md text-sm transition">
                Tambah User
            </button>
        </form>
    </div>
</div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Akun</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">HP</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $user->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $user->hp ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $user->role }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.user.edit', $user->id) }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Pembeli</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">HP</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($userRole as $u)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $u->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $u->username }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $u->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $u->hp ?? '-' }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.user.reset', $u->id) }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Reset Password
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            
</x-app-layout>
