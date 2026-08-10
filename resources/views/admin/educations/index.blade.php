<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Kelola Materi Edukasi & Kuis
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editTitle: '', 
        editType: 'artikel', 
        editContent: '', 
        editMediaUrl: '',
        editPublished: 1,
        viewOpen: false,
        viewItem: null,
        openEdit(item) {
            this.editId = item.id;
            this.editTitle = item.title;
            this.editType = item.type;
            this.editContent = item.content;
            this.editMediaUrl = item.media_url || '';
            this.editPublished = item.is_published ? 1 : 0;
            this.editOpen = true;
        },
        openView(item) {
            this.viewItem = item;
            this.viewOpen = true;
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
                
                <!-- Education List (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Daftar Materi Edukasi</h3>
                            <p class="text-slate-400 text-xs mt-1">Artikel, Video Youtube Embed, dan Tips Praktis Pengurangan Gula.</p>
                        </div>
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.educations.index') }}" class="relative sm:w-64">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari materi..."
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
                                    <th class="pb-3 w-24">Tipe</th>
                                    <th class="pb-3">Judul Materi</th>
                                    <th class="pb-3 w-16 text-center">Status</th>
                                    <th class="pb-3 w-36 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($educations as $index => $edu)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">
                                            {{ $educations->firstItem() + $index }}
                                        </td>
                                        <td class="py-4">
                                            <span class="px-2.5 py-1 text-[9px] font-extrabold rounded-full border uppercase
                                                @if($edu->type === 'video') bg-rose-50 border-rose-200 text-rose-600
                                                @elseif($edu->type === 'artikel') bg-sky-50 border-sky-200 text-sky-600
                                                @else bg-emerald-50 border-emerald-200 text-emerald-600 @endif">
                                                {{ $edu->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 font-bold text-slate-800">
                                            <div>{{ $edu->title }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal line-clamp-1 mt-0.5">{{ Str::limit($edu->content, 60) }}</div>
                                        </td>
                                        <td class="py-4 text-center">
                                            @if($edu->is_published)
                                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block" title="Tayang"></span>
                                            @else
                                                <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block" title="Draft"></span>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('education.index') }}" target="_blank" title="Lihat Halaman Edukasi Siswa" class="px-2 py-1.5 bg-sky-50 hover:bg-sky-600 text-sky-600 hover:text-white border border-sky-200 hover:border-sky-600 rounded-lg text-[10px] font-bold transition-all flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </a>
                                                <button @click="openEdit({{ json_encode($edu) }})" class="px-2 py-1.5 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.educations.destroy', $edu->id) }}" method="POST" onsubmit="return confirm('Hapus materi edukasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-100 hover:border-rose-600 rounded-lg text-[10px] font-bold transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-bold italic">Belum ada materi edukasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        {{ $educations->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Form Tambah Edukasi (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Tambah Materi Baru</h3>
                    <form action="{{ route('admin.educations.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Judul Materi *</label>
                            <input type="text" id="title" name="title" required placeholder="Cth: Bahaya Gula Tersembunyi"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                        </div>

                        <div>
                            <label for="type" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Tipe Materi *</label>
                            <select id="type" name="type" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs">
                                <option value="artikel">Artikel</option>
                                <option value="video">Video (YouTube Embed)</option>
                                <option value="tips">Tips Praktis</option>
                            </select>
                        </div>

                        <div>
                            <label for="content" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Isi Konten *</label>
                            <textarea id="content" name="content" rows="4" required placeholder="Tuliskan materi edukasi..."
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 p-4 w-full focus:outline-none transition-all text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white"></textarea>
                        </div>

                        <div>
                            <label for="media_url" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Media URL (Link YouTube)</label>
                            <input type="text" id="media_url" name="media_url" placeholder="https://www.youtube.com/watch?v=... atau link embed"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                            <p class="text-[10px] text-slate-400 mt-1">Bisa tempel link biasa (watch?v=...), link pendek (youtu.be/...), atau link embed. Sistem otomatis menyesuaikannya.</p>
                        </div>

                        <div>
                            <label for="is_published" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Publikasi *</label>
                            <select id="is_published" name="is_published" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs">
                                <option value="1">Tayangkan (Publish)</option>
                                <option value="0">Simpan Draft</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full mt-2 h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Materi
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Alpine Edit Modal Overlay -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Materi Edukasi</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/educations') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Judul Materi *</label>
                        <input type="text" name="title" required x-model="editTitle" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Tipe Materi *</label>
                        <select name="type" required x-model="editType" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs">
                            <option value="artikel">Artikel</option>
                            <option value="video">Video (YouTube Embed)</option>
                            <option value="tips">Tips Praktis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Isi Konten *</label>
                        <textarea name="content" rows="4" required x-model="editContent" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 p-4 w-full text-xs"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Media URL (Link YouTube)</label>
                        <input type="text" name="media_url" x-model="editMediaUrl" placeholder="https://www.youtube.com/watch?v=... atau link embed" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                        <p class="text-[10px] text-slate-400 mt-1">Bisa tempel link biasa, link pendek, atau link embed.</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Status Publikasi *</label>
                        <select name="is_published" required x-model="editPublished" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs">
                            <option value="1">Tayangkan (Publish)</option>
                            <option value="0">Simpan Draft</option>
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
