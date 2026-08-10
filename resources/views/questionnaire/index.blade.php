<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Kuesioner</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <div class="text-center">
            <span class="text-3xl">📋</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Kuesioner TPB</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Pernyataan riset Theory of Planned Behavior (Fase {{ $phase }}).
            </p>
        </div>

        <div class="p-4 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-2xl text-xs leading-relaxed shadow-premium">
            <h5 class="font-bold text-dark-navy">Petunjuk Pengisian:</h5>
            <p class="mt-1">
                Pilihlah salah satu opsi jawaban (skala 1-5) yang paling sesuai dengan kondisimu. Kerahasiaan jawabanmu terjamin sepenuhnya.
            </p>
            <span class="inline-block mt-2.5 px-2 py-0.5 bg-primary/15 text-primary text-[9px] font-extrabold uppercase rounded">
                Reward Misi: +20 Pts
            </span>
        </div>

        <!-- Form questions -->
        <form method="POST" action="{{ route('questionnaire.store') }}" class="space-y-4">
            @csrf

            @error('answers.*')
                <div class="p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-2xl text-xs font-bold leading-normal">
                    {{ $message }}
                </div>
            @enderror

            @foreach($questions as $index => $q)
                <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-xs font-extrabold text-dark-navy">
                            {{ $index + 1 }}
                        </span>
                        <span class="px-2 py-0.5 bg-slate-50 text-[9px] font-extrabold uppercase text-muted-gray rounded tracking-wider">
                            {{ str_replace('_', ' ', $q->construct_type) }}
                        </span>
                    </div>

                    <p class="text-sm font-bold text-dark-navy leading-relaxed">
                        {{ $q->question_text }}
                    </p>

                    <!-- Radio circle scales -->
                    <div class="grid grid-cols-5 gap-2 pt-2 text-center">
                        <!-- STS -->
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="radio" name="answers[{{ $q->id }}]" value="1" required
                                class="text-rose-500 focus:ring-rose-500/25 bg-white border-slate-200 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">STS</span>
                        </label>

                        <!-- TS -->
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="radio" name="answers[{{ $q->id }}]" value="2" required
                                class="text-orange-500 focus:ring-orange-500/25 bg-white border-slate-200 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">TS</span>
                        </label>

                        <!-- R -->
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="radio" name="answers[{{ $q->id }}]" value="3" required
                                class="text-amber-500 focus:ring-amber-500/25 bg-white border-slate-200 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">R</span>
                        </label>

                        <!-- S -->
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="radio" name="answers[{{ $q->id }}]" value="4" required
                                class="text-emerald-500 focus:ring-emerald-500/25 bg-white border-slate-200 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">S</span>
                        </label>

                        <!-- SS -->
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="radio" name="answers[{{ $q->id }}]" value="5" required
                                class="text-teal-500 focus:ring-teal-500/25 bg-white border-slate-200 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">SS</span>
                        </label>
                    </div>
                    <div class="flex justify-between text-[8px] text-slate-400 font-bold px-1 uppercase tracking-wider">
                        <span>Sangat Tidak Setuju</span>
                        <span>Ragu-ragu</span>
                        <span>Sangat Setuju</span>
                    </div>

                </div>
            @endforeach

            <div class="pt-4 pb-8">
                <button type="submit" 
                    class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                    Kirim Kuesioner
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
