<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartSip - Kendalikan Manismu!</title>
    <link rel="icon" href="{{ asset('images/smartsip_favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,850&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-secondary text-dark-navy font-sans selection:bg-primary/30 selection:text-primary">
    
    <!-- Decorative Background Gradient (Light mint/purple tone matching layout style but using dashboard colors) -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 bg-gradient-to-tr from-secondary via-white to-indigo-50/50"></div>

    <!-- Navigation Header -->
    <header class="relative z-20 w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-primary/20 text-white font-extrabold text-lg">
                S
            </div>
            <span class="text-xl font-extrabold text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        
        <!-- Menu Items (desktop center navigation as in style reference) -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="#home" class="text-xs font-bold text-dark-navy hover:text-primary transition-colors">Home</a>
            <a href="#calculator" class="text-xs font-bold text-muted-gray hover:text-primary transition-colors">Kalkulator Gula</a>
            <a href="#features" class="text-xs font-bold text-muted-gray hover:text-primary transition-colors">Keunggulan</a>
            <a href="#about" class="text-xs font-bold text-muted-gray hover:text-primary transition-colors">Tentang Riset</a>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-primary rounded-full hover:bg-primary-dark transition-colors shadow-lg shadow-primary/25">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-xs font-bold text-primary border border-primary/20 hover:border-primary rounded-full hover:bg-primary/5 transition-all">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-primary rounded-full hover:bg-primary-dark transition-colors shadow-lg shadow-primary/25">
                            Sign Up
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <main id="home" class="relative z-10 max-w-7xl mx-auto px-6 pt-8 pb-16 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <!-- Hero Left Content (Col 7) -->
        <div class="lg:col-span-7 space-y-6 text-left">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-100 text-primary text-xs font-bold shadow-premium">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                Platform Pelacakan Gula Gen Z
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold text-dark-navy tracking-tight leading-tight">
                Pilihan Utama untuk <br>
                <span class="text-primary">Kesehatan</span> dan <span class="text-cyan-500">Kebugaranmu</span>
            </h1>

            <p class="text-sm md:text-base text-muted-gray max-w-xl leading-relaxed font-semibold">
                Pantau asupan gula harianmu secara instan, selesaikan misi sehat bersama teman sekelas, kumpulkan poin, dan pelajari edukasi gizi dengan cara yang interaktif.
            </p>

            <!-- Instant Student Access Card (Tanpa Password) -->
            <div id="akses-siswa" class="relative group max-w-lg w-full mt-6">
                <!-- Glowing Aura -->
                <div class="absolute -inset-1 bg-gradient-to-r from-primary via-indigo-500 to-cyan-400 rounded-3xl blur-xl opacity-40 group-hover:opacity-75 transition-all duration-300"></div>
                
                <!-- Main Card Body -->
                <div class="relative bg-white rounded-3xl p-5 sm:p-7 border border-slate-200 shadow-xl overflow-hidden space-y-4">
                    
                    <!-- Title -->
                    <div class="space-y-1 text-left">
                        <h3 class="text-xl sm:text-2xl font-black text-dark-navy tracking-tight leading-snug">
                            Mulai Perjalanan Sehatmu 
                            <span style="background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 50%, #06b6d4 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">Sekarang!</span>
                        </h3>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('siswa.login.store') }}" class="space-y-3">
                        @csrf
                        
                        <!-- Flex Input Wrapper -->
                        <div class="flex items-center w-full bg-slate-50 border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-primary/40 focus-within:border-primary transition-all">
                            <div class="pl-3.5 pr-1 text-primary shrink-0 flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="email" required placeholder="Ketik emailmu (cth: siswa@gmail.com)"
                                class="w-full h-11 py-2.5 pr-3 bg-transparent text-dark-navy text-xs font-bold placeholder-slate-400 border-none outline-none focus:outline-none focus:ring-0" />
                        </div>

                        <!-- CTA Button -->
                        <button type="submit" class="w-full h-11 sm:h-12 px-5 rounded-xl text-xs font-black text-white bg-gradient-to-r from-primary via-indigo-600 to-cyan-600 hover:from-primary-dark hover:to-indigo-700 transition-all duration-200 shadow-md shadow-primary/25 active:scale-[0.98] flex items-center justify-center gap-2">
                            <span>🚀 Masuk / Daftar Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>

                    <!-- Footer Link -->
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-end text-[11px] font-bold">
                        <a href="{{ route('login') }}" class="text-slate-400 hover:text-primary transition-colors flex items-center gap-1">
                            <span>Login Guru/Admin</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Interactive Widget Card (Matches Booking Widget) -->
            <div id="calculator" class="bg-white rounded-3xl p-6 border border-slate-100 shadow-premium max-w-lg relative overflow-hidden mt-6" x-data="sugarCalculator()">

                <div class="grid grid-cols-2 gap-4">
                    <!-- Pick a Drink -->
                    <div>
                        <label class="block text-[10px] font-extrabold text-muted-gray uppercase tracking-wider mb-2">🍹 Pilih Minuman</label>
                        <select x-model="drink" class="block w-full h-11 px-3 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs focus:outline-none cursor-pointer">
                            @if(isset($beverages) && $beverages->count() > 0)
                                @foreach($beverages->groupBy(fn($item) => $item->category->name ?? 'Lainnya') as $categoryName => $items)
                                    <optgroup label="{{ $categoryName }}">
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sugar_per_100ml }}g/100ml)</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @else
                                <option value="1">Teh manis kemasan (9.8g/100ml)</option>
                                <option value="2">Teh tarik (11.2g/100ml)</option>
                                <option value="3">Thai tea (13.5g/100ml)</option>
                                <option value="4">Kopi susu (12.4g/100ml)</option>
                                <option value="5">Boba (14.2g/100ml)</option>
                                <option value="6">Minuman soda (10.6g/100ml)</option>
                            @endif
                        </select>


                    </div>

                    <!-- Volume -->
                    <div>
                        <label class="block text-[10px] font-extrabold text-muted-gray uppercase tracking-wider mb-2">🥤 Ukuran Porsi</label>
                        <select x-model.number="volume" class="block w-full h-11 px-3 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs focus:outline-none cursor-pointer">
                            <option value="250">Gelas Sedang (250 ml)</option>
                            <option value="350">Kaleng Sedang (350 ml)</option>
                            <option value="500">Gelas Besar (500 ml)</option>
                        </select>
                    </div>
                </div>

                <!-- Action Button -->
                <button @click="calculate()" class="w-full mt-5 h-12 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-primary/20 active:scale-95 duration-200">
                    Cek Kandungan Gula
                </button>

                <!-- Interactive Result Display Overlay -->
                <div x-show="showResult" x-transition class="absolute inset-0 bg-white p-6 flex flex-col justify-between z-10 rounded-3xl border border-slate-100 shadow-inner">
                    <div class="text-center space-y-2">
                        <span class="text-xs font-bold text-muted-gray uppercase tracking-widest">Kandungan Gula Hasil Simulasi</span>
                        <h4 class="text-3xl font-extrabold text-rose-500" x-text="grams + ' gram'"></h4>
                        <p class="text-xs font-bold text-dark-navy leading-relaxed">
                            Minuman ini mengandung sekitar <span class="text-rose-500" x-text="percentage + '%'"></span> dari batas maksimum harian WHO (25g).
                        </p>
                    </div>
                    
                    <div class="flex gap-3 mt-4">
                        <button @click="reset()" class="flex-1 h-11 bg-slate-100 hover:bg-slate-200 text-dark-navy text-xs font-bold rounded-xl transition-all">
                            Hitung Lagi
                        </button>
                        <a href="{{ route('register') }}" class="flex-1 h-11 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl flex items-center justify-center transition-all shadow-md shadow-primary/20">
                            Catat Minuman
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Hero Right Graphic (Col 5) -->
        <div class="lg:col-span-5 relative flex justify-center">
            <div class="relative w-full max-w-[340px] aspect-[4/5] rounded-[36px] overflow-hidden shadow-2xl border-[8px] border-white bg-slate-100">
                <!-- Main teenager image generated via tool -->
                <img src="/hero_teenager_1784521519476.png" alt="Healthy Teenager" class="w-full h-full object-cover">
                
                <!-- Overlay Card 1: Top Floating Stats Card -->
                <div class="absolute top-6 -right-4 bg-white/95 backdrop-blur shadow-premium rounded-2xl p-4 border border-slate-100 flex items-center gap-3 animate-bounce" style="animation-duration: 4s;">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg">
                        🍃
                    </div>
                    <div>
                        <span class="text-[9px] font-extrabold text-muted-gray uppercase block">Batas WHO</span>
                        <span class="text-xs font-bold text-dark-navy">Maksimal 25g/hari</span>
                    </div>
                </div>

                <!-- Overlay Card 2: Bottom Floating Stats Card -->
                <div class="absolute bottom-10 -left-6 bg-white/95 backdrop-blur shadow-premium rounded-2xl p-4 border border-slate-100 flex items-center gap-3 animate-bounce" style="animation-duration: 6s; animation-delay: 1s;">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-lg">
                        ⭐
                    </div>
                    <div>
                        <span class="text-[9px] font-extrabold text-muted-gray uppercase block">Target Hidup Sehat</span>
                        <span class="text-xs font-bold text-dark-navy">95% Sukses Misi</span>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Why Choose Us / Our Capabilities section (Matches style reference) -->
    <section id="features" class="relative z-10 w-full max-w-7xl mx-auto px-6 py-16 lg:py-24 border-t border-slate-100">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Header details -->
            <div class="lg:col-span-5 space-y-4 text-left">
                <span class="text-xs font-bold text-primary uppercase tracking-widest">Mengapa Memilih Kami</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-dark-navy tracking-tight leading-tight">
                    Kemampuan & <br>
                    <span class="text-primary">Fitur Unggulan</span> Kami
                </h2>
                <p class="text-xs font-semibold text-muted-gray leading-relaxed max-w-sm">
                    SmartSip tidak hanya mencatat konsumsi minuman manismu, tetapi juga memberikan bimbingan psikologis berbasis riset untuk mengubah kebiasaanmu secara berkelanjutan.
                </p>
                <div class="pt-4">
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center h-11 px-6 rounded-xl text-xs font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-md shadow-primary/20">
                        Coba Platform Gratis
                    </a>
                </div>
            </div>

            <!-- Right Offset Grid Cards -->
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Feature 1 -->
                <div class="p-6 rounded-[24px] bg-white border border-slate-100 shadow-premium space-y-3">
                    <div class="w-11 h-11 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-xl shadow-inner">
                        🎯
                    </div>
                    <h4 class="text-sm font-bold text-dark-navy">Sugar Tracker Real-time</h4>
                    <p class="text-xs font-semibold text-muted-gray leading-relaxed">
                        Catat minuman manismu dan ketahui grafik asupan gula harianmu secara instan dan interaktif.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 rounded-[24px] bg-white border border-slate-100 shadow-premium space-y-3 sm:translate-y-4">
                    <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center text-xl shadow-inner">
                        🧠
                    </div>
                    <h4 class="text-sm font-bold text-dark-navy">Smart Warning TPB</h4>
                    <p class="text-xs font-semibold text-muted-gray leading-relaxed">
                        Pemberitahuan otomatis cerdas berdasarkan teori psikologi kognitif Theory of Planned Behavior.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 rounded-[24px] bg-white border border-slate-100 shadow-premium space-y-3">
                    <div class="w-11 h-11 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-xl shadow-inner">
                        🏆
                    </div>
                    <h4 class="text-sm font-bold text-dark-navy">Gamifikasi & Poin</h4>
                    <p class="text-xs font-semibold text-muted-gray leading-relaxed">
                        Kerjakan kuis seru berpoin, kumpulkan medali emas, dan naiki papan peringkat klasemen bersama teman sekelas.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 rounded-[24px] bg-white border border-slate-100 shadow-premium space-y-3 sm:translate-y-4">
                    <div class="w-11 h-11 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center text-xl shadow-inner">
                        ⚖️
                    </div>
                    <h4 class="text-sm font-bold text-dark-navy">Pemantauan Antropometri</h4>
                    <p class="text-xs font-semibold text-muted-gray leading-relaxed">
                        Catat data fisik tinggi dan berat badan secara berkala serta pantau status indeks massa tubuh (IMT).
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- Research Background Info Section -->
    <section id="about" class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12 text-center">
        <div class="bg-white border border-slate-100 rounded-[32px] p-8 lg:p-12 shadow-premium max-w-4xl mx-auto space-y-4">
            <span class="text-[10px] font-extrabold text-primary uppercase tracking-widest bg-primary/10 px-3 py-1 rounded-full">Background Penelitian</span>
            <h3 class="text-2xl font-extrabold text-dark-navy leading-tight">Intervensi Theory of Planned Behavior (TPB)</h3>
            <p class="text-xs font-semibold text-muted-gray leading-relaxed max-w-2xl mx-auto">
                Aplikasi ini dikembangkan sebagai bagian dari instrumen penelitian ilmiah untuk menguji perubahan perilaku konsumsi minuman manis pada remaja (Gen Z) menggunakan pendekatan teori kognitif terencana (TPB).
            </p>
            <div class="flex justify-center gap-6 pt-4 text-left border-t border-slate-50 mt-6 max-w-lg mx-auto">
                <div class="text-center">
                    <h5 class="text-2xl font-extrabold text-primary">T0</h5>
                    <span class="text-[9px] font-bold text-muted-gray uppercase block mt-1">Pre-test</span>
                </div>
                <div class="border-l border-slate-100 pl-6 text-center">
                    <h5 class="text-2xl font-extrabold text-primary">T1</h5>
                    <span class="text-[9px] font-bold text-muted-gray uppercase block mt-1">Mid-test</span>
                </div>
                <div class="border-l border-slate-100 pl-6 text-center">
                    <h5 class="text-2xl font-extrabold text-primary">T2</h5>
                    <span class="text-[9px] font-bold text-muted-gray uppercase block mt-1">Post-test</span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="relative z-10 text-center py-8 border-t border-slate-150 mt-16 bg-white">
        <p class="text-xs font-bold text-muted-gray">
            &copy; {{ date('Y') }} Tim Peneliti Hibah Dikti - Theory of Planned Behavior. SmartSip App.
        </p>
    </footer>

    <!-- Alpine Calculator Logic -->
    <script>
        function sugarCalculator() {
            return {
                drink: '{{ isset($beverages) && $beverages->first() ? $beverages->first()->id : "1" }}',
                volume: 250,
                showResult: false,
                grams: 0,
                percentage: 0,
                calculate() {
                    const sugarData = @json($sugarDataMap ?? []);

                    let rawSugar = sugarData[this.drink] ?? sugarData[String(this.drink)] ?? sugarData[Number(this.drink)];
                    if (rawSugar === undefined && Object.keys(sugarData).length > 0) {
                        rawSugar = Object.values(sugarData)[0];
                    }
                    const sugarPer100 = parseFloat(rawSugar) || 10.0;
                    const vol = parseFloat(this.volume) || 250;
                    const totalGrams = (sugarPer100 * vol) / 100;
                    this.grams = isNaN(totalGrams) ? '25.0' : totalGrams.toFixed(1);
                    const perc = Math.round((parseFloat(this.grams) / 25) * 100);
                    this.percentage = isNaN(perc) ? 100 : perc;
                    this.showResult = true;
                },
                reset() {
                    this.showResult = false;
                }
            }
        }
    </script>


</body>
</html>
