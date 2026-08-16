<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuesioner Siswa - SmartSip</title>
    <link rel="icon" href="{{ asset('images/smartsip_favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary text-dark-navy font-sans selection:bg-primary/30 selection:text-primary min-h-screen relative pb-12">

    <!-- Decorative Background Gradients -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 bg-gradient-to-tr from-secondary via-white to-indigo-50/60"></div>
    <div class="fixed -top-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="fixed -bottom-24 -left-24 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <!-- Header Navigation -->
    <header class="w-full max-w-4xl mx-auto px-4 sm:px-6 py-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-primary to-indigo-600 flex items-center justify-center shadow-lg shadow-primary/25 text-white font-black text-xl">
                S
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black text-dark-navy tracking-tight leading-none">Smart<span class="text-primary">Sip</span></span>
                <span class="text-[10px] font-bold text-muted-gray uppercase tracking-widest mt-0.5">Survei Riset Siswa</span>
            </div>
        </a>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200 rounded-full text-xs font-bold text-emerald-600 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Public Access
            </span>
        </div>
    </header>

    <!-- Main Container -->
    <main class="w-full max-w-4xl mx-auto px-4 sm:px-6">

        <!-- Title Header Card -->
        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-150 shadow-premium text-center space-y-3 mb-6 relative overflow-hidden">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-black tracking-wide uppercase">
                📋 Kuesioner Awal Konsumsi Gula
            </div>
            <h1 class="text-2xl sm:text-4xl font-black text-dark-navy tracking-tight leading-snug">
                Formulir Riset Kesehatan Siswa
            </h1>
            <p class="text-xs sm:text-sm text-muted-gray max-w-2xl mx-auto leading-relaxed font-medium">
                Isi data diri dan kuesioner secara jujur tanpa perlu login. Data kamu aman dan akan otomatis tersimpan untuk akun SmartSip kamu!
            </p>

            <!-- Error Notification Banner -->
            @if ($errors->any())
                <div class="mt-4 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-left text-xs text-rose-600 font-bold space-y-1">
                    <p class="font-extrabold text-sm">⚠️ Terdapat beberapa isian yang belum lengkap:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px] font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Multi-Step Wizard Progress Bar -->
        <div class="bg-white rounded-2xl p-4 border border-slate-150 shadow-sm mb-6">
            <div class="grid grid-cols-4 gap-2 text-center text-xs font-bold text-slate-400" id="stepIndicator">
                <div class="step-tab text-primary border-b-2 border-primary pb-2 flex flex-col items-center gap-1 cursor-pointer" onclick="goToStep(1)">
                    <span class="w-6 h-6 rounded-full bg-primary text-white text-[11px] font-black flex items-center justify-center">1</span>
                    <span class="hidden sm:inline text-[11px]">Demografi</span>
                </div>
                <div class="step-tab pb-2 flex flex-col items-center gap-1 cursor-pointer" onclick="goToStep(2)">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 text-[11px] font-black flex items-center justify-center">2</span>
                    <span class="hidden sm:inline text-[11px]">Pengetahuan</span>
                </div>
                <div class="step-tab pb-2 flex flex-col items-center gap-1 cursor-pointer" onclick="goToStep(3)">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 text-[11px] font-black flex items-center justify-center">3</span>
                    <span class="hidden sm:inline text-[11px]">Sikap & TPB</span>
                </div>
                <div class="step-tab pb-2 flex flex-col items-center gap-1 cursor-pointer" onclick="goToStep(4)">
                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 text-[11px] font-black flex items-center justify-center">4</span>
                    <span class="hidden sm:inline text-[11px]">FFQ Minuman</span>
                </div>
            </div>
        </div>

        <!-- Form Card Container -->
        <div class="bg-white rounded-[28px] p-6 sm:p-8 border border-slate-150 shadow-premium relative">
            <form method="POST" action="{{ route('public.survey.store') }}" id="surveyForm" class="space-y-6">
                @csrf

                <!-- ================= STEP 1: DEMOGRAFI & ANTROPOMETRI ================= -->
                <div class="form-step space-y-6" id="step-1">
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="text-lg font-black text-dark-navy flex items-center gap-2">
                            <span>👤</span> Langkah 1: Identitas & Data Fisik Siswa
                        </h2>
                        <p class="text-xs text-muted-gray mt-1">Data fisik digunakan untuk menghitung Indeks Massa Tubuh (IMT) dan profil riset.</p>
                    </div>

                    <!-- Email (Auto-fill) -->
                    <div>
                        <label for="email" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">
                            Email Siswa (Untuk Login Kembali) *
                        </label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()?->email) }}" required autocomplete="email"
                                placeholder="Masukkan email aktifmu (cth: siswa@gmail.com)" 
                                class="block w-full h-12 pl-4 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-sm font-semibold placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                ✉️
                            </div>
                        </div>
                        <p class="mt-1.5 text-[11px] text-slate-500 font-medium">Email ini akan menjadi ID login akun kamu nanti tanpa perlu daftar manual lagi.</p>
                        @error('email') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nickname" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Nama Lengkap Siswa *</label>
                        <input type="text" id="nickname" name="nickname" value="{{ old('nickname', Auth::user()?->name) }}" placeholder="Cth: Deny Septian" required 
                            class="block w-full h-12 px-4 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-sm font-semibold placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                        @error('nickname') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- School & Class -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="school_id" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Asal Sekolah *</label>
                            <select id="school_id" name="school_id" required 
                                class="block w-full h-12 px-4 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer">
                                <option value="" disabled {{ old('school_id') ? '' : 'selected' }}>Pilih Sekolah...</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_id') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="class_id" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Kelas *</label>
                            <select id="class_id" name="class_id" required 
                                class="block w-full h-12 px-4 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer">
                                <option value="" disabled {{ old('class_id') ? '' : 'selected' }}>Pilih Kelas...</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Gender & DOB -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="gender" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Jenis Kelamin *</label>
                            <select id="gender" name="gender" required 
                                class="block w-full h-12 px-4 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer">
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin...</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Tanggal Lahir *</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required 
                                class="block w-full h-12 px-4 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                            @error('date_of_birth') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Height, Weight, Body Fat -->
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="height_cm" class="block text-[11px] font-black text-muted-gray uppercase tracking-wider mb-2">Tinggi *</label>
                            <div class="relative">
                                <input type="number" step="0.1" id="height_cm" name="height_cm" value="{{ old('height_cm') }}" placeholder="165" required 
                                    class="block w-full h-12 pl-3 pr-7 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none text-slate-400 text-[10px] font-bold">cm</div>
                            </div>
                            @error('height_cm') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="weight_kg" class="block text-[11px] font-black text-muted-gray uppercase tracking-wider mb-2">Berat *</label>
                            <div class="relative">
                                <input type="number" step="0.1" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" placeholder="55" required 
                                    class="block w-full h-12 pl-3 pr-7 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none text-slate-400 text-[10px] font-bold">kg</div>
                            </div>
                            @error('weight_kg') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="body_fat_percentage" class="block text-[11px] font-black text-muted-gray uppercase tracking-wider mb-2">Lemak (BIA)</label>
                            <div class="relative">
                                <input type="number" step="0.1" id="body_fat_percentage" name="body_fat_percentage" value="{{ old('body_fat_percentage') }}" placeholder="Opsional" 
                                    class="block w-full h-12 pl-3 pr-6 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300" />
                                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none text-slate-400 text-[10px] font-bold">%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pocket Money & Parents Education -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="pocket_money" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Uang Saku / Hari *</label>
                            <select id="pocket_money" name="pocket_money" required 
                                class="block w-full h-12 px-3 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none cursor-pointer">
                                <option value="" disabled {{ old('pocket_money') ? '' : 'selected' }}>Pilih Uang Saku...</option>
                                <option value="< Rp10.000" {{ old('pocket_money') == '< Rp10.000' ? 'selected' : '' }}>&lt; Rp10.000</option>
                                <option value="Rp10.000–20.000" {{ old('pocket_money') == 'Rp10.000–20.000' ? 'selected' : '' }}>Rp10.000 – Rp20.000</option>
                                <option value="Rp21.000–30.000" {{ old('pocket_money') == 'Rp21.000–30.000' ? 'selected' : '' }}>Rp21.000 – Rp30.000</option>
                                <option value="> Rp30.000" {{ old('pocket_money') == '> Rp30.000' ? 'selected' : '' }}>&gt; Rp30.000</option>
                            </select>
                            @error('pocket_money') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="father_education" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Pendidikan Ayah *</label>
                            <select id="father_education" name="father_education" required 
                                class="block w-full h-12 px-3 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none cursor-pointer">
                                <option value="" disabled {{ old('father_education') ? '' : 'selected' }}>Pilih...</option>
                                <option value="SD" {{ old('father_education') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP" {{ old('father_education') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA/SMK" {{ old('father_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK</option>
                                <option value="D3/S1/S2/S3" {{ old('father_education') == 'D3/S1/S2/S3' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                <option value="Lainnya" {{ old('father_education') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('father_education') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="mother_education" class="block text-xs font-black text-muted-gray uppercase tracking-wider mb-2">Pendidikan Ibu *</label>
                            <select id="mother_education" name="mother_education" required 
                                class="block w-full h-12 px-3 bg-slate-50 border border-slate-200 rounded-xl text-dark-navy text-xs font-semibold focus:outline-none cursor-pointer">
                                <option value="" disabled {{ old('mother_education') ? '' : 'selected' }}>Pilih...</option>
                                <option value="SD" {{ old('mother_education') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP" {{ old('mother_education') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA/SMK" {{ old('mother_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK</option>
                                <option value="D3/S1/S2/S3" {{ old('mother_education') == 'D3/S1/S2/S3' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                <option value="Lainnya" {{ old('mother_education') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('mother_education') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Informed Consent Box -->
                    <div class="p-4 bg-sky-50 border border-sky-100 rounded-2xl space-y-2">
                        <h4 class="text-xs font-bold text-dark-navy flex items-center gap-1.5">
                            📝 Informed Consent / Lembar Persetujuan Responden
                        </h4>
                        <p class="text-[11px] text-slate-600 leading-relaxed font-medium">
                            Dengan mengisi formulir ini, saya menyatakan secara sukarela bersedia menjadi responden riset edukasi konsumsi gula SmartSip. Data pribadi dan jawaban saya dijaga kerahasiaannya.
                        </p>
                        <label class="flex items-center gap-2.5 pt-1 cursor-pointer">
                            <input type="checkbox" name="informed_consent" value="1" required checked
                                class="w-4 h-4 text-primary bg-white border-slate-300 rounded focus:ring-primary/25 cursor-pointer" />
                            <span class="text-xs font-bold text-dark-navy">Saya setuju berpartisipasi dalam penelitian ini *</span>
                        </label>
                        @error('informed_consent') <p class="mt-1 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="button" onclick="nextStep(2)" class="px-6 py-3 bg-primary text-white font-bold text-xs rounded-xl shadow-lg shadow-primary/25 hover:bg-primary-dark transition-all flex items-center gap-2">
                            <span>Lanjut ke Pengetahuan Gula</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 2: PENGETAHUAN GULA ================= -->
                <div class="form-step space-y-6 hidden" id="step-2">
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="text-lg font-black text-dark-navy flex items-center gap-2">
                            <span>🧠</span> Langkah 2: Kuesioner Pengetahuan Gula
                        </h2>
                        <p class="text-xs text-muted-gray mt-1">Pilihlah salah satu jawaban yang menurut kamu paling tepat (10 Pertanyaan).</p>
                    </div>

                    <div class="space-y-6">
                        @foreach($knowledgeQuestions as $index => $q)
                            <div class="p-4 sm:p-5 bg-slate-50 border border-slate-150 rounded-2xl space-y-3">
                                <div class="flex items-start gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-primary/10 text-primary font-black text-xs flex items-center justify-center shrink-0 mt-0.5">
                                        {{ $index + 1 }}
                                    </span>
                                    <h3 class="text-xs sm:text-sm font-bold text-dark-navy leading-relaxed">
                                        {{ $q->question_text }}
                                    </h3>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pl-8">
                                    @if(is_array($q->options) || is_object($q->options))
                                        @foreach($q->options as $key => $optText)
                                            @php
                                                $optKey = is_numeric($key) ? chr(65 + (int)$key) : $key;
                                            @endphp
                                            <label class="flex items-start gap-3 p-3.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-primary/50 transition-all">
                                                <input type="radio" name="knowledge_answers[{{ $q->id }}]" value="{{ $optKey }}" required 
                                                    {{ old("knowledge_answers.{$q->id}") == $optKey ? 'checked' : '' }}
                                                    class="mt-0.5 w-4 h-4 text-primary focus:ring-primary/30 shrink-0" />
                                                <span class="text-xs font-semibold text-slate-700 leading-relaxed">
                                                    <strong class="text-primary font-bold">{{ $optKey }}.</strong> {{ $optText }}
                                                </span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <button type="button" onclick="prevStep(1)" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all flex items-center gap-2">
                            <span>&larr;</span>
                            <span>Kembali</span>
                        </button>
                        <button type="button" onclick="nextStep(3)" class="px-6 py-3 bg-primary text-white font-bold text-xs rounded-xl shadow-lg shadow-primary/25 hover:bg-primary-dark transition-all flex items-center gap-2">
                            <span>Lanjut ke Sikap & TPB</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 3: KUESIONER TPB ================= -->
                <div class="form-step space-y-6 hidden" id="step-3">
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="text-lg font-black text-dark-navy flex items-center gap-2">
                            <span>🎯</span> Langkah 3: Kuesioner TPB (Sikap & Perilaku)
                        </h2>
                        <p class="text-xs text-muted-gray mt-1">Pilih skala 1 sampai 5 (1 = Sangat Tidak Setuju, 5 = Sangat Setuju).</p>
                    </div>

                    <div class="space-y-6">
                        @foreach($tpbQuestions as $index => $tq)
                            <div class="p-4 sm:p-5 bg-slate-50 border border-slate-150 rounded-2xl space-y-3">
                                <div class="flex items-start gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 font-black text-xs flex items-center justify-center shrink-0 mt-0.5">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <h3 class="text-xs sm:text-sm font-bold text-dark-navy leading-relaxed">
                                            {{ $tq->question_text }}
                                        </h3>
                                        <span class="inline-block mt-1 text-[10px] font-extrabold uppercase px-2 py-0.5 bg-slate-200 text-slate-600 rounded">
                                            Kategori: {{ ucfirst($tq->category) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-1 sm:gap-2 pt-2">
                                    @for($s = 1; $s <= 5; $s++)
                                        <label class="flex-1 flex flex-col items-center justify-center p-2 sm:p-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-primary transition-all text-center">
                                            <input type="radio" name="tpb_answers[{{ $tq->id }}]" value="{{ $s }}" required
                                                {{ old("tpb_answers.{$tq->id}") == $s ? 'checked' : '' }}
                                                class="w-4 h-4 text-primary focus:ring-primary/30 mb-1" />
                                            <span class="text-xs font-black text-dark-navy">{{ $s }}</span>
                                            <span class="text-[9px] text-muted-gray font-medium hidden sm:block">
                                                @if($s == 1) STS @elseif($s == 2) TS @elseif($s == 3) N @elseif($s == 4) S @else SS @endif
                                            </span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <button type="button" onclick="prevStep(2)" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all flex items-center gap-2">
                            <span>&larr;</span>
                            <span>Kembali</span>
                        </button>
                        <button type="button" onclick="nextStep(4)" class="px-6 py-3 bg-primary text-white font-bold text-xs rounded-xl shadow-lg shadow-primary/25 hover:bg-primary-dark transition-all flex items-center gap-2">
                            <span>Lanjut ke FFQ Minuman</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 4: SURVEI FFQ MINUMAN ================= -->
                <div class="form-step space-y-6 hidden" id="step-4">
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="text-lg font-black text-dark-navy flex items-center gap-2">
                            <span>🧃</span> Langkah 4: Survei FFQ Konsumsi Minuman Manis (7 Hari)
                        </h2>
                        <p class="text-xs text-muted-gray mt-1">Pilih seberapa sering dan berapa ukuran porsi yang biasa kamu konsumsi dalam 1 minggu terakhir.</p>
                    </div>

                    <div class="space-y-4">
                        @foreach($ffqBeverages as $idx => $b)
                            <div class="p-4 bg-slate-50 border border-slate-150 rounded-2xl grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                                <div class="md:col-span-5 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 font-extrabold text-xs flex items-center justify-center shrink-0">
                                        {{ $idx + 1 }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-extrabold text-dark-navy">{{ $b['name'] }}</h4>
                                        <span class="text-[10px] text-muted-gray font-semibold">Kandungan: {{ $b['sugar_100ml'] }}g gula / 100ml</span>
                                    </div>
                                </div>

                                <!-- Frekuensi Konsumsi -->
                                <div class="md:col-span-4">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Frekuensi 7 Hari</label>
                                    <select name="ffq_freq[{{ $idx }}]" required 
                                        class="w-full h-10 px-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-dark-navy focus:outline-none focus:border-primary">
                                        <option value="0" {{ old("ffq_freq.{$idx}") == '0' ? 'selected' : '' }}>0 (Tidak pernah)</option>
                                        <option value="1" {{ old("ffq_freq.{$idx}") == '1' ? 'selected' : '' }}>1 (1-2x per minggu)</option>
                                        <option value="2" {{ old("ffq_freq.{$idx}") == '2' ? 'selected' : '' }}>2 (3-4x per minggu)</option>
                                        <option value="3" {{ old("ffq_freq.{$idx}") == '3' ? 'selected' : '' }}>3 (5-6x per minggu)</option>
                                        <option value="4" {{ old("ffq_freq.{$idx}") == '4' ? 'selected' : '' }}>4 (Setiap hari)</option>
                                    </select>
                                </div>

                                <!-- Ukuran Porsi -->
                                <div class="md:col-span-3">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Porsi Biasa</label>
                                    <select name="ffq_portion[{{ $idx }}]" required 
                                        class="w-full h-10 px-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-dark-navy focus:outline-none focus:border-primary">
                                        <option value="250" {{ old("ffq_portion.{$idx}") == '250' ? 'selected' : '' }}>Kecil (~250 ml)</option>
                                        <option value="350" {{ old("ffq_portion.{$idx}") == '350' ? 'selected' : '' }} selected>Sedang (~350 ml)</option>
                                        <option value="450" {{ old("ffq_portion.{$idx}") == '450' ? 'selected' : '' }}>Besar (~450 ml)</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <button type="button" onclick="prevStep(3)" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all flex items-center gap-2">
                            <span>&larr;</span>
                            <span>Kembali</span>
                        </button>
                        <button type="submit" id="btnSubmit" class="px-8 py-3.5 bg-gradient-to-r from-primary via-indigo-600 to-cyan-600 text-white font-black text-sm rounded-xl shadow-xl shadow-primary/30 hover:opacity-95 transition-all active:scale-[0.98] flex items-center gap-2">
                            <span>🚀 Kirim & Simpan Kuesioner</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-4xl mx-auto px-4 sm:px-6 mt-12 text-center text-xs text-muted-gray font-medium">
        <p>&copy; {{ date('Y') }} SmartSip Web Platform. Penelitian Intervensi Konsumsi Gula Remaja.</p>
    </footer>

    <!-- JavaScript Multi-Step & Auto-Fill Email Script -->
    <script>
        let currentStep = 1;

        document.addEventListener('DOMContentLoaded', () => {
            // Auto-fill email dari localStorage jika ada
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                const savedEmail = localStorage.getItem('smartsip_student_email');
                if (savedEmail) {
                    emailInput.value = savedEmail;
                }
            }

            // Simpan email ke localStorage saat diketik atau submitted
            const form = document.getElementById('surveyForm');
            form.addEventListener('submit', () => {
                if (emailInput && emailInput.value) {
                    localStorage.setItem('smartsip_student_email', emailInput.value.trim());
                    localStorage.setItem('smartsip_survey_completed', 'true');
                }
            });
        });

        function goToStep(step) {
            if (step > currentStep && !validateStep(currentStep)) {
                return;
            }
            showStep(step);
        }

        function nextStep(step) {
            if (validateStep(currentStep)) {
                showStep(step);
            }
        }

        function prevStep(step) {
            showStep(step);
        }

        function showStep(step) {
            currentStep = step;
            document.querySelectorAll('.form-step').forEach(el => el.classList.add('hidden'));
            document.getElementById(`step-${step}`).classList.remove('hidden');

            // Update Header Tab Status
            const tabs = document.querySelectorAll('#stepIndicator .step-tab');
            tabs.forEach((tab, idx) => {
                const badge = tab.querySelector('span:first-child');
                if (idx + 1 === step) {
                    tab.classList.add('text-primary', 'border-b-2', 'border-primary');
                    badge.classList.remove('bg-slate-200', 'text-slate-600');
                    badge.classList.add('bg-primary', 'text-white');
                } else if (idx + 1 < step) {
                    tab.classList.remove('text-primary', 'border-b-2', 'border-primary');
                    tab.classList.add('text-emerald-600');
                    badge.classList.remove('bg-slate-200', 'text-slate-600', 'bg-primary');
                    badge.classList.add('bg-emerald-500', 'text-white');
                } else {
                    tab.classList.remove('text-primary', 'border-b-2', 'border-primary', 'text-emerald-600');
                    tab.classList.add('text-slate-400');
                    badge.classList.remove('bg-primary', 'bg-emerald-500', 'text-white');
                    badge.classList.add('bg-slate-200', 'text-slate-600');
                }
            });

            window.scrollTo({ top: 150, behavior: 'smooth' });
        }

        function validateStep(step) {
            const currentStepEl = document.getElementById(`step-${step}`);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    const group = currentStepEl.querySelectorAll(`input[name="${input.name}"]`);
                    const checked = Array.from(group).some(r => r.checked);
                    if (!checked) {
                        isValid = false;
                    }
                } else if (input.type === 'checkbox') {
                    if (!input.checked) isValid = false;
                } else {
                    if (!input.value.trim()) isValid = false;
                }
            });

            if (!isValid) {
                alert('Silakan lengkapi semua isian wajib pada langkah ini sebelum melanjutkan.');
            }
            return isValid;
        }
    </script>
</body>
</html>
