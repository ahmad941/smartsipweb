<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Misi Sehat</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6">
        
        <!-- Alerts -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-bold leading-normal flex items-start gap-2 shadow-premium">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs font-bold leading-normal flex items-start gap-2 shadow-premium">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <div class="text-center">
            <span class="text-3xl">🎯</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Misi & Tantangan</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Selesaikan misi sehat harian untuk mengumpulkan poin dan menaikkan peringkat kelasmu!
            </p>
        </div>

        <!-- Challenges list -->
        <div class="space-y-4">
            @foreach($challengesStatus as $item)
                @php
                    $ch = $item['challenge'];
                    $isClaimed = $item['is_claimed'];
                    $isCompleted = $item['is_completed'];
                @endphp
                
                <div class="bg-white border rounded-[24px] p-5 shadow-premium relative overflow-hidden transition-all duration-300
                    {{ $isClaimed ? 'border-slate-100 bg-white/60 opacity-80' : ($isCompleted ? 'border-emerald-200' : 'border-slate-100') }}">
                    
                    <div class="flex flex-col gap-4">
                        <!-- Top Info -->
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 bg-primary/10 text-primary text-[9px] font-extrabold uppercase rounded tracking-wider">
                                    +{{ $ch->reward_points }} Pts
                                </span>
                                
                                @if($isClaimed)
                                    <span class="text-[10px] font-extrabold text-emerald-500 uppercase tracking-wide flex items-center gap-1">
                                        Selesai ✅
                                    </span>
                                @elseif($isCompleted)
                                    <span class="text-[10px] font-extrabold text-primary uppercase tracking-wide flex items-center gap-1">
                                        Siap Klaim 🎉
                                    </span>
                                @else
                                    <span class="text-[10px] font-extrabold text-muted-gray uppercase tracking-wide">
                                        Dalam Proses 🔒
                                    </span>
                                @endif
                            </div>
                            
                            <h4 class="text-base font-extrabold text-dark-navy mt-2">{{ $ch->title }}</h4>
                            <p class="text-xs text-muted-gray mt-1.5 leading-relaxed">
                                {{ $ch->description }}
                            </p>
                        </div>

                        <!-- Action Button -->
                        @if($isClaimed)
                            <button disabled class="w-full h-11 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-default">
                                Sudah Diklaim
                            </button>
                        @elseif($isCompleted)
                            <form method="POST" action="{{ route('challenges.claim', $ch->id) }}">
                                @csrf
                                <button type="submit" 
                                    class="w-full h-11 bg-primary hover:bg-primary-dark text-white font-bold text-xs rounded-xl transition-all shadow-md active:scale-95 duration-200 flex items-center justify-center gap-1">
                                    Klaim Hadiah Poin
                                </button>
                            </form>
                        @else
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                                <span class="text-[10px] text-muted-gray font-bold uppercase tracking-wider block">Syarat Misi</span>
                                <span class="text-[10px] font-bold text-dark-navy mt-0.5 block leading-relaxed">
                                    @if($ch->title === 'Pejuang Air Putih')
                                        Jangan catat minuman manis apa pun hari ini.
                                    @else
                                        Bebas minuman bersoda dalam 3 hari terakhir.
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
