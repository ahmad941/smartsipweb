<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Kuesioner Pengetahuan</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <div class="text-center">
            <span class="text-3xl">🧠</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Pengetahuan Tentang Konsumsi Gula</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Pilihlah satu jawaban yang menurut Anda paling benar (Fase {{ $phase }}).
            </p>
        </div>

        <form method="POST" action="{{ route('survey.knowledge.store') }}" class="space-y-4">
            @csrf

            @foreach($questions as $index => $q)
                <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-premium space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-xs font-extrabold text-indigo-600">
                            {{ $index + 1 }}
                        </span>
                        <h4 class="text-sm font-bold text-dark-navy leading-normal">{{ $q->question_text }}</h4>
                    </div>

                    <div class="space-y-2 pt-1">
                        @foreach($q->options as $key => $optText)
                            <label class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $key }}" required
                                    class="mt-0.5 text-primary focus:ring-primary/25 bg-white border-slate-300 w-4 h-4 cursor-pointer" />
                                <span class="text-xs font-medium text-slate-700 leading-normal">
                                    <strong class="text-dark-navy font-bold">{{ $key }}.</strong> {{ $optText }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="pt-4 pb-8">
                <button type="submit" 
                    class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                    Kirim Kuesioner Pengetahuan
                </button>
            </div>

        </form>

    </div>
</x-app-layout>
