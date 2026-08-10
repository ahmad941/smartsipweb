<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Kelola Instrumen Riset & Gamifikasi
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        activeTab: 'questions',
        
        // Modal edit state for Question
        editQOpen: false,
        editQId: null,
        editQConstruct: '',
        editQText: '',
        editQActive: 1,

        openEditQ(q) {
            this.editQId = q.id;
            this.editQConstruct = q.construct_type;
            this.editQText = q.question_text;
            this.editQActive = q.is_active;
            this.editQOpen = true;
        },

        // Modal edit state for Challenge
        editCOpen: false,
        editCId: null,
        editCTitle: '',
        editCDesc: '',
        editCReward: 0,
        editCActive: 1,

        openEditC(c) {
            this.editCId = c.id;
            this.editCTitle = c.title;
            this.editCDesc = c.description || '';
            this.editCReward = c.reward_points;
            this.editCActive = c.is_active;
            this.editCOpen = true;
        }
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-6">

            <!-- Alerts -->
            @if (session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-bold flex items-start gap-2 shadow-sm">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs font-bold flex items-start gap-2 shadow-sm">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Search Bar Above Tabs -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
                <span class="text-xs font-bold text-slate-500">Kelola Instrumen Evaluasi & Misi Riset SmartSip</span>
                <form method="GET" action="{{ route('admin.instruments.index') }}" class="relative w-full sm:w-72">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari soal / tantangan..."
                        class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-10 pl-9 pr-4 w-full focus:outline-none transition-all text-xs" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex gap-6 border-b border-slate-250 pb-px mb-6">
                <button @click="activeTab = 'questions'" :class="activeTab === 'questions' ? 'border-purple-500 text-purple-600 font-extrabold' : 'border-transparent text-slate-450 hover:text-slate-700'" class="pb-3.5 px-2 border-b-2 text-xs font-bold transition-all flex items-center gap-1.5 focus:outline-none">
                    📋 Soal Kuesioner TPB
                </button>
                <button @click="activeTab = 'challenges'" :class="activeTab === 'challenges' ? 'border-purple-500 text-purple-600 font-extrabold' : 'border-transparent text-slate-450 hover:text-slate-700'" class="pb-3.5 px-2 border-b-2 text-xs font-bold transition-all flex items-center gap-1.5 focus:outline-none">
                    🎯 Tantangan Gamifikasi
                </button>
            </div>

            <!-- Tab Content 1: TPB Questions -->
            <div x-show="activeTab === 'questions'" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- List -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Butir Pertanyaan Kuesioner TPB</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-extrabold text-[10px]">
                                    <th class="pb-3 w-10 text-center">No</th>
                                    <th class="pb-3 w-36">Aspek TPB</th>
                                    <th class="pb-3">Pertanyaan</th>
                                    <th class="pb-3 w-16 text-center">Status</th>
                                    <th class="pb-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($questions as $index => $q)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">{{ $index + 1 }}</td>
                                        <td class="py-4">
                                            <span class="px-2.5 py-1 text-[9px] font-extrabold rounded-full border
                                                @if($q->construct_type === 'attitude') bg-sky-50 border-sky-200 text-sky-600
                                                @elseif($q->construct_type === 'subjective_norm') bg-emerald-50 border-emerald-200 text-emerald-600
                                                @elseif($q->construct_type === 'pbc') bg-amber-50 border-amber-200 text-amber-600
                                                @else bg-purple-50 border-purple-200 text-purple-600 @endif">
                                                @if($q->construct_type === 'attitude') Attitude (Sikap)
                                                @elseif($q->construct_type === 'subjective_norm') Subjective Norm
                                                @elseif($q->construct_type === 'pbc') PBC (Kontrol)
                                                @else Intention (Niat) @endif
                                            </span>
                                        </td>
                                        <td class="py-4 text-slate-700 leading-relaxed font-semibold">
                                            {{ $q->question_text }}
                                        </td>
                                        <td class="py-4 text-center">
                                            @if ($q->is_active)
                                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block" title="Aktif"></span>
                                            @else
                                                <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block" title="Nonaktif"></span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openEditQ({{ json_encode($q) }})" class="px-2 py-1 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.instruments.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan kuesioner ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-100 hover:border-rose-600 rounded-lg text-[10px] font-bold transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-bold italic">Belum ada data pertanyaan TPB.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 border-t border-slate-100 pt-3">
                        {{ $questions->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Add Question Form -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Tambah Pertanyaan</h3>
                    <form action="{{ route('admin.instruments.questions.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Aspek / Konstruk TPB *</label>
                            <div class="relative">
                                <select name="construct_type" required 
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                    <option value="attitude">Attitude (Sikap terhadap Perilaku)</option>
                                    <option value="subjective_norm">Subjective Norm (Norma Subjektif/Sosial)</option>
                                    <option value="pbc">Perceived Behavioral Control (Kontrol Diri)</option>
                                    <option value="intention">Intention (Niat Mengurangi Gula)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Teks Pertanyaan *</label>
                            <textarea name="question_text" required placeholder="Cth: Saya berniat membatasi minum soda dalam seminggu ke depan." rows="4"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white py-3 px-4 w-full focus:outline-none transition-all text-xs resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Keaktifan *</label>
                            <div class="relative">
                                <select name="is_active" required 
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                    <option value="1">Aktif (Ditampilkan ke Siswa)</option>
                                    <option value="0">Nonaktif (Disembunyikan)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Pertanyaan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tab Content 2: Challenges -->
            <div x-show="activeTab === 'challenges'" class="grid grid-cols-1 lg:grid-cols-12 gap-8" style="display: none;">
                <!-- List -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Daftar Tantangan / Misi Gamifikasi</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-extrabold text-[10px]">
                                    <th class="pb-3 w-10 text-center">No</th>
                                    <th class="pb-3 w-40">Nama Misi</th>
                                    <th class="pb-3">Syarat & Ketentuan</th>
                                    <th class="pb-3 text-right w-28">Poin Pemenang</th>
                                    <th class="pb-3 w-16 text-center">Status</th>
                                    <th class="pb-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($challenges as $index => $c)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">{{ $index + 1 }}</td>
                                        <td class="py-4 font-bold text-slate-800">{{ $c->title }}</td>
                                        <td class="py-4 text-slate-500 leading-normal">{{ $c->description ?? '-' }}</td>
                                        <td class="py-4 text-right text-emerald-600 font-extrabold text-sm">+{{ $c->reward_points }} Poin</td>
                                        <td class="py-4 text-center">
                                            @if ($c->is_active)
                                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block" title="Aktif"></span>
                                            @else
                                                <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block" title="Nonaktif"></span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openEditC({{ json_encode($c) }})" class="px-2 py-1 bg-purple-55 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.instruments.challenges.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tantangan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-100 hover:border-rose-600 rounded-lg text-[10px] font-bold transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-slate-400 font-bold italic">Belum ada data tantangan gamifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 border-t border-slate-100 pt-3">
                        {{ $challenges->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Add Challenge Form -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Tambah Tantangan</h3>
                    <form action="{{ route('admin.instruments.challenges.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Misi / Judul *</label>
                            <input type="text" name="title" required placeholder="Cth: Pejuang Air Putih"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Syarat & Keterangan</label>
                            <textarea name="description" placeholder="Cth: Mengurangi minuman manis dan hanya meminum air putih selama 1 hari penuh." rows="3"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white py-3 px-4 w-full focus:outline-none transition-all text-xs resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Reward Poin *</label>
                            <input type="number" name="reward_points" required placeholder="Cth: 20" min="1"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Keaktifan *</label>
                            <div class="relative">
                                <select name="is_active" required 
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Tantangan
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Alpine Edit Modal: Question -->
        <div x-show="editQOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editQOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Pertanyaan TPB</h4>
                    <button @click="editQOpen = false" class="text-slate-400 hover:text-slate-655">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/instruments/questions') }}' + '/' + editQId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Aspek / Konstruk TPB *</label>
                        <div class="relative">
                            <select name="construct_type" required x-model="editQConstruct"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                <option value="attitude">Attitude (Sikap)</option>
                                <option value="subjective_norm">Subjective Norm (Sosial)</option>
                                <option value="pbc">PBC (Kontrol Diri)</option>
                                <option value="intention">Intention (Niat)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Teks Pertanyaan *</label>
                        <textarea name="question_text" required x-model="editQText" rows="4"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white py-3 px-4 w-full focus:outline-none transition-all text-xs resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Keaktifan *</label>
                        <div class="relative">
                            <select name="is_active" required x-model="editQActive"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                        <button type="button" @click="editQOpen = false" class="h-11 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all text-xs">
                            Batal
                        </button>
                        <button type="submit" class="h-11 px-5 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl transition-all text-xs">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alpine Edit Modal: Challenge -->
        <div x-show="editCOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editCOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Tantangan Gamifikasi</h4>
                    <button @click="editCOpen = false" class="text-slate-400 hover:text-slate-655">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/instruments/challenges') }}' + '/' + editCId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Misi / Judul *</label>
                        <input type="text" name="title" required x-model="editCTitle"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Syarat & Keterangan</label>
                        <textarea name="description" x-model="editCDesc" rows="3"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white py-3 px-4 w-full focus:outline-none transition-all text-xs resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Reward Poin *</label>
                        <input type="number" name="reward_points" required x-model="editCReward" min="1"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Keaktifan *</label>
                        <div class="relative">
                            <select name="is_active" required x-model="editCActive"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                        <button type="button" @click="editCOpen = false" class="h-11 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all text-xs">
                            Batal
                        </button>
                        <button type="submit" class="h-11 px-5 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl transition-all text-xs">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
