<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Kelola Soal Pengetahuan Gula
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editQText: '', 
        editOptA: '', 
        editOptB: '', 
        editOptC: '', 
        editOptD: '', 
        editCorrect: 'A',
        editActive: 1,
        openEdit(item) {
            this.editId = item.id;
            this.editQText = item.question_text;
            this.editOptA = item.options.A || '';
            this.editOptB = item.options.B || '';
            this.editOptC = item.options.C || '';
            this.editOptD = item.options.D || '';
            this.editCorrect = item.correct_option;
            this.editActive = item.is_active ? 1 : 0;
            this.editOpen = true;
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Knowledge List (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Daftar Soal Pengetahuan Gula</h3>
                            <p class="text-slate-400 text-xs mt-1">Instrumen 10 Soal Pilihan Ganda Pengetahuan Konsumsi Gula Responden.</p>
                        </div>
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.knowledge.index') }}" class="relative sm:w-64">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pertanyaan..."
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-10 pl-9 pr-4 w-full focus:outline-none transition-all text-xs" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-extrabold text-[10px]">
                                    <th class="pb-3 w-10 text-center">No</th>
                                    <th class="pb-3">Pertanyaan</th>
                                    <th class="pb-3 w-20 text-center">Kunci</th>
                                    <th class="pb-3 w-16 text-center">Status</th>
                                    <th class="pb-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($questions as $index => $q)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">
                                            {{ $questions->firstItem() + $index }}
                                        </td>
                                        <td class="py-4 font-bold text-slate-800">
                                            <div>{{ $q->question_text }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal mt-1 flex flex-wrap gap-2">
                                                <span>A: {{ $q->options['A'] ?? '-' }}</span> |
                                                <span>B: {{ $q->options['B'] ?? '-' }}</span> |
                                                <span>C: {{ $q->options['C'] ?? '-' }}</span> |
                                                <span>D: {{ $q->options['D'] ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center font-extrabold text-indigo-600 bg-indigo-50/50 rounded-lg">
                                            {{ $q->correct_option }}
                                        </td>
                                        <td class="py-4 text-center">
                                            @if($q->is_active)
                                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block" title="Aktif"></span>
                                            @else
                                                <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block" title="Nonaktif"></span>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openEdit({{ json_encode($q) }})" class="px-2.5 py-1.5 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.knowledge.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus soal pengetahuan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-100 hover:border-rose-600 rounded-lg text-[10px] font-bold transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-bold italic">Belum ada soal pengetahuan gula.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        {{ $questions->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Form Tambah Soal (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Tambah Soal Baru</h3>
                    <form action="{{ route('admin.knowledge.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="question_text" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Teks Pertanyaan *</label>
                            <textarea id="question_text" name="question_text" rows="3" required placeholder="Tuliskan pertanyaan..."
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 p-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white"></textarea>
                        </div>

                        <div>
                            <label for="option_a" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Pilihan A *</label>
                            <input type="text" id="option_a" name="option_a" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-4 w-full text-xs" />
                        </div>

                        <div>
                            <label for="option_b" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Pilihan B *</label>
                            <input type="text" id="option_b" name="option_b" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-4 w-full text-xs" />
                        </div>

                        <div>
                            <label for="option_c" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Pilihan C *</label>
                            <input type="text" id="option_c" name="option_c" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-4 w-full text-xs" />
                        </div>

                        <div>
                            <label for="option_d" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Pilihan D *</label>
                            <input type="text" id="option_d" name="option_d" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-4 w-full text-xs" />
                        </div>

                        <div>
                            <label for="correct_option" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Kunci Jawaban Benar *</label>
                            <select id="correct_option" name="correct_option" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs font-bold">
                                <option value="A">Opsi A</option>
                                <option value="B">Opsi B</option>
                                <option value="C">Opsi C</option>
                                <option value="D">Opsi D</option>
                            </select>
                        </div>

                        <div>
                            <label for="is_active" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Soal *</label>
                            <select id="is_active" name="is_active" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full mt-2 h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Soal
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Alpine Edit Modal Overlay -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Soal Pengetahuan</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/knowledge-questions') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Teks Pertanyaan *</label>
                        <textarea name="question_text" rows="3" required x-model="editQText" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 p-4 w-full text-xs"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pilihan A *</label>
                            <input type="text" name="option_a" required x-model="editOptA" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pilihan B *</label>
                            <input type="text" name="option_b" required x-model="editOptB" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pilihan C *</label>
                            <input type="text" name="option_c" required x-model="editOptC" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pilihan D *</label>
                            <input type="text" name="option_d" required x-model="editOptD" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Kunci Jawaban Benar *</label>
                        <select name="correct_option" required x-model="editCorrect" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs font-bold">
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Soal *</label>
                        <select name="is_active" required x-model="editActive" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                        <button type="button" @click="editOpen = false" class="h-11 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">Batal</button>
                        <button type="submit" class="h-11 px-5 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
