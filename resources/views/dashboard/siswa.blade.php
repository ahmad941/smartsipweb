<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        
        <!-- Profile dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border-2 border-slate-200 flex items-center justify-center focus:outline-none transition-all hover:border-primary/50">
                <span class="text-sm font-bold text-primary">{{ substr($student->nickname ?? 'Z', 0, 1) }}</span>
            </button>
            <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-premium py-2 z-50">
                <span class="block px-4 py-2 text-xs text-muted-gray">Halo, {{ $student->nickname ?? 'Remaja' }}</span>
                <hr class="border-slate-100 my-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-dark-navy hover:bg-slate-50">Profil Akun</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-xs font-semibold text-rose-500 hover:bg-slate-50">Keluar / Logout</button>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Main Mobile Content -->
    <div class="p-6 space-y-6">
        
        <!-- Alert Block -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-start gap-3 shadow-premium animate-fade-in text-emerald-600">
                <div class="p-1 bg-emerald-500/20 rounded-full text-emerald-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="text-xs font-bold leading-normal">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Card: Sugar Balance Overview -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-premium relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -right-6 -top-6 w-20 h-20 bg-primary/5 rounded-full pointer-events-none"></div>
            
            <!-- School & Class Badge -->
            <div class="flex justify-between items-center mb-4 text-xs font-bold border-b border-slate-100 pb-3">
                <div class="flex items-center gap-1.5 text-dark-navy">
                    <span>🏫</span>
                    <span>Asal Sekolah: <strong class="text-primary font-extrabold">{{ $student->school->name ?? '-' }}</strong></span>
                </div>
                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-extrabold border border-slate-200">
                    Kelas {{ $student->schoolClass->name ?? '-' }}
                </span>
            </div>

            <div class="text-center">
                <span class="text-xs font-bold text-muted-gray uppercase tracking-widest block">Konsumsi Gula Hari Ini</span>
                <span class="text-4xl font-extrabold text-dark-navy mt-2 block">{{ number_format($todaySugar, 1) }} <span class="text-lg font-bold text-muted-gray">gram</span></span>
                
                <!-- Limit warning status badge -->
                <div class="inline-flex mt-3">
                    @if($todaySugar <= 15)
                        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-500 rounded-full text-xs font-extrabold tracking-wide flex items-center gap-1 border border-emerald-100">
                            Aman Harian
                        </span>
                    @elseif($todaySugar <= 25)
                        <span class="px-3.5 py-1 bg-amber-50 text-amber-500 rounded-full text-xs font-extrabold tracking-wide flex items-center gap-1 border border-amber-100">
                            Waspada Limit
                        </span>
                    @else
                        <span class="px-3.5 py-1 bg-rose-50 text-rose-500 rounded-full text-xs font-extrabold tracking-wide flex items-center gap-1 border border-rose-100">
                            Melebihi WHO (25g)
                        </span>
                    @endif
                </div>
            </div>

            <!-- Rings details: 3 Side-by-side circular indicators -->
            <div class="grid grid-cols-3 gap-2 mt-8 pt-6 border-t border-slate-50 text-center">
                <!-- Indicator 1: Sugar vs WHO limit -->
                <div class="flex flex-col items-center">
                    <div class="relative w-14 h-14 flex items-center justify-center">
                        <svg class="absolute w-full h-full transform -rotate-90">
                            <circle cx="28" cy="28" r="22" stroke="#f1f5f9" stroke-width="4.5" fill="transparent" />
                            <circle cx="28" cy="28" r="22" 
                                stroke="@if($todaySugar <= 15) #10b981 @elseif($todaySugar <= 25) #f59e0b @else #ef4444 @endif" 
                                stroke-width="4.5" fill="transparent" 
                                stroke-dasharray="138"
                                stroke-dashoffset="{{ 138 - min(($todaySugar / 25) * 138, 138) }}"
                                stroke-linecap="round" />
                        </svg>
                        <span class="text-[10px] font-extrabold text-dark-navy">{{ number_format(min(($todaySugar / 25) * 100, 100), 0) }}%</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-muted-gray mt-2 uppercase tracking-wide">WHO Limit</span>
                    <span class="text-xs font-bold text-dark-navy mt-0.5">{{ number_format($todaySugar, 1) }}g</span>
                </div>

                <!-- Indicator 2: Gamification Points -->
                <div class="flex flex-col items-center">
                    <div class="relative w-14 h-14 flex items-center justify-center">
                        <svg class="absolute w-full h-full transform -rotate-90">
                            <circle cx="28" cy="28" r="22" stroke="#f1f5f9" stroke-width="4.5" fill="transparent" />
                            <circle cx="28" cy="28" r="22" stroke="#5c62f9" stroke-width="4.5" fill="transparent" 
                                stroke-dasharray="138"
                                stroke-dashoffset="{{ 138 - min(($totalPoints / 150) * 138, 138) }}"
                                stroke-linecap="round" />
                        </svg>
                        <span class="text-[10px] font-extrabold text-primary">⭐</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-muted-gray mt-2 uppercase tracking-wide">Poin</span>
                    <span class="text-xs font-bold text-dark-navy mt-0.5">{{ number_format($totalPoints) }} Pts</span>
                </div>

                <!-- Indicator 3: BMI score -->
                <div class="flex flex-col items-center">
                    <div class="relative w-14 h-14 flex items-center justify-center">
                        <svg class="absolute w-full h-full transform -rotate-90">
                            <circle cx="28" cy="28" r="22" stroke="#f1f5f9" stroke-width="4.5" fill="transparent" />
                            <circle cx="28" cy="28" r="22" stroke="#06b6d4" stroke-width="4.5" fill="transparent" 
                                stroke-dasharray="138"
                                stroke-dashoffset="{{ 138 - (isset($student->bmi_score) ? min(($student->bmi_score / 35) * 138, 138) : 0) }}"
                                stroke-linecap="round" />
                        </svg>
                        <span class="text-[10px] font-extrabold text-cyan-500">⚖️</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-muted-gray mt-2 uppercase tracking-wide">IMT (BMI)</span>
                    <span class="text-xs font-bold text-dark-navy mt-0.5">
                        {{ $student->bmi_score ?? '-' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- TPB Smart Warning Banner -->
        <div class="p-5 bg-white rounded-[24px] border border-slate-100 shadow-premium">
            <div class="flex items-start gap-3">
                <span class="text-2xl shrink-0">
                    @if($warningLevel === 'aman') 🧠 @elseif($warningLevel === 'waspada') ⚠️ @else 🚨 @endif
                </span>
                <div>
                    <h5 class="text-xs font-extrabold uppercase tracking-wider text-muted-gray">Smart Warning TPB</h5>
                    <p class="text-xs text-dark-navy font-semibold mt-1 leading-relaxed">
                        {{ $tpbMessage }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Chart Card (This Week) -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-premium">
            <h4 class="text-xs font-extrabold text-muted-gray uppercase tracking-widest mb-4">Minggu Ini</h4>
            <div class="w-full h-[180px] relative">
                <canvas id="sugarChart"></canvas>
            </div>
        </div>

        <!-- Riwayat Minum (Spending Breakdown style) -->
        <div class="space-y-4">
            <div class="flex justify-between items-center px-1">
                <h4 class="text-xs font-extrabold text-muted-gray uppercase tracking-widest">Catatan Minum Harian</h4>
                <span class="text-[10px] font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Hari Ini</span>
            </div>

            <div class="space-y-3">
                @forelse($todayConsumptions as $consumption)
                    <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-premium flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <!-- Icon inside box -->
                            <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center overflow-hidden shadow-inner shrink-0">
                                @if($consumption->beverage->image_url)
                                    <img src="{{ $consumption->beverage->image_url }}" alt="{{ $consumption->beverage->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl">
                                        @if(str_contains(strtolower($consumption->beverage->name), 'boba')) 🧋
                                        @elseif(str_contains(strtolower($consumption->beverage->name), 'soda') || str_contains(strtolower($consumption->beverage->name), 'cola')) 🥤
                                        @elseif(str_contains(strtolower($consumption->beverage->name), 'kopi')) ☕
                                        @else 🥤 @endif
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h5 class="font-bold text-dark-navy text-sm">{{ $consumption->beverage->name }}</h5>
                                <span class="text-[10px] font-semibold text-muted-gray mt-0.5 block">
                                    {{ \Carbon\Carbon::parse($consumption->consumed_at)->format('H:i') }} | {{ $consumption->volume_ml }}ml
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <!-- Negative value format as in the image -->
                            <span class="font-extrabold text-sm text-rose-500">
                                -{{ number_format($consumption->total_sugar_grams, 1) }}g
                            </span>
                            
                            <!-- Delete form -->
                            <form method="POST" action="{{ route('sugar-consumptions.destroy', $consumption->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus catatan konsumsi ini?')" class="p-1.5 text-muted-gray hover:text-rose-500 transition-colors focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-premium text-center">
                        <span class="text-3xl block">🌿</span>
                        <h5 class="text-xs font-bold text-dark-navy mt-3">Belum ada minuman dicatat hari ini</h5>
                        <p class="text-[10px] text-muted-gray mt-1">Kamu memilih kebiasaan sehat!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Card: Survey/Kuesioner TPB & Riset -->
        <div class="bg-white rounded-[24px] p-5 border border-slate-100 shadow-premium flex flex-col gap-4">
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-lg shrink-0">
                    📋
                </div>
                <div>
                    <h5 class="font-bold text-dark-navy text-sm">Pusat Kuesioner Riset SmartSip</h5>
                    <p class="text-[10px] font-semibold text-muted-gray mt-1 leading-relaxed">
                        Lengkapi kuesioner berkala (FFQ 7 Hari, TPB 23 Item, Pengetahuan Gula, & Evaluasi Usability) dan dapatkan Poin Gamifikasi!
                    </p>
                </div>
            </div>
            <a href="{{ route('survey.index') }}" class="w-full py-3 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-primary/20 text-center uppercase tracking-wider">
                Buka Pusat Kuesioner
            </a>
        </div>

    </div>

    <!-- Chart script -->
    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('sugarChart').getContext('2d');
                const labels = @json($chartLabels);
                const dataPoints = @json($chartData);
                
                const gradient = ctx.createLinearGradient(0, 0, 0, 180);
                gradient.addColorStop(0, 'rgba(92, 98, 249, 0.35)');
                gradient.addColorStop(1, 'rgba(92, 98, 249, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Gula (g)',
                            data: dataPoints,
                            borderColor: '#5c62f9',
                            backgroundColor: gradient,
                            borderWidth: 3.5,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#5c62f9',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e224f',
                                titleColor: '#ffffff',
                                bodyColor: '#f3f5fa',
                                padding: 10,
                                cornerRadius: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' gram';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(143, 150, 180, 0.1)', drawBorder: false },
                                ticks: { color: '#8f96b4', font: { size: 9, weight: 'bold' } }
                            },
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#8f96b4', font: { size: 9, weight: 'bold' } }
                            }
                        }
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
