<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @if ($user->role === 'pembeli')
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Transaksi</h3>
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500">Invoice</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($riwayats as $invoice => $items)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $invoice }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ optional($items->first()->tanggal_beli)->format('d M Y') ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-600">Rp {{ number_format($items->sum('total_harga'), 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right">
                                            @if ($items->first()->invoice_code)
                                                <a href="{{ route('pembeli.invoice', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">Cetak invoice</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
