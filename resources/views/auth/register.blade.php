<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Logo & Header -->
        <div class="text-center pb-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary shadow-lg shadow-primary/25 text-white font-extrabold text-xl mb-3">
                S
            </div>
            <h2 class="text-xl font-extrabold text-dark-navy tracking-tight">Bergabung Bersama Kami</h2>
            <p class="text-xs text-muted-gray mt-1 leading-normal">Buat akun untuk memulai perjalanan sehatmu</p>
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-1.5">{{ __('Nama Lengkap') }}</label>
            <input id="name" class="block w-full h-11 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" 
                type="text" name="name" :value="old('name')" placeholder="Cth: Budi Santoso" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-1.5">{{ __('Email Address') }}</label>
            <input id="email" class="block w-full h-11 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" 
                type="email" name="email" :value="old('email')" placeholder="you@example.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-1.5">{{ __('Password') }}</label>
            <input id="password" class="block w-full h-11 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner"
                type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-1.5">{{ __('Konfirmasi Password') }}</label>
            <input id="password_confirmation" class="block w-full h-11 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner"
                type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Submit Button & Login Link -->
        <div class="pt-3 space-y-4">
            <button type="submit" class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                {{ __('Daftar Sekarang') }}
            </button>
            
            <p class="text-center text-xs text-muted-gray font-semibold">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
