<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Setup Profil</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <div class="text-center">
            <span class="text-3xl">⚖️</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Lengkapi Profil Remajamu</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Kami membutuhkan data fisikmu untuk mengukur Indeks Massa Tubuh (IMT) secara akurat.
            </p>
            <div class="mt-2.5 inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-100 border border-slate-200 rounded-full text-[11px] font-semibold text-slate-600 shadow-sm">
                <span>📧 Akun Aktif:</span>
                <strong class="text-primary font-bold">{{ Auth::user()->email }}</strong>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-premium relative overflow-hidden">
            <form method="POST" action="{{ route('student.profile.setup.store') }}" class="space-y-5">
                @csrf
                
                <!-- Nickname -->
                <div>
                    <label for="nickname" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Nama Lengkap *</label>
                    <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" placeholder="Cth: Deny Septian" required 
                        class="block w-full h-12 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                    <p class="mt-1 text-[10px] text-muted-gray leading-normal">Masukkan nama lengkapmu untuk profil di aplikasi SmartSip.</p>
                    @error('nickname')
                        <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- School and Class -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="school_id" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Asal Sekolah *</label>
                        <div class="relative">
                            <select id="school_id" name="school_id" required 
                                class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                                <option value="" disabled {{ old('school_id') ? '' : 'selected' }} class="text-slate-400">Pilih...</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('school_id')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="class_id" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Kelas *</label>
                        <div class="relative">
                            <select id="class_id" name="class_id" required 
                                class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                                <option value="" disabled {{ old('class_id') ? '' : 'selected' }} class="text-slate-400">Pilih...</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('class_id')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Gender and DOB -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="gender" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Gender *</label>
                        <div class="relative">
                            <select id="gender" name="gender" required 
                                class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }} class="text-slate-400">Pilih...</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('gender')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Tgl Lahir *</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required 
                            class="block w-full h-12 px-4 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                        @error('date_of_birth')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Height, Weight, and Body Fat BIA -->
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label for="height_cm" class="block text-[11px] font-extrabold text-muted-gray uppercase tracking-wider mb-2">Tinggi *</label>
                        <div class="relative">
                            <input type="number" step="0.1" id="height_cm" name="height_cm" value="{{ old('height_cm') }}" placeholder="165" required 
                                class="block w-full h-12 pl-3 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" />
                            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-muted-gray text-[10px] font-bold">cm</div>
                        </div>
                        @error('height_cm')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="weight_kg" class="block text-[11px] font-extrabold text-muted-gray uppercase tracking-wider mb-2">Berat *</label>
                        <div class="relative">
                            <input type="number" step="0.1" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" placeholder="55" required 
                                class="block w-full h-12 pl-3 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" />
                            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400 text-[10px] font-bold">kg</div>
                        </div>
                        @error('weight_kg')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="body_fat_percentage" class="block text-[11px] font-extrabold text-muted-gray uppercase tracking-wider mb-2">Lemak (BIA)</label>
                        <div class="relative">
                            <input type="number" step="0.1" id="body_fat_percentage" name="body_fat_percentage" value="{{ old('body_fat_percentage') }}" placeholder="Opsional" 
                                class="block w-full h-12 pl-3 pr-7 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" />
                            <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none text-slate-400 text-[10px] font-bold">%</div>
                        </div>
                        @error('body_fat_percentage')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pocket Money -->
                <div>
                    <label for="pocket_money" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Uang Saku per Hari *</label>
                    <div class="relative">
                        <select id="pocket_money" name="pocket_money" required 
                            class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                            <option value="" disabled {{ old('pocket_money') ? '' : 'selected' }} class="text-slate-400">Pilih Uang Saku...</option>
                            <option value="< Rp10.000" {{ old('pocket_money') == '< Rp10.000' ? 'selected' : '' }}>&lt; Rp10.000</option>
                            <option value="Rp10.000–20.000" {{ old('pocket_money') == 'Rp10.000–20.000' ? 'selected' : '' }}>Rp10.000 – Rp20.000</option>
                            <option value="Rp21.000–30.000" {{ old('pocket_money') == 'Rp21.000–30.000' ? 'selected' : '' }}>Rp21.000 – Rp30.000</option>
                            <option value="> Rp30.000" {{ old('pocket_money') == '> Rp30.000' ? 'selected' : '' }}>&gt; Rp30.000</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('pocket_money')
                        <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parents Education -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="father_education" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Pendidikan Ayah *</label>
                        <div class="relative">
                            <select id="father_education" name="father_education" required 
                                class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                                <option value="" disabled {{ old('father_education') ? '' : 'selected' }} class="text-slate-400">Pilih...</option>
                                <option value="SD" {{ old('father_education') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP" {{ old('father_education') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA/SMK" {{ old('father_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK</option>
                                <option value="D3/S1/S2/S3" {{ old('father_education') == 'D3/S1/S2/S3' ? 'selected' : '' }}>Perguruan Tinggi (D3/S1/S2/S3)</option>
                                <option value="Lainnya" {{ old('father_education') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('father_education')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mother_education" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Pendidikan Ibu *</label>
                        <div class="relative">
                            <select id="mother_education" name="mother_education" required 
                                class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                                <option value="" disabled {{ old('mother_education') ? '' : 'selected' }} class="text-slate-400">Pilih...</option>
                                <option value="SD" {{ old('mother_education') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP" {{ old('mother_education') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA/SMK" {{ old('mother_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK</option>
                                <option value="D3/S1/S2/S3" {{ old('mother_education') == 'D3/S1/S2/S3' ? 'selected' : '' }}>Perguruan Tinggi (D3/S1/S2/S3)</option>
                                <option value="Lainnya" {{ old('mother_education') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('mother_education')
                            <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informed Consent Box -->
                <div class="p-4 bg-sky-50 border border-sky-100 rounded-2xl space-y-3">
                    <h5 class="text-xs font-bold text-dark-navy flex items-center gap-1.5">
                        <span>📝</span> Informed Consent / Assent Responden
                    </h5>
                    <p class="text-[11px] text-slate-600 leading-relaxed">
                        Dengan mengisi formulir ini, saya menyatakan bersedia secara sukarela menjadi responden dalam penelitian edukasi intervensi konsumsi gula SmartSip Web. Identitas diri dan jawaban saya dijaga kerahasiaannya.
                    </p>
                    <label class="flex items-center gap-2.5 pt-1 cursor-pointer">
                        <input type="checkbox" name="informed_consent" value="1" required 
                            class="w-4 h-4 text-primary bg-white border-slate-300 rounded focus:ring-primary/25 cursor-pointer" />
                        <span class="text-xs font-bold text-dark-navy">Saya setuju untuk berpartisipasi dalam penelitian ini *</span>
                    </label>
                    @error('informed_consent')
                        <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
