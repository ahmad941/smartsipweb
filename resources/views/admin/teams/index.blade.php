<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Kelola Tim Peneliti Hibah
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editName: '', 
        editRole: '', 
        editInst: '', 
        editPhoto: '',
        openEdit(item) {
            this.editId = item.id;
            this.editName = item.name;
            this.editRole = item.role;
            this.editInst = item.institution || '';
            this.editPhoto = item.photo_url || '';
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
                
                <!-- Team List (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Daftar Tim Peneliti</h3>
                            <p class="text-slate-400 text-xs mt-1">Daftar anggota peneliti utama, pendamping, dan institusi pengusul hibah.</p>
                        </div>
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.teams.index') }}" class="relative sm:w-64">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / peran / institusi..."
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
                                    <th class="pb-3">Nama Peneliti</th>
                                    <th class="pb-3">Peran / Jabatan</th>
                                    <th class="pb-3">Institusi</th>
                                    <th class="pb-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($teams as $index => $t)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">
                                            {{ $teams->firstItem() + $index }}
                                        </td>
                                        <td class="py-4 font-bold text-slate-800">
                                            <div class="flex items-center gap-3">
                                                @if($t->photo_url)
                                                    <img src="{{ $t->photo_url }}" class="w-8 h-8 rounded-full object-cover bg-slate-100 border">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                                                        {{ substr($t->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span>{{ $t->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 font-semibold text-slate-600">
                                            {{ $t->role }}
                                        </td>
                                        <td class="py-4 text-slate-500">
                                            {{ $t->institution ?? '-' }}
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openEdit({{ json_encode($t) }})" class="px-2.5 py-1.5 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.teams.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus peneliti ini?')">
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
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-bold italic">Belum ada data tim peneliti.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        {{ $teams->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Form Tambah Peneliti (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Tambah Anggota Peneliti</h3>
                    <form action="{{ route('admin.teams.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap & Gelar *</label>
                            <input type="text" id="name" name="name" required placeholder="Cth: Dr. Ahmad, M.Kes"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <div>
                            <label for="role" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Peran dalam Penelitian *</label>
                            <input type="text" id="role" name="role" required placeholder="Cth: Ketuap Peneliti / Anggota"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <div>
                            <label for="institution" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Institusi / Universitas</label>
                            <input type="text" id="institution" name="institution" placeholder="Cth: Universitas Singaperbangsa"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <div>
                            <label for="photo_url" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">URL Foto (Opsional)</label>
                            <input type="text" id="photo_url" name="photo_url" placeholder="/images/team/ahmad.jpg"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <button type="submit" class="w-full mt-2 h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Peneliti
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Alpine Edit Modal Overlay -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Data Peneliti</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/teams') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap & Gelar *</label>
                        <input type="text" name="name" required x-model="editName" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Peran dalam Penelitian *</label>
                        <input type="text" name="role" required x-model="editRole" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Institusi</label>
                        <input type="text" name="institution" x-model="editInst" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">URL Foto</label>
                        <input type="text" name="photo_url" x-model="editPhoto" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
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
