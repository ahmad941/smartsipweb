<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">FFQ 7 Hari</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <div class="text-center">
            <span class="text-3xl">🥤</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Food Frequency Questionnaire (FFQ)</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Selama <span class="font-bold text-primary">7 hari terakhir</span>, seberapa sering Anda mengonsumsi jenis minuman berpemanis berikut beserta ukuran porsinya? (Fase {{ $phase }})
            </p>
        </div>

        <form method="POST" action="{{ route('survey.ffq.store') }}" class="space-y-4">
            @csrf

            @foreach ($beverages as $index => $b)
                <div x-data="{ freq: '0' }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">
                                {{ $index + 1 }}
                            </span>
                            <h4 class="text-sm font-bold text-dark-navy">{{ $b['name'] }}</h4>
                        </div>
                        <span class="text-[10px] font-bold text-muted-gray bg-slate-100 px-2 py-0.5 rounded">
                            {{ $b['sugar_100ml'] }}g gula/100ml
                        </span>
                    </div>

                    <!-- Frequency Selector -->
                    <div>
                        <label class="block text-[10px] font-extrabold text-muted-gray uppercase tracking-wider mb-1.5">Frekuensi Konsumsi (7 Hari):</label>
                        <select name="freq[{{ $index }}]" x-model="freq" required class="block w-full h-10 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-dark-navy focus:ring-primary focus:border-primary">
                            <option value="0" selected>Tidak Pernah (0)</option>
                            <option value="1">1–2 kali / minggu</option>
                            <option value="2">3–4 kali / minggu</option>
                            <option value="3">5–6 kali / minggu</option>
                            <option value="4">Setiap Hari</option>
                        </select>
                    </div>

                    <!-- Portion Selector (Dimmed & Disabled if freq === '0') -->
                    <div :class="freq === '0' ? 'opacity-40 pointer-events-none' : ''" class="transition-all duration-200">
                        <label class="block text-[10px] font-extrabold text-muted-gray uppercase tracking-wider mb-1.5 flex justify-between items-center">
                            <span>Ukuran Porsi Sekali Minum:</span>
                            <span x-show="freq === '0'" class="text-[9px] text-amber-600 font-bold lowercase normal-case">(tidak terhitung karena frekuensi 0)</span>
                        </label>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <label class="flex items-center justify-center gap-1.5 p-2 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100">
                                <input type="radio" name="portion[{{ $index }}]" value="250" checked class="text-primary focus:ring-primary w-3.5 h-3.5" />
                                <span class="text-xs font-bold text-dark-navy">Kecil <span class="text-[9px] text-muted-gray">(250ml)</span></span>
                            </label>
                            <label class="flex items-center justify-center gap-1.5 p-2 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100">
                                <input type="radio" name="portion[{{ $index }}]" value="350" class="text-primary focus:ring-primary w-3.5 h-3.5" />
                                <span class="text-xs font-bold text-dark-navy">Sedang <span class="text-[9px] text-muted-gray">(350ml)</span></span>
                            </label>
                            <label class="flex items-center justify-center gap-1.5 p-2 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100">
                                <input type="radio" name="portion[{{ $index }}]" value="450" class="text-primary focus:ring-primary w-3.5 h-3.5" />
                                <span class="text-xs font-bold text-dark-navy">Besar <span class="text-[9px] text-muted-gray">(450ml)</span></span>
                            </label>
                        </div>
                    </div>

                </div>
            @endforeach

            <div class="pt-4 pb-8">
                <button type="submit" 
                    class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                    Kirim Kuesioner FFQ
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
