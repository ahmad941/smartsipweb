<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-rose-500 px-2 py-0.5 bg-rose-50 rounded-lg border border-rose-100">Evaluasi Usability</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <div class="text-center">
            <span class="text-3xl">⭐</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Evaluasi Penggunaan SmartSip Web</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Berikan penilaian pengalaman Anda selama menggunakan aplikasi SmartSip Web (Skala 1 - 5).
            </p>
        </div>

        <form method="POST" action="{{ route('survey.usability.store') }}" class="space-y-4">
            @csrf

            @foreach($items as $index => $itemText)
                <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-rose-50 border border-rose-100 rounded-full flex items-center justify-center text-xs font-extrabold text-rose-600">
                            {{ $index }}
                        </span>
                        <h4 class="text-sm font-bold text-dark-navy leading-normal">{{ $itemText }}</h4>
                    </div>

                    <!-- Likert 1-5 Radio scale -->
                    <div class="grid grid-cols-5 gap-2 pt-1 text-center">
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100">
                            <input type="radio" name="scores[{{ $index }}]" value="1" required class="text-rose-500 focus:ring-rose-500 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">1 (STS)</span>
                        </label>
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100">
                            <input type="radio" name="scores[{{ $index }}]" value="2" required class="text-orange-500 focus:ring-orange-500 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">2 (TS)</span>
                        </label>
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100">
                            <input type="radio" name="scores[{{ $index }}]" value="3" required class="text-amber-500 focus:ring-amber-500 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">3 (N)</span>
                        </label>
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100">
                            <input type="radio" name="scores[{{ $index }}]" value="4" required class="text-emerald-500 focus:ring-emerald-500 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">4 (S)</span>
                        </label>
                        <label class="flex flex-col items-center gap-1.5 p-2 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100">
                            <input type="radio" name="scores[{{ $index }}]" value="5" required class="text-teal-500 focus:ring-teal-500 w-4 h-4 cursor-pointer" />
                            <span class="text-[9px] font-bold text-muted-gray">5 (SS)</span>
                        </label>
                    </div>
                </div>
            @endforeach

            <div class="pt-4 pb-8">
                <button type="submit" 
                    class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-rose-500 hover:bg-rose-600 transition-all shadow-lg shadow-rose-500/25 active:scale-[0.98]">
                    Kirim Evaluasi Usability
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
