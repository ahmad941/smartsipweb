<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Edukasi</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6" x-data="{ sectionTab: 'education' }">
        
        <div class="text-center">
            <span class="text-3xl">📚</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Edukasi & Kuis</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Pelajari bahaya gula tersembunyi dan kerjakan kuis seru untuk menguji pengetahuanmu!
            </p>
        </div>

        <!-- Tab selector -->
        <div class="bg-white p-1 rounded-2xl border border-slate-100 shadow-premium flex">
            <button @click="sectionTab = 'education'" :class="sectionTab === 'education' ? 'bg-primary text-white font-bold' : 'text-muted-gray'"
                class="flex-1 text-center py-3 rounded-xl text-xs font-semibold transition-all focus:outline-none">
                📖 Materi Edukasi
            </button>
            <button @click="sectionTab = 'quiz'" :class="sectionTab === 'quiz' ? 'bg-primary text-white font-bold' : 'text-muted-gray'"
                class="flex-1 text-center py-3 rounded-xl text-xs font-semibold transition-all focus:outline-none">
                🧠 Kuis Berpoin
            </button>
        </div>

        <!-- TAB 1: EDUCATION ARTICLES -->
        <div x-show="sectionTab === 'education'" class="space-y-5">
            @forelse($articles as $art)
                <div class="bg-white border border-slate-100 rounded-[24px] overflow-hidden shadow-premium flex flex-col">
                    <!-- Media Display (YouTube embed) -->
                    @if($art->type === 'video' && $art->embed_url)
                        <div class="w-full aspect-video relative">
                            <iframe class="w-full h-full border-0 absolute top-0 left-0" 
                                src="{{ $art->embed_url }}" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                        </div>
                    @endif

                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 text-[9px] font-extrabold uppercase rounded tracking-wider
                                @if($art->type === 'video') bg-blue-50 text-blue-500 border border-blue-100
                                @elseif($art->type === 'tips') bg-amber-50 text-amber-500 border border-amber-100
                                @else bg-emerald-50 text-emerald-500 border border-emerald-100 @endif">
                                {{ $art->type }}
                            </span>
                        </div>
                        <h4 class="text-base font-extrabold text-dark-navy">{{ $art->title }}</h4>
                        <p class="text-xs text-muted-gray leading-relaxed whitespace-pre-line">
                            {{ $art->content }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-slate-100 rounded-[24px] p-8 text-center shadow-premium">
                    <span class="text-slate-400 text-xs">Materi edukasi belum tersedia.</span>
                </div>
            @endforelse
        </div>

        <!-- TAB 2: INTERACTIVE QUIZ -->
        <div x-show="sectionTab === 'quiz'" class="space-y-6" style="display: none;">
            @foreach($quizzes as $q)
                <div class="bg-white border rounded-[24px] p-5 shadow-premium relative overflow-hidden transition-all duration-300
                    @if($q['is_completed']) border-emerald-150 bg-white/70 @else border-slate-100 @endif">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <span class="px-2 py-0.5 bg-amber-50 border border-amber-100 text-amber-500 text-[9px] font-extrabold uppercase rounded tracking-wider">
                            ⭐ +{{ $q['reward'] }} Pts
                        </span>
                        
                        @if($q['is_completed'])
                            <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-wide flex items-center gap-1">
                                Selesai ✅
                            </span>
                        @endif
                    </div>

                    <h4 class="text-xs font-extrabold text-muted-gray uppercase mt-3">Pertanyaan Kuis #{{ $q['id'] }}</h4>
                    <p class="text-sm font-bold text-dark-navy mt-1.5 leading-relaxed">
                        {{ $q['question'] }}
                    </p>

                    <!-- Feedbacks -->
                    @if(session('quiz_feedback_success') && session('quiz_feedback_success')['quiz_id'] == $q['id'])
                        <div class="my-4 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs leading-relaxed">
                            <strong class="font-extrabold block">Jawabanmu Benar! 🥳</strong>
                            <p class="mt-1">{{ session('quiz_feedback_success')['explanation'] }}</p>
                        </div>
                    @endif

                    @if(session('quiz_feedback_error') && session('quiz_feedback_error')['quiz_id'] == $q['id'])
                        <div class="my-4 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-xs leading-relaxed">
                            <strong class="font-extrabold block">Jawabanmu Salah! 😢</strong>
                            <p class="mt-1">{{ session('quiz_feedback_error')['message'] }}</p>
                            <div class="mt-2.5 p-3 bg-slate-50 rounded-lg border border-slate-100 text-slate-600">
                                <strong class="text-dark-navy font-bold block mb-0.5">Fakta Ilmiah:</strong>
                                {{ session('quiz_feedback_error')['explanation'] }}
                            </div>
                        </div>
                    @endif

                    <!-- Form / Completion explanation -->
                    @if($q['is_completed'])
                        @if(!session('quiz_feedback_success') || session('quiz_feedback_success')['quiz_id'] != $q['id'])
                            <div class="mt-4 p-4 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-600 leading-relaxed">
                                <strong class="text-dark-navy font-bold block mb-1">Penjelasan:</strong>
                                {{ $q['explanation'] }}
                            </div>
                        @endif
                    @else
                        <form method="POST" action="{{ route('education.quiz.answer') }}" class="mt-5 space-y-3">
                            @csrf
                            <input type="hidden" name="quiz_id" value="{{ $q['id'] }}" />
                            
                            <div class="space-y-2">
                                @foreach($q['options'] as $key => $optValue)
                                    <label class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 border border-slate-100 rounded-xl cursor-pointer transition-colors">
                                        <input type="radio" name="answer" value="{{ $key }}" required
                                            class="text-primary focus:ring-primary/20 bg-white border-slate-200 w-4 h-4 cursor-pointer" />
                                        <span class="text-xs font-semibold text-dark-navy leading-normal">
                                            <strong class="text-primary">{{ $key }}.</strong> {{ $optValue }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white font-bold text-xs rounded-xl transition-all shadow-md active:scale-95 duration-200">
                                    Kirim Jawaban
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
