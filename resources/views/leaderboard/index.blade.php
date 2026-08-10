<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <span class="text-xs font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-lg">Peringkat</span>
    </x-slot>

    <!-- Main Content -->
    <div class="p-6 space-y-6" x-data="{ activeTab: 'class' }">
        
        <div class="text-center">
            <span class="text-3xl">📊</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Papan Peringkat</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Peringkat dihitung berdasarkan total poin yang dikumpulkan dari misi dan kuis.
            </p>
        </div>

        <!-- Position overview card -->
        <div class="bg-gradient-to-r from-primary to-indigo-600 rounded-[24px] p-5 text-white shadow-premium relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full pointer-events-none"></div>
            
            <div class="flex justify-between items-center relative z-10">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-200">Posisi Kamu</span>
                    <h4 class="text-base font-extrabold mt-1">{{ $student->nickname ?? 'Z-Warrior' }}</h4>
                </div>
                <div class="flex gap-6 text-center">
                    <div>
                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-200 block">Kelas</span>
                        <span class="text-xl font-extrabold mt-0.5 block">#{{ $activeUserClassRank }}</span>
                    </div>
                    <div class="border-l border-white/20 pl-6">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-200 block">Global</span>
                        <span class="text-xl font-extrabold mt-0.5 block">#{{ $activeUserGlobalRank }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab headers -->
        <div class="bg-white p-1 rounded-2xl border border-slate-100 shadow-premium flex">
            <button @click="activeTab = 'class'" :class="activeTab === 'class' ? 'bg-primary text-white font-bold' : 'text-muted-gray'"
                class="flex-1 text-center py-3 rounded-xl text-xs font-semibold transition-all focus:outline-none">
                🏫 Kelas
            </button>
            <button @click="activeTab = 'global'" :class="activeTab === 'global' ? 'bg-primary text-white font-bold' : 'text-muted-gray'"
                class="flex-1 text-center py-3 rounded-xl text-xs font-semibold transition-all focus:outline-none">
                🌍 Global
            </button>
        </div>

        <!-- Tab Content: Class Leaderboard -->
        <div x-show="activeTab === 'class'" class="space-y-3">
            <div class="px-1">
                <span class="text-[10px] font-extrabold text-muted-gray uppercase tracking-widest">
                    Peringkat Kelas {{ $student->schoolClass->name ?? '' }}
                </span>
            </div>
            
            <div class="space-y-2.5">
                @forelse($classUsers as $index => $u)
                    <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-premium flex items-center justify-between
                        {{ Auth::id() === $u->id ? 'bg-primary/5 border-primary/20' : '' }}">
                        
                        <div class="flex items-center gap-3">
                            <!-- Rank Circle -->
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-extrabold shrink-0
                                {{ $index === 0 ? 'bg-amber-100 text-amber-600' : ($index === 1 ? 'bg-slate-100 text-slate-600' : ($index === 2 ? 'bg-orange-100 text-orange-600' : 'bg-slate-50 text-muted-gray')) }}">
                                @if($index === 0) 🥇
                                @elseif($index === 1) 🥈
                                @elseif($index === 2) 🥉
                                @else {{ $index + 1 }} @endif
                            </div>
                            
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-sm text-dark-navy">{{ $u->student->nickname }}</span>
                                    @if(Auth::id() === $u->id)
                                        <span class="px-1.5 py-0.5 bg-primary/10 text-primary border border-primary/20 text-[8px] font-bold rounded">KAMU</span>
                                    @endif
                                </div>
                                <span class="block text-[10px] text-muted-gray mt-0.5">{{ $u->student->school->name }}</span>
                            </div>
                        </div>

                        <span class="font-extrabold text-sm text-primary font-mono shrink-0">
                            {{ number_format($u->total_points ?? 0) }} <span class="text-[9px] font-semibold text-muted-gray">PTS</span>
                        </span>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-premium text-center">
                        <span class="text-slate-400 text-xs">Belum ada data peringkat kelas.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Content: Global Leaderboard -->
        <div x-show="activeTab === 'global'" class="space-y-3" style="display: none;">
            <div class="px-1">
                <span class="text-[10px] font-extrabold text-muted-gray uppercase tracking-widest">
                    Peringkat Semua Sekolah
                </span>
            </div>

            <div class="space-y-2.5">
                @forelse($globalUsers as $index => $u)
                    <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-premium flex items-center justify-between
                        {{ Auth::id() === $u->id ? 'bg-primary/5 border-primary/20' : '' }}">
                        
                        <div class="flex items-center gap-3">
                            <!-- Rank Circle -->
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-extrabold shrink-0
                                {{ $index === 0 ? 'bg-amber-100 text-amber-600' : ($index === 1 ? 'bg-slate-100 text-slate-600' : ($index === 2 ? 'bg-orange-100 text-orange-600' : 'bg-slate-50 text-muted-gray')) }}">
                                @if($index === 0) 🥇
                                @elseif($index === 1) 🥈
                                @elseif($index === 2) 🥉
                                @else {{ $index + 1 }} @endif
                            </div>
                            
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-sm text-dark-navy">{{ $u->student->nickname }}</span>
                                    @if(Auth::id() === $u->id)
                                        <span class="px-1.5 py-0.5 bg-primary/10 text-primary border border-primary/20 text-[8px] font-bold rounded">KAMU</span>
                                    @endif
                                </div>
                                <span class="block text-[10px] text-muted-gray mt-0.5">{{ $u->student->school->name }} ({{ $u->student->schoolClass->name }})</span>
                            </div>
                        </div>

                        <span class="font-extrabold text-sm text-primary font-mono shrink-0">
                            {{ number_format($u->total_points ?? 0) }} <span class="text-[9px] font-semibold text-muted-gray">PTS</span>
                        </span>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-premium text-center">
                        <span class="text-slate-400 text-xs">Belum ada data peringkat global.</span>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
