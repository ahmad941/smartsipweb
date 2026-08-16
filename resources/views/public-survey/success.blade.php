<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuesioner Berhasil Disimpan - SmartSip</title>
    <link rel="icon" href="{{ asset('images/smartsip_favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary text-dark-navy font-sans antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">

    <!-- Decorative Background Gradients -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 bg-gradient-to-tr from-secondary via-white to-emerald-50/60"></div>
    <div class="fixed top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="w-full max-w-2xl bg-white rounded-[32px] p-6 sm:p-10 border border-slate-150 shadow-premium relative overflow-hidden text-center space-y-6">
        
        <!-- Header Banner & Celebration Emoji -->
        <div class="space-y-3">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-emerald-100 border border-emerald-200 flex items-center justify-center text-4xl shadow-lg shadow-emerald-500/20">
                🎉
            </div>
            
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs font-black uppercase tracking-wider">
                <span>✨ Pengisian Sukses (+60 Poin Gamifikasi)</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black text-dark-navy tracking-tight">
                Terima Kasih, {{ $student->nickname }}!
            </h1>

            <p class="text-xs sm:text-sm text-muted-gray font-medium max-w-md mx-auto leading-relaxed">
                Kuesioner awal kamu telah berhasil disimpan di database SmartSip. Akun kamu sudah aktif dan siap digunakan!
            </p>

            @if(session('info'))
                <div class="p-3.5 bg-amber-50 border border-amber-200 text-amber-700 rounded-2xl text-xs font-bold max-w-md mx-auto">
                    {{ session('info') }}
                </div>
            @endif
        </div>

        <!-- Account Info Card -->
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-left flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary font-black flex items-center justify-center text-lg">
                    📧
                </div>
                <div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Email Akun Kamu (Untuk Login)</span>
                    <strong class="text-xs sm:text-sm font-black text-dark-navy">{{ $student->user->email }}</strong>
                </div>
            </div>
            <div class="text-right sm:text-right w-full sm:w-auto">
                <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[11px] font-bold rounded-lg">
                    {{ $student->school->name ?? 'Sekolah' }} - {{ $student->schoolClass->name ?? 'Kelas' }}
                </span>
            </div>
        </div>

        <!-- Results Overview Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
            <!-- IMT Card -->
            <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-150 space-y-1">
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-wider block">⚖️ Indeks Massa Tubuh</span>
                <div class="text-lg font-black text-dark-navy">{{ $student->bmi_score ?? '-' }} <span class="text-xs font-semibold text-slate-500">kg/m²</span></div>
                <p class="text-[10px] font-bold text-slate-600">
                    Status Fizik: {{ $student->height_cm }}cm / {{ $student->weight_kg }}kg
                </p>
            </div>

            <!-- Knowledge Card -->
            <div class="p-4 rounded-2xl bg-cyan-50/60 border border-cyan-150 space-y-1">
                <span class="text-[10px] font-black text-cyan-700 uppercase tracking-wider block">🧠 Pengetahuan Gula</span>
                <div class="text-lg font-black text-dark-navy">
                    {{ $knowledgeResponse->score ?? 0 }}/10
                </div>
                <span class="inline-block text-[10px] font-extrabold px-2 py-0.5 rounded bg-cyan-200 text-cyan-800">
                    Kategori {{ $knowledgeResponse->category ?? '-' }}
                </span>
            </div>

            <!-- FFQ Card -->
            <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-150 space-y-1">
                <span class="text-[10px] font-black text-amber-700 uppercase tracking-wider block">🧃 Asupan Gula FFQ</span>
                <div class="text-lg font-black text-dark-navy">
                    {{ $ffqResponse->total_daily_sugar_grams ?? 0 }} <span class="text-xs font-semibold text-slate-500">g/hari</span>
                </div>
                <span class="inline-block text-[10px] font-extrabold px-2 py-0.5 rounded bg-amber-200 text-amber-800">
                    Kategori {{ $ffqResponse->category ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Call to Action Buttons -->
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('dashboard') }}" 
                class="flex-1 py-3.5 px-6 rounded-xl font-black text-xs text-white bg-gradient-to-r from-primary via-indigo-600 to-cyan-600 hover:opacity-95 transition-all shadow-lg shadow-primary/25 text-center flex items-center justify-center gap-2">
                <span>🚀 Masuk ke Dashboard SmartSip</span>
                <span>&rarr;</span>
            </a>

            <a href="{{ url('/') }}" 
                class="py-3.5 px-6 rounded-xl font-bold text-xs text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all text-center">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>
