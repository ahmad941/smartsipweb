<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-100 leading-tight tracking-tight">
                {{ __('Overview Dashboard') }}
            </h2>
            <div class="px-4 py-2 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full text-sm font-semibold tracking-wide">
                Active User
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl shadow-xl shadow-emerald-900/20 mb-8 border border-emerald-500/30">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute right-20 -bottom-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                
                <div class="relative z-10 p-8 sm:p-10">
                    <h3 class="text-3xl font-extrabold text-white mb-2">Welcome to SmartSip, {{ Auth::user()->name ?? 'Z-Warrior' }}! 👋</h3>
                    <p class="text-emerald-100 max-w-2xl text-lg">Pantau terus asupan gulamu dan raih poin tertinggi di papan peringkat.</p>
                </div>
            </div>

            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Card 1: Sugar Intake Today -->
                <div class="group bg-slate-900/80 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-sm hover:shadow-blue-500/10 hover:border-blue-500/30 transition-all duration-300 hover:-translate-y-1 cursor-default relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-blue-500/10 transition-colors"></div>
                    
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <h4 class="text-slate-400 font-medium">Total Gula Hari Ini</h4>
                        <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-2 relative z-10">
                        <span class="text-4xl font-extrabold text-white">{{ number_format($todaySugar ?? 0, 1) }}</span>
                        <span class="text-slate-400 font-medium mb-1">gram</span>
                    </div>
                    @if(($todaySugar ?? 0) > 25)
                        <p class="text-sm text-rose-400 mt-2 font-medium">Asupan melebihi batas 25g!</p>
                    @else
                        <p class="text-sm text-emerald-400 mt-2 font-medium">Asupan aman sejauh ini.</p>
                    @endif
                </div>

                <!-- Card 2: Points -->
                <div class="group bg-slate-900/80 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 shadow-sm hover:shadow-amber-500/10 hover:border-amber-500/30 transition-all duration-300 hover:-translate-y-1 cursor-default relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-amber-500/10 transition-colors"></div>

                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <h4 class="text-slate-400 font-medium">Total Poin Kamu</h4>
                        <div class="p-2 bg-amber-500/10 text-amber-400 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-2 relative z-10">
                        <span class="text-4xl font-extrabold text-white">{{ number_format($totalPoints ?? 0) }}</span>
                        <span class="text-amber-400 text-sm font-semibold mb-1 flex items-center">
                            PTS
                        </span>
                    </div>
                    <p class="text-sm text-slate-400 mt-2">Kumpulkan terus poinmu!</p>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="bg-slate-900/80 backdrop-blur-md border border-slate-700/50 rounded-2xl shadow-sm p-6 overflow-hidden relative">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-white">Grafik Konsumsi Gula (7 Hari Terakhir)</h3>
                    <a href="{{ route('sugar-consumptions.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-semibold transition-colors shadow-lg shadow-blue-500/20">
                        + Catat Minuman
                    </a>
                </div>
                
                <div class="w-full h-[350px] relative">
                    <canvas id="sugarChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js CDN and Initialization -->
    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('sugarChart').getContext('2d');
                
                // Ambil data dari backend PHP
                const labels = @json($chartLabels ?? []);
                const dataPoints = @json($chartData ?? []);
                
                // Gradient untuk area chart
                const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); // blue-500 dengan opacity
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Gula (gram)',
                            data: dataPoints,
                            borderColor: '#3b82f6', // Tailwind blue-500
                            backgroundColor: gradient,
                            borderWidth: 3,
                            pointBackgroundColor: '#1e293b', // slate-800
                            pointBorderColor: '#3b82f6',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true,
                            tension: 0.4 // Garis melengkung halus
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)', // slate-900
                                titleColor: '#f1f5f9', // slate-100
                                bodyColor: '#cbd5e1', // slate-300
                                padding: 12,
                                borderColor: 'rgba(51, 65, 85, 0.5)', // slate-700
                                borderWidth: 1,
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
                                grid: {
                                    color: 'rgba(51, 65, 85, 0.3)', // slate-700
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#94a3b8', // slate-400
                                    padding: 10
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#94a3b8', // slate-400
                                    padding: 10
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
