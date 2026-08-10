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

            <!-- Analytics Summary Metrics Cards Grid (PRIORITY INFO TOP) -->
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
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block">Melebihi Batas WHO (>25g)</span>
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

            <!-- Interactive Charts Section Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Chart 1: Line Chart 7 Days Trend (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-extrabold text-slate-800 mb-6">Tren Konsumsi Gula Rata-rata Siswa (7 Hari Terakhir)</h3>
                    <div class="w-full h-[300px] relative">
                        <canvas id="avgSugarChartAdmin"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Doughnut Chart WHO Limit Compliance (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 mb-2">Proporsi Kepatuhan Gula</h3>
                        <p class="text-xs text-slate-400 mb-4">Persentase siswa aman (<=25g) vs berisiko (>25g WHO).</p>
                    </div>
                    <div class="w-full h-[220px] relative flex items-center justify-center">
                        <canvas id="whoDistributionChartAdmin"></canvas>
                    </div>
                    <div class="flex justify-around items-center border-t border-slate-100 pt-3 mt-3 text-2xs font-bold">
                        <span class="flex items-center gap-1.5 text-emerald-600"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Aman (<=25g)</span>
                        <span class="flex items-center gap-1.5 text-rose-500"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span> Melebihi (>25g)</span>
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

            <!-- Master System Data Overview (PLACED AT THE VERY BOTTOM AS NON-URGENT INFO) -->
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
                        labels: ['Aman (<=25g)', 'Melebihi (>25g)'],
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
                            legend: { display: false }
                        }
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
