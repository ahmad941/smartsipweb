<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Logo & Header -->
        <div class="text-center pb-4">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary shadow-lg shadow-primary/25 text-white font-extrabold text-xl mb-4">
                S
            </div>
            <h2 class="text-xl font-extrabold text-dark-navy tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs text-muted-gray mt-1 leading-normal">Silakan masuk ke akun SmartSip Anda</p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
            <input id="email" class="block w-full h-12 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" 
                type="email" name="email" :value="old('email')" placeholder="you@example.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-primary hover:underline" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <input id="password" class="block w-full h-12 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner"
                type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Remember Me & Register link -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-slate-200 text-primary focus:ring-primary/20 w-4 h-4 cursor-pointer" name="remember">
                <span class="ms-2 text-xs font-semibold text-muted-gray group-hover:text-dark-navy transition-colors">{{ __('Remember me') }}</span>
            </label>
            
            <a href="{{ route('register') }}" class="text-xs font-bold text-primary hover:underline">
                Daftar Akun Baru
            </a>
        </div>

        <!-- Submit Button -->
        <div class="pt-3">
            <button type="submit" class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                {{ __('Masuk ke SmartSip') }}
            </button>
        </div>
    </form>
</x-guest-layout>
