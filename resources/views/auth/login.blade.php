<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Selamat datang</p>
        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Masuk ke akun</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600">Gunakan username atau email yang sudah terdaftar.</p>
    </div>

    <x-auth-session-status class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Login -->
        <div>
            <x-input-label for="login" :value="__('Username / Email')" class="text-sm font-bold text-slate-700" />
            <x-text-input id="login" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-bold text-slate-700" />

            <x-text-input id="password" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="ms-2 text-sm font-medium text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-emerald-700 hover:text-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="space-y-4 pt-2">
            <x-primary-button class="flex w-full justify-center rounded-lg bg-emerald-600 px-4 py-3 text-sm font-bold text-white hover:bg-emerald-700 focus:bg-emerald-700 focus:ring-emerald-500 active:bg-emerald-800">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('register'))
                <a class="block rounded-lg border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" href="{{ route('register') }}">
                    {{ __('Dont have an account?') }} {{ __('Register') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
