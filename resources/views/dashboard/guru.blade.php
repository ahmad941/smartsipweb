<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    SmartSip &rsaquo; Pemantau @if(Auth::user()->school) ({{ Auth::user()->school->name }}) @endif
                </span>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                    Dashboard Pemantau UKS / Guru
                </h2>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::user()->school)
                    <span class="px-3 py-1.5 bg-blue-500/10 text-blue-600 border border-blue-500/20 rounded-xl text-2xs font-extrabold tracking-wider uppercase flex items-center gap-1">
                        🏫 {{ Auth::user()->school->name }}
                    </span>
                @endif
                <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 rounded-xl text-2xs font-extrabold tracking-wider uppercase">
                    Guru / UKS
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8">

            <!-- Metrics Cards Grid (XELORO Light Mode Accented Border style) -->
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

            <!-- Charts Section -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-base font-extrabold text-slate-800 mb-6">Tren Konsumsi Gula Rata-rata Siswa (7 Hari Terakhir)</h3>
                <div class="w-full h-[300px] relative">
                    <canvas id="avgSugarChart"></canvas>
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

        </div>
    </div>

    <!-- Chart script -->
    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('avgSugarChart').getContext('2d');
                const labels = @json($chartLabels);
                const dataPoints = @json($chartData);
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(92, 98, 249, 0.35)'); // Purple
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
            });
        </script>
    </x-slot>
</x-app-layout>
