<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Penelitian</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Ekspor Data Mentah Riset (SPSS / Excel / CSV)
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-6">

            <!-- Intro Header Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10 max-w-2xl space-y-3">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-2xs font-extrabold uppercase tracking-wider">
                        📊 Data Export Center
                    </span>
                    <h3 class="text-2xl font-extrabold tracking-tight">Unduh Mentahan Data Penelitian Baku</h3>
                    <p class="text-xs text-indigo-100 leading-relaxed font-medium">
                        Unduh data mentah instrumen riset *Theory of Planned Behavior* (TPB) untuk pengolahan statistik SPSS, Jamovi, R, atau SmartPLS. Seluruh berkas terformat CSV UTF-8 baku.
                    </p>
                </div>
            </div>

            <!-- Export Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- 1. Bagian A: Demografi & Antropometri -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-extrabold uppercase rounded-lg">BAGIAN A</span>
                            <span class="text-xs font-bold text-slate-400">{{ $stats['students'] }} Responden</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800">Identitas & Antropometri</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            10 Poin data demografi, Nickname, Usia, Gender, Sekolah Mitra, Kelas, Tinggi (cm), Berat (kg), IMT, Lemak BIA %, Uang Saku, & Edukasi Ortu.
                        </p>
                    </div>
                    <a href="{{ route('admin.exports.demographics') }}" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh CSV Bagian A
                    </a>
                </div>

                <!-- 2. Bagian B: FFQ 7 Hari -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-600 border border-amber-200 text-[10px] font-extrabold uppercase rounded-lg">BAGIAN B</span>
                            <span class="text-xs font-bold text-slate-400">{{ $stats['ffq_count'] }} Entri</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800">FFQ 7 Hari (Minuman Manis)</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Survei frekuensi konsumsi 20 jenis minuman berpemanis (SSB) dalam sepekan, porsi (ml), dan estimasi asupan gula.
                        </p>
                    </div>
                    <a href="{{ route('admin.exports.ffq') }}" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh CSV Bagian B
                    </a>
                </div>

                <!-- 3. Bagian C: Kuesioner TPB 23 Item -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-1 bg-sky-50 text-sky-600 border border-sky-200 text-[10px] font-extrabold uppercase rounded-lg">BAGIAN C</span>
                            <span class="text-xs font-bold text-slate-400">{{ $stats['tpb_count'] }} Jawaban</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800">Kuesioner TPB (23 Item Likert)</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Skor skala Likert 23 item untuk 4 konstruk utama (Attitude, Subjective Norm, Perceived Behavioral Control, Intention).
                        </p>
                    </div>
                    <a href="{{ route('admin.exports.tpb') }}" class="w-full py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh CSV Bagian C
                    </a>
                </div>

                <!-- 4. Bagian D: Pengetahuan Gula -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 border border-indigo-200 text-[10px] font-extrabold uppercase rounded-lg">BAGIAN D</span>
                            <span class="text-xs font-bold text-slate-400">{{ $stats['knowledge_count'] }} Jawaban</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800">Pengetahuan Gula (10 Soal PG)</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Hasil ujian 10 soal pilihan ganda pengetahuan gizi, batas WHO, dan dampak kesehatan konsumsi gula berlebih.
                        </p>
                    </div>
                    <a href="{{ route('admin.exports.knowledge') }}" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh CSV Bagian D
                    </a>
                </div>

                <!-- 5. Bagian E: Usability Web (SUS) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-1 bg-rose-50 text-rose-600 border border-rose-200 text-[10px] font-extrabold uppercase rounded-lg">BAGIAN E</span>
                            <span class="text-xs font-bold text-slate-400">{{ $stats['usability_count'] }} Skor</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800">Evaluasi Usability SUS</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Penilaian 10 item System Usability Scale (SUS) kemudahan dan kepuasan siswa menggunakan web SmartSip.
                        </p>
                    </div>
                    <a href="{{ route('admin.exports.usability') }}" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh CSV Bagian E
                    </a>
                </div>

                <!-- 6. Log Konsumsi Gula Harian -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-600 border border-purple-200 text-[10px] font-extrabold uppercase rounded-lg">LOG HARIAN</span>
                            <span class="text-xs font-bold text-slate-400">{{ $stats['sugar_logs'] }} Record</span>
                        </div>
                        <h4 class="text-base font-extrabold text-slate-800">Log Konsumsi Gula Harian</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Log lengkap aktivitas pencatatan minum harian siswa, jenis produk, volume (ml), gram gula, dan timestamp.
                        </p>
                    </div>
                    <a href="{{ route('admin.exports.sugar_logs') }}" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh CSV Log Gula
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
