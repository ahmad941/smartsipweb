<section>
    @if(Auth::check() && Auth::user()->role === 'siswa')
        <!-- SISWA MOBILE CARD DELETE ACCOUNT FORM -->
        <div class="bg-white rounded-[32px] p-6 sm:p-8 shadow-xl border border-slate-100 max-w-md mx-auto space-y-4 text-slate-800">
            <div>
                <h3 class="text-base font-extrabold text-rose-600">Delete Account</h3>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                    Setelah akun Anda dihapus, semua data dan sumber daya penelitian Anda akan dihapus secara permanen.
                </p>
            </div>

            <div>
                <button type="button"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="w-full h-12 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl text-xs transition-all shadow-lg shadow-rose-500/25 active:scale-95 duration-200">
                    Delete Account
                </button>
            </div>
        </div>
    @else
        <!-- ADMIN & GURU ELEGANT CLEAN CARD FORM -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4 text-slate-800">
            <div>
                <h3 class="text-base font-extrabold text-rose-600">Delete Account</h3>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                    Setelah akun Anda dihapus, semua data dan sumber daya penelitian terkait akan dihapus secara permanen.
                </p>
            </div>

            <div>
                <button type="button"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-5 h-11 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95">
                    Delete Account
                </button>
            </div>
        </div>
    @endif

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-base font-extrabold text-slate-800">
                Apakah Anda yakin ingin menghapus akun ini?
            </h2>

            <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                Setelah akun dihapus, seluruh data penelitian akan terhapus permanen. Masukkan kata sandi Anda untuk mengonfirmasi.
            </p>

            <div class="mt-4">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Konfirmasi Password Anda"
                    class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 h-10 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 h-10 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow-md">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
