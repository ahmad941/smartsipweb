<section>
    @if($user->student)
        <!-- SISWA MOBILE CARD PROFILE FORM MATCHING REFERENCE DESIGN -->
        <div class="bg-white rounded-[32px] p-6 sm:p-8 shadow-xl border border-slate-100 max-w-md mx-auto relative space-y-5 text-slate-800">
            
            <!-- Top Avatar Circle with + Badge -->
            <div class="relative w-24 h-24 mx-auto mb-6">
                <div class="w-24 h-24 rounded-full bg-primary/10 text-primary font-extrabold text-3xl flex items-center justify-center border-4 border-white shadow-md">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="absolute top-0 right-0 w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md border-2 border-white cursor-pointer">
                    +
                </div>
            </div>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-extrabold text-slate-800 mb-1.5">Full Name</label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-extrabold text-slate-800 mb-1.5">Email Address</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('email')" />
                </div>

                <!-- Asal Sekolah -->
                <div>
                    <label for="school_id" class="block text-xs font-extrabold text-slate-800 mb-1.5">Asal Sekolah</label>
                    <div class="relative">
                        <select id="school_id" name="school_id" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer">
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id', $user->student->school_id) == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ strtoupper($school->group_type) }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('school_id')" />
                </div>

                <!-- Kelas Belajar -->
                <div>
                    <label for="class_id" class="block text-xs font-extrabold text-slate-800 mb-1.5">Kelas Belajar</label>
                    <div class="relative">
                        <select id="class_id" name="class_id" required
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $user->student->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('class_id')" />
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nickname" class="block text-xs font-extrabold text-slate-800 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" id="nickname" name="nickname" value="{{ old('nickname', $user->student->nickname) }}"
                            class="w-full h-12 pl-4 pr-10 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('nickname')" />
                </div>

                <!-- Update Profile Button -->
                <div class="pt-3">
                    <button type="submit" class="w-full h-12 bg-primary hover:bg-primary-dark text-white font-bold rounded-2xl text-xs transition-all shadow-lg shadow-primary/25 active:scale-95 duration-200">
                        Update Profile
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-center text-xs font-bold text-emerald-600 mt-2">
                            Profil Berhasil Diperbarui!
                        </p>
                    @endif
                </div>

                <a href="{{ route('dashboard') }}" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors mt-2">
                    Kembali ke Dashboard
                </a>
            </form>
        </div>
    @else
        <!-- ADMIN / GURU ELEGANT CLEAN CARD UI -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5 text-slate-800">
            <!-- Top Profile Header for Admin/Guru -->
            <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                <div class="w-14 h-14 rounded-full bg-slate-100 border-2 border-slate-200 flex items-center justify-center text-primary font-extrabold text-xl shadow-inner shrink-0">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">{{ $user->name }}</h3>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider
                        @if($user->role === 'admin') bg-purple-50 text-purple-600 border border-purple-200
                        @elseif($user->role === 'guru') bg-emerald-50 text-emerald-600 border border-emerald-200
                        @else bg-blue-50 text-blue-600 border border-blue-200 @endif">
                        Peran: {{ strtoupper($user->role) }}
                    </span>
                </div>
            </div>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full h-11 pl-4 pr-10 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('name')" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full h-11 pl-4 pr-10 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <x-input-error class="mt-1" :messages="$errors->get('email')" />
                </div>

                <!-- Action Button -->
                <div class="pt-2 flex items-center gap-4">
                    <button type="submit" class="px-6 h-11 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl text-xs transition-all shadow-md active:scale-95 duration-200">
                        Simpan Profil
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-emerald-600">
                            Profil Berhasil Diperbarui!
                        </p>
                    @endif
                </div>
            </form>
        </div>
    @endif
</section>
