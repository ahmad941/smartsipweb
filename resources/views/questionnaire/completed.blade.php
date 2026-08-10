<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Kuesioner Selesai</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 flex flex-col justify-center min-h-[70vh] text-center space-y-6">
        
        <div>
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-50 border border-emerald-100 text-emerald-500 rounded-full text-3xl mb-4 animate-bounce">
                🎉
            </div>
            <h3 class="text-xl font-extrabold text-dark-navy">Kuesioner Lengkap!</h3>
            <p class="text-xs text-muted-gray mt-2 leading-relaxed">
                Terima kasih! Kamu telah melengkapi seluruh kuesioner *Theory of Planned Behavior* (TPB) untuk penelitian ini. Kontribusimu sangat berharga!
            </p>
        </div>

        <!-- Checklist -->
        <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium space-y-3.5 text-left">
            <h4 class="text-[10px] font-extrabold text-muted-gray uppercase tracking-widest mb-1">Riwayat Pengisian</h4>
            
            <div class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-xs font-bold text-dark-navy">Fase T0 (Pre-test)</span>
                <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-wide flex items-center gap-1">Lengkap ✅</span>
            </div>

            <div class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-xs font-bold text-dark-navy">Fase T1 (Mid-test)</span>
                <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-wide flex items-center gap-1">Lengkap ✅</span>
            </div>

            <div class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-xs font-bold text-dark-navy">Fase T2 (Post-test)</span>
                <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-wide flex items-center gap-1">Lengkap ✅</span>
            </div>
        </div>

        <div>
            <a href="{{ route('dashboard') }}" 
                class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</x-app-layout>
