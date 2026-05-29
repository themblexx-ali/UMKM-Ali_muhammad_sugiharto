<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Buat akun</p>
        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Daftar sebagai pembeli</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">Lengkapi data akun untuk mulai berbelanja produk UMKM.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-bold text-slate-700" />
            <x-text-input id="name" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-sm font-bold text-slate-700" />
            <x-text-input id="username" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-bold text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="hp" :value="__('No. HP')" class="text-sm font-bold text-slate-700" />
            <x-text-input id="hp" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="hp" :value="old('hp')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('hp')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-bold text-slate-700" />

            <x-text-input id="password" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-bold text-slate-700" />

            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4 pt-2">
            <x-primary-button class="flex w-full justify-center rounded-lg bg-emerald-600 px-4 py-3 text-sm font-bold text-white hover:bg-emerald-700 focus:bg-emerald-700 focus:ring-emerald-500 active:bg-emerald-800">
                {{ __('Register') }}
            </x-primary-button>

            <a class="block rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" href="{{ route('login') }}">
                {{ __('Already registered?') }} {{ __('Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
