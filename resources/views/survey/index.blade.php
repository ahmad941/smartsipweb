<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Pusat Kuesioner</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <div class="text-center">
            <span class="text-3xl">📋</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Instrumen Riset SmartSip</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Lengkapi seluruh kuesioner pada <span class="font-bold text-primary">Fase {{ $phase }}</span> untuk membantu penelitian dan mendapatkan poin gamifikasi.
            </p>
            <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-slate-100 border border-slate-200 rounded-full text-xs font-bold text-dark-navy">
                <span>🏫 {{ $student->school->name ?? '-' }}</span>
                <span class="text-slate-300">•</span>
                <span class="text-primary font-extrabold">{{ $student->schoolClass->name ?? '-' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-xs font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 bg-sky-50 border border-sky-100 text-sky-700 rounded-2xl text-xs font-bold shadow-sm">
                {{ session('info') }}
            </div>
        @endif

        <!-- Survey Cards Grid -->
        <div class="space-y-4">
            
            <!-- 0. BAGIAN A. IDENTITAS RESPONDEN -->
            <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-[9px] font-extrabold uppercase rounded">BAGIAN A</span>
                        <span class="text-xs font-bold text-dark-navy">Identitas & Antropometri Responden</span>
                    </div>
                    <p class="text-[11px] text-muted-gray leading-normal">10 Poin data demografi, uang saku, pendidikan orang tua, tinggi & berat badan, serta BIA.</p>
                </div>
                <div>
                    @if($student)
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-extrabold flex items-center gap-1">
                            ✓ Terisi
                        </span>
                    @else
                        <a href="{{ route('student.profile.setup') }}" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 inline-block">
                            Lengkapi Bagian A
                        </a>
                    @endif
                </div>
            </div>

            <!-- 1. FFQ (Food Frequency Questionnaire) -->
            <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-200 text-[9px] font-extrabold uppercase rounded">BAGIAN B</span>
                        <span class="text-xs font-bold text-dark-navy">FFQ 7 Hari</span>
                    </div>
                    <p class="text-[11px] text-muted-gray leading-normal">Survei frekuensi konsumsi 20 jenis minuman berpemanis dalam 7 hari terakhir.</p>
                </div>
                <div>
                    @if($ffqDone)
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-extrabold flex items-center gap-1">
                            ✓ Selesai
                        </span>
                    @else
                        <a href="{{ route('survey.ffq') }}" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 inline-block">
                            Isi FFQ
                        </a>
                    @endif
                </div>
            </div>

            <!-- 2. Kuesioner TPB (Theory of Planned Behavior) -->
            <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-sky-50 text-sky-600 border border-sky-200 text-[9px] font-extrabold uppercase rounded">BAGIAN C</span>
                        <span class="text-xs font-bold text-dark-navy">Kuesioner TPB (23 Item)</span>
                    </div>
                    <p class="text-[11px] text-muted-gray leading-normal">Pernyataan sikap, norma sosial, kontrol diri, dan niat membatasi gula.</p>
                </div>
                <div>
                    @if($tpbDone)
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-extrabold flex items-center gap-1">
                            ✓ Selesai
                        </span>
                    @else
                        <a href="{{ route('questionnaire.index') }}" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 inline-block">
                            Isi TPB
                        </a>
                    @endif
                </div>
            </div>

            <!-- 3. Kuesioner Pengetahuan (10 Soal PG) -->
            <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 border border-indigo-200 text-[9px] font-extrabold uppercase rounded">BAGIAN D</span>
                        <span class="text-xs font-bold text-dark-navy">Pengetahuan Konsumsi Gula</span>
                    </div>
                    <p class="text-[11px] text-muted-gray leading-normal">10 Soal Pilihan Ganda tentang fakta gula dan dampak kesehatan.</p>
                </div>
                <div>
                    @if($knowledgeDone)
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-extrabold flex items-center gap-1">
                            ✓ Selesai
                        </span>
                    @else
                        <a href="{{ route('survey.knowledge') }}" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 inline-block">
                            Isi Soal
                        </a>
                    @endif
                </div>
            </div>

            <!-- 4. Evaluasi Usability Aplikasi (SUS 10 Item) -->
            <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-rose-50 text-rose-600 border border-rose-200 text-[9px] font-extrabold uppercase rounded">BAGIAN E</span>
                        <span class="text-xs font-bold text-dark-navy">Evaluasi Usability Web</span>
                    </div>
                    <p class="text-[11px] text-muted-gray leading-normal">10 Item penilaian kemudahan dan kenyamanan penggunaan aplikasi SmartSip.</p>
                </div>
                <div>
                    @if($usabilityDone)
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-xl text-xs font-extrabold flex items-center gap-1">
                            ✓ Selesai
                        </span>
                    @else
                        <a href="{{ route('survey.usability') }}" class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-xl text-xs font-bold transition-all shadow-md active:scale-95 inline-block">
                            Isi Evaluasi
                        </a>
                    @endif
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
