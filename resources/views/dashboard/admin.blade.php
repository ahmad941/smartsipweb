<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Panel Kontrol</span>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                    Dashboard Analisis Peneliti
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.exports.index') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-1.5">
                    📊 Ekspor Data Riset (SPSS/Excel)
                </a>
                <span class="px-3 py-1.5 bg-purple-500/10 text-purple-600 border border-purple-500/20 rounded-xl text-2xs font-extrabold tracking-wider uppercase">
                    Admin Peneliti
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Banner -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Selamat Datang di Panel Kontrol Peneliti! 🔬</h3>
                    <p class="text-slate-400 text-xs mt-1">Gunakan panel ini untuk memantau tren konsumsi gula, keaktifan siswa, dan data lapangan secara terpusat.</p>
                </div>
                <div class="shrink-0 flex items-center gap-2">
                    <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 rounded-xl text-2xs font-extrabold tracking-wider uppercase">
                        Sistem Valid
                    </span>
                    <span class="px-3 py-1.5 bg-purple-500/10 text-purple-600 border border-purple-500/20 rounded-xl text-2xs font-extrabold tracking-wider uppercase">
                        Riset Aktif
                    </span>
                </div>
            </div>

            <!-- Interactive Charts Section Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Chart 1: Line Chart 7 Days Trend (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <h3 class="text-sm font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span>📈</span> Tren Konsumsi Gula Rata-rata Siswa (7 Hari Terakhir)
                        </h3>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold">Rerata Gram (g)</span>
                    </div>
                    <div class="w-full h-[300px] relative">
                        <canvas id="avgSugarChartAdmin"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Doughnut Chart WHO Limit Compliance (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between hover:border-slate-300 transition-all">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="text-sm font-black text-slate-800 tracking-tight flex items-center gap-2">
                                <span>🍩</span> Proporsi Kepatuhan Gula
                            </h3>
                            <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 rounded-lg text-[9px] font-extrabold uppercase tracking-wider">
                                7 Hari Terakhir
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Perbandingan tingkat asupan <span class="font-bold text-emerald-600">Aman (≤25g/hari)</span> vs <span class="font-bold text-rose-500">Berisiko (>25g WHO)</span>.
                        </p>
                    </div>

                    <!-- Doughnut Chart Canvas with Center Badge -->
                    <div class="w-full h-[190px] relative flex items-center justify-center my-2">
                        <canvas id="whoDistributionChartAdmin"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-3xl font-black text-slate-800 tracking-tighter leading-none">{{ number_format(100 - $percentOverLimit, 1) }}%</span>
                            <span class="mt-1 px-2.5 py-0.5 text-[9px] font-extrabold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full uppercase tracking-wider">
                                Siswa Aman
                            </span>
                        </div>
                    </div>

                    <!-- Informative Legend Stat Grid -->
                    <div class="grid grid-cols-2 gap-2.5 border-t border-slate-100 pt-3 mt-1">
                        <div class="bg-emerald-50/60 border border-emerald-100/80 rounded-xl p-2.5 flex flex-col justify-between">
                            <div class="flex items-center gap-1.5 text-emerald-700 text-[10px] font-bold">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Aman (≤25g/hari)
                            </div>
                            <div class="mt-1.5 flex items-baseline justify-between">
                                <span class="text-lg font-black text-emerald-600 tracking-tight">{{ number_format(100 - $percentOverLimit, 1) }}%</span>
                                <span class="text-[9px] font-bold text-slate-400">Rerata WHO</span>
                            </div>
                        </div>

                        <div class="bg-rose-50/60 border border-rose-100/80 rounded-xl p-2.5 flex flex-col justify-between">
                            <div class="flex items-center gap-1.5 text-rose-700 text-[10px] font-bold">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                Melebihi (>25g/hari)
                            </div>
                            <div class="mt-1.5 flex items-baseline justify-between">
                                <span class="text-lg font-black text-rose-600 tracking-tight">{{ number_format($percentOverLimit, 1) }}%</span>
                                <span class="text-[9px] font-bold text-slate-400">Risiko Tinggi</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-[9px] font-semibold text-slate-400 italic text-center mt-2.5">
                        *Data dihitung dari rerata konsumsi harian 7 hari terakhir (FFQ & Log).
                    </p>
                </div>
            </div>

            <!-- TPB Psychological Radar Profile Section Grid -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-purple-500/10 text-purple-600 border border-purple-500/20 rounded-xl text-2xs font-extrabold tracking-wider uppercase">
                                Kerangka Teori TPB (Ajzen, 1991)
                            </span>
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-xl text-2xs font-bold">
                                Skala Likert 1 - 5
                            </span>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-800 mt-2 flex items-center gap-2">
                            🧠 Profil Psikologis Riset Siswa (4 Konstruk TPB)
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Rata-rata skor konstruk Sikap (Attitude), Norma Subjektif, Kontrol Diri (PBC), dan Niat (Intention) siswa.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <!-- Radar Chart (Col 5) -->
                    <div class="lg:col-span-5 w-full h-[320px] relative flex items-center justify-center bg-slate-50/50 rounded-2xl p-4 border border-slate-100">
                        <canvas id="tpbRadarChartAdmin"></canvas>
                    </div>

                    <!-- Construct Breakdown Cards Grid (Col 7) -->
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- 1. Attitude -->
                        <div class="bg-sky-50/50 border border-sky-150/80 rounded-2xl p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] font-extrabold text-sky-600 uppercase tracking-wider block">Attitude (Sikap)</span>
                                <span class="text-xs font-black text-sky-700 bg-sky-100 px-2 py-0.5 rounded-lg">{{ number_format($tpbScores['attitude'] ?? 0, 2) }} / 5.0</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-800">Pandangan & Kepercayaan Siswa</h4>
                            <p class="text-[11px] text-slate-500 leading-snug">Sejauh mana siswa menilai positif kebiasaan membatasi konsumsi minuman manis.</p>
                            <div class="w-full bg-sky-200/50 rounded-full h-2 overflow-hidden mt-1">
                                <div class="bg-sky-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, (($tpbScores['attitude'] ?? 0) / 5) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- 2. Subjective Norm -->
                        <div class="bg-emerald-50/50 border border-emerald-150/80 rounded-2xl p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider block">Subjective Norm (Sosial)</span>
                                <span class="text-xs font-black text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-lg">{{ number_format($tpbScores['subjective_norm'] ?? 0, 2) }} / 5.0</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-800">Dukungan Lingkungan & Teman</h4>
                            <p class="text-[11px] text-slate-500 leading-snug">Pengaruh sosial dari teman sebaya, keluarga, dan guru dalam memilih air putih.</p>
                            <div class="w-full bg-emerald-200/50 rounded-full h-2 overflow-hidden mt-1">
                                <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, (($tpbScores['subjective_norm'] ?? 0) / 5) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- 3. PBC -->
                        <div class="bg-amber-50/50 border border-amber-150/80 rounded-2xl p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] font-extrabold text-amber-600 uppercase tracking-wider block">Perceived Control (PBC)</span>
                                <span class="text-xs font-black text-amber-700 bg-amber-100 px-2 py-0.5 rounded-lg">{{ number_format($tpbScores['pbc'] ?? 0, 2) }} / 5.0</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-800">Efikasi & Kontrol Diri</h4>
                            <p class="text-[11px] text-slate-500 leading-snug">Keyakinan siswa terhadap kemampuan dirinya untuk menolak minuman manis.</p>
                            <div class="w-full bg-amber-200/50 rounded-full h-2 overflow-hidden mt-1">
                                <div class="bg-amber-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, (($tpbScores['pbc'] ?? 0) / 5) * 100) }}%"></div>
                            </div>
                        </div>

                        <!-- 4. Intention -->
                        <div class="bg-purple-50/50 border border-purple-150/80 rounded-2xl p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] font-extrabold text-purple-600 uppercase tracking-wider block">Intention (Niat)</span>
                                <span class="text-xs font-black text-purple-700 bg-purple-100 px-2 py-0.5 rounded-lg">{{ number_format($tpbScores['intention'] ?? 0, 2) }} / 5.0</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-800">Komitmen Perubahan Perilaku</h4>
                            <p class="text-[11px] text-slate-500 leading-snug">Niat dan kesiapan tindakan nyata siswa untuk mengurangi gula dalam kehidupan sehari-hari.</p>
                            <div class="w-full bg-purple-200/50 rounded-full h-2 overflow-hidden mt-1">
                                <div class="bg-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, (($tpbScores['intention'] ?? 0) / 5) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class aggregate & Students tables -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Class Aggregate Table (Col 1) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Statistik Per Kelas</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-extrabold text-[10px]">
                                    <th class="pb-3">Kelas</th>
                                    <th class="pb-3 text-center w-16">Siswa</th>
                                    <th class="pb-3 text-right w-24">Rerata Gula</th>
                                    <th class="pb-3 text-right w-20">Poin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                @forelse($classes as $class)
                                    <tr class="hover:bg-slate-50/50 transition-all">
                                        <td class="py-3.5 font-bold text-slate-800">
                                            {{ $class['name'] }}
                                            <span class="block text-[9px] text-slate-400 font-semibold">{{ $class['school'] }}</span>
                                        </td>
                                        <td class="py-3.5 text-center font-semibold">{{ $class['student_count'] }}</td>
                                        <td class="py-3.5 text-right text-emerald-600 font-extrabold">{{ number_format($class['avg_sugar_today'], 1) }}g</td>
                                        <td class="py-3.5 text-right text-amber-500 font-extrabold">{{ number_format($class['avg_points'], 0) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-slate-400 font-bold italic">Belum ada data kelas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Students Detailed Table (Col 2) -->
                <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Daftar Keaktifan & Kesehatan Siswa</h3>
                    <div class="overflow-x-auto flex-1 max-h-[380px] overflow-y-auto pr-1">
                        <table class="w-full text-left text-xs">
                            <thead class="sticky top-0 z-10">
                                <tr class="border-b border-slate-150 text-slate-400 uppercase tracking-wider font-extrabold text-[10px] bg-white">
                                    <th class="pb-3 pl-2">Nama Siswa</th>
                                    <th class="pb-3">Sekolah & Kelas</th>
                                    <th class="pb-3 text-center w-16">IMT</th>
                                    <th class="pb-3 text-right w-28">Gula Hari Ini</th>
                                    <th class="pb-3 text-right w-20">Poin</th>
                                    <th class="pb-3 text-center w-24 pr-2">Kuesioner</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                @forelse($studentsList as $std)
                                    <tr class="hover:bg-slate-50/50 transition-all">
                                        <td class="py-3.5 pl-2 font-bold text-slate-800">
                                            {{ $std['nickname'] }}
                                            <span class="block text-[9px] text-slate-400 font-semibold">
                                                {{ $std['gender'] === 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5">
                                            <span class="font-bold text-slate-700">{{ $std['school_name'] }}</span>
                                            <span class="block text-[10px] text-slate-450 font-bold">{{ $std['class_name'] }}</span>
                                        </td>
                                        <td class="py-3.5 text-center font-bold text-slate-700">{{ $std['bmi'] }}</td>
                                        <td class="py-3.5 text-right font-extrabold">
                                            <span class="@if($std['today_sugar'] > 25) text-rose-500 @else text-emerald-600 @endif">
                                                {{ number_format($std['today_sugar'], 1) }}g
                                            </span>
                                        </td>
                                        <td class="py-3.5 text-right text-amber-500 font-extrabold">{{ number_format($std['total_points']) }}</td>
                                        <td class="py-3.5 text-center pr-2">
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold border
                                                @if($std['survey_status'] === 'Sudah Isi') bg-emerald-50 border-emerald-200 text-emerald-600
                                                @else bg-slate-50 border-slate-200 text-slate-400 @endif">
                                                {{ $std['survey_status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12 text-slate-400 font-bold italic">Belum ada siswa terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Analytics Summary Metrics Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Card 1: Siswa Terpantau -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden flex flex-col justify-between h-28 border-t-4 border-t-blue-500">
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Siswa Terpantau</span>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-1.5">{{ $totalStudents }}</h4>
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 block border-t border-slate-100 pt-1.5">Remaja responden aktif</span>
                </div>

                <!-- Card 2: Average Sugar Today -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden flex flex-col justify-between h-28 border-t-4 border-t-emerald-500">
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Rerata Gula Hari Ini</span>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-1.5">{{ number_format($avgSugarToday, 1) }}g</h4>
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 block border-t border-slate-100 pt-1.5">Gram per siswa</span>
                </div>

                <!-- Card 3: Over WHO Limit % -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden flex flex-col justify-between h-28 border-t-4 border-t-rose-500">
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Melebihi Batas WHO (>25g/hari)</span>
                        <h4 class="text-2xl font-extrabold text-rose-500 mt-1.5">{{ number_format($percentOverLimit, 1) }}%</h4>
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 block border-t border-slate-100 pt-1.5">Dari total responden</span>
                </div>

                <!-- Card 4: Avg Points -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden flex flex-col justify-between h-28 border-t-4 border-t-amber-500">
                    <div>
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Rerata Poin Gamifikasi</span>
                        <h4 class="text-2xl font-extrabold text-amber-500 mt-1.5">{{ number_format($avgPoints, 0) }}</h4>
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 block border-t border-slate-100 pt-1.5">Poin terkumpul</span>
                </div>
            </div>


            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                        <h4 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Ringkasan Master Data Sistem</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Informasi statistik jumlah entri master data pada aplikasi SmartSip.</p>
                    </div>
                    <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold">Informasi Master Data</span>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4">
                    <!-- Total Akun -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-emerald-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Akun</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['users'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">Pengguna</span>
                    </div>
                    <!-- Siswa -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-blue-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Responden Siswa</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['students'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">Siswa Gen Z</span>
                    </div>
                    <!-- Sekolah -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-orange-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Sekolah Mitra</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['schools'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">SMA/SMK</span>
                    </div>
                    <!-- Kelas -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-purple-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Kelas Belajar</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['classes'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">Pembagian kelas</span>
                    </div>
                    <!-- Minuman -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-rose-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Minuman Manis</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['beverages'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">Produk master</span>
                    </div>
                    <!-- Misi -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-amber-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Misi Gamifikasi</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['challenges'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">Tantangan</span>
                    </div>
                    <!-- Soal TPB -->
                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 flex flex-col justify-between h-24 border-t-2 border-t-sky-500">
                        <div>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Soal Kuesioner</span>
                            <h4 class="text-xl font-extrabold text-slate-800 mt-1">{{ $stats['questions'] }}</h4>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 block">Konstruk TPB</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart script -->
    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('avgSugarChartAdmin').getContext('2d');
                const labels = @json($chartLabels);
                const dataPoints = @json($chartData);
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(92, 98, 249, 0.35)'); // Purple/Indigo
                gradient.addColorStop(1, 'rgba(92, 98, 249, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Rerata Asupan (g)',
                            data: dataPoints,
                            borderColor: '#5c62f9',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#5c62f9',
                            pointBorderWidth: 2.5,
                            pointRadius: 4.5,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(226, 232, 240, 0.5)', drawBorder: false },
                                ticks: { color: '#64748b', font: { weight: 'bold', size: 10 }, padding: 8 }
                            },
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#64748b', font: { weight: 'bold', size: 10 }, padding: 8 }
                            }
                        }
                    }
                });

                // 2. Doughnut Chart WHO Distribution
                const ctxDoughnut = document.getElementById('whoDistributionChartAdmin').getContext('2d');
                const distributionData = @json($distributionData);

                new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aman (<=25g/hari)', 'Melebihi (>25g/hari)'],
                        datasets: [{
                            data: distributionData,
                            backgroundColor: ['#10b981', '#f43f5e'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                                        return `${label}: ${value} siswa (${percentage})`;
                                    }
                                }
                            }
                        }
                    },
                    plugins: [{
                        id: 'doughnutSlicePercentages',
                        afterDraw(chart) {
                            const { ctx, data } = chart;
                            const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            if (total === 0) return;

                            chart.getDatasetMeta(0).data.forEach((element, index) => {
                                const value = data.datasets[0].data[index];
                                if (value === 0) return;
                                const pctVal = ((value / total) * 100).toFixed(1) + '%';
                                
                                const pos = element.tooltipPosition();
                                ctx.save();
                                ctx.fillStyle = '#ffffff';
                                ctx.font = 'bold 11px sans-serif';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.shadowColor = 'rgba(0,0,0,0.3)';
                                ctx.shadowBlur = 3;
                                ctx.fillText(pctVal, pos.x, pos.y);
                                ctx.restore();
                            });
                        }
                    }]
                });

                // 3. Radar Chart TPB 4 Constructs
                const ctxRadar = document.getElementById('tpbRadarChartAdmin').getContext('2d');
                const tpbRadarDataPoints = @json($tpbRadarData);

                new Chart(ctxRadar, {
                    type: 'radar',
                    data: {
                        labels: ['Attitude (Sikap)', 'Subjective Norm (Sosial)', 'PBC (Kontrol Diri)', 'Intention (Niat)'],
                        datasets: [{
                            label: 'Rerata Skor TPB',
                            data: tpbRadarDataPoints,
                            backgroundColor: 'rgba(147, 51, 234, 0.22)',
                            borderColor: '#9333ea',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#9333ea',
                            pointBorderWidth: 2.5,
                            pointRadius: 4.5,
                            pointHoverRadius: 6.5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                min: 0,
                                max: 5,
                                ticks: {
                                    stepSize: 1,
                                    color: '#94a3b8',
                                    font: { size: 9, weight: 'bold' },
                                    backdropColor: 'transparent'
                                },
                                grid: { color: 'rgba(226, 232, 240, 0.8)' },
                                angleLines: { color: 'rgba(226, 232, 240, 0.8)' },
                                pointLabels: {
                                    color: '#334155',
                                    font: { size: 10, weight: 'bold' }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw.toFixed(2)} / 5.0`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
