<section>
    @if(Auth::check() && Auth::user()->role === 'siswa')
        <!-- SISWA MOBILE CARD UPDATE PASSWORD FORM -->
        <div class="bg-white rounded-[32px] p-6 sm:p-8 shadow-xl border border-slate-100 max-w-md mx-auto space-y-4 text-slate-800">
            <div>
                <h3 class="text-base font-extrabold text-slate-800">Update Password</h3>
                <p class="text-xs text-slate-400 mt-1">Gunakan password yang kuat untuk menjaga keamanan akunmu.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label for="update_password_current_password" class="block text-xs font-extrabold text-slate-800 mb-1.5">Current Password</label>
                    <div class="relative">
                        <input type="password" id="update_password_current_password" name="current_password" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                </div>

                <!-- New Password -->
                <div>
                    <label for="update_password_password" class="block text-xs font-extrabold text-slate-800 mb-1.5">New Password</label>
                    <div class="relative">
                        <input type="password" id="update_password_password" name="password" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="update_password_password_confirmation" class="block text-xs font-extrabold text-slate-800 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="update_password_password_confirmation" name="password_confirmation" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Action Button -->
                <div class="pt-3">
                    <button type="submit" class="w-full h-12 bg-primary hover:bg-primary-dark text-white font-bold rounded-2xl text-xs transition-all shadow-lg shadow-primary/25 active:scale-95 duration-200">
                        Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-center text-xs font-bold text-emerald-600 mt-2">
                            Password Berhasil Diperbarui!
                        </p>
                    @endif
                </div>
            </form>
        </div>
    @else
        <!-- ADMIN / GURU ELEGANT CLEAN CARD UI -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4 text-slate-800">
            <div>
                <h3 class="text-base font-extrabold text-slate-800">Perbarui Password</h3>
                <p class="text-xs text-slate-400 mt-1">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label for="update_password_current_password" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" id="update_password_current_password" name="current_password" required
                            class="w-full h-11 pl-4 pr-10 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                </div>

                <!-- New Password -->
                <div>
                    <label for="update_password_password" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="update_password_password" name="password" required
                            class="w-full h-11 pl-4 pr-10 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="update_password_password_confirmation" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="update_password_password_confirmation" name="password_confirmation" required
                            class="w-full h-11 pl-4 pr-10 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Action Button -->
                <div class="pt-2 flex items-center gap-4">
                    <button type="submit" class="px-6 h-11 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl text-xs transition-all shadow-md active:scale-95 duration-200">
                        Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-emerald-600">
                            Password Berhasil Diperbarui!
                        </p>
                    @endif
                </div>
            </form>
        </div>
    @endif
</section>
