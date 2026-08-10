<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('siswa.login.store') }}" class="space-y-5">
        @csrf

        <!-- Logo & Header -->
        <div class="text-center pb-2">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-primary to-indigo-500 shadow-lg shadow-primary/30 text-white font-black text-2xl mb-4">
                S
            </div>
            <h2 class="text-2xl font-black text-dark-navy tracking-tight">Masuk / Daftar Siswa</h2>
            <p class="text-xs font-semibold text-muted-gray mt-1.5 leading-relaxed max-w-xs mx-auto">
                Cukup masukkan alamat email milikmu. Tanpa password dan langsung otomatis masuk!
            </p>
        </div>

        <!-- Info Card -->
        <div class="p-3.5 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl flex items-start gap-3">
            <div class="p-1.5 bg-emerald-500 text-white rounded-xl shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-[11px] font-medium text-emerald-900 leading-snug">
                <strong>Praktis & Otomatis:</strong> Sesi masukmu akan langsung tersimpan di browser HP ini, jadi selanjutnya kamu bisa langsung buka tanpa perlu ketik email lagi.
            </p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Alamat Email Siswa</label>
            <div class="relative">
                <input id="email" class="block w-full h-12 pl-11 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-sm font-semibold placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" 
                    type="email" name="email" :value="old('email')" placeholder="contoh: nama.siswa@gmail.com" required autofocus autocomplete="username" />
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-500 font-bold" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center h-12 px-5 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                <span>Lanjutkan ke SmartSip</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        <!-- Footer / Teacher Login Link -->
        <div class="pt-4 border-t border-slate-100 text-center">
            <p class="text-xs font-medium text-slate-500">
                Login sebagai Guru / Admin? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:underline ml-1">
                    Login dengan Password
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
