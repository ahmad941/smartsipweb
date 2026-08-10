<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Kelola Sekolah & Kelas Mitra
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editName: '', 
        editGroupType: '',
        openEdit(school) {
            this.editId = school.id;
            this.editName = school.name;
            this.editGroupType = school.group_type;
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

            @if (session('error'))
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs font-bold flex items-start gap-2 shadow-sm">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- School Cards Grid (Col 8) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Sekolah Mitra Terdaftar</h3>
                            <p class="text-slate-400 text-xs mt-1">Daftar sekolah mitra riset lapangan beserta pembagian kelas belajar.</p>
                        </div>
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('schools.index') }}" class="relative sm:w-64">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari sekolah / kelompok..."
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-10 pl-9 pr-4 w-full focus:outline-none transition-all text-xs" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($schools as $school)
                            <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between shadow-sm space-y-5">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-start gap-2">
                                        <h4 class="text-sm font-extrabold text-slate-800 leading-snug">{{ $school->name }}</h4>
                                        <span class="px-2.5 py-1 text-[9px] font-extrabold rounded-full border shrink-0
                                            {{ $school->group_type === 'intervensi' ? 'bg-purple-50 border-purple-200 text-purple-600' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                                            {{ strtoupper($school->group_type) }}
                                        </span>
                                    </div>
                                    
                                    <!-- Classes List -->
                                    <div class="space-y-2.5">
                                        <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Daftar Kelas</span>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($school->schoolClasses as $class)
                                                <div class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-full pl-3 pr-1.5 py-1 text-2xs font-bold border border-slate-200 transition-colors">
                                                    <span>{{ $class->name }}</span>
                                                    <form action="{{ route('schools.classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Hapus kelas {{ $class->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-4 h-4 rounded-full bg-white hover:bg-rose-500 hover:text-white flex items-center justify-center text-slate-400 border border-slate-200 hover:border-rose-500 transition-all font-bold">
                                                            &times;
                                                        </button>
                                                    </form>
                                                </div>
                                            @empty
                                                <span class="text-xs text-slate-400 font-bold italic">Belum ada kelas belajar.</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- Class Inline Creator & Action Controls -->
                                <div class="pt-4 border-t border-slate-100 space-y-4">
                                    <!-- Inline Add Class Form -->
                                    <form action="{{ route('schools.classes.store', $school->id) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="text" name="name" required placeholder="Cth: X-IPA 2"
                                            class="flex-1 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-450 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-9 px-3 focus:outline-none transition-all text-2xs" />
                                        <button type="submit" class="h-9 px-3 bg-slate-50 hover:bg-purple-600 border border-slate-200 hover:border-purple-600 text-slate-600 hover:text-white text-2xs font-extrabold rounded-xl transition-all flex items-center gap-1">
                                            <span>+ Kelas</span>
                                        </button>
                                    </form>

                                     <!-- School Controls -->
                                     <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                         <button @click="openEdit({{ json_encode($school) }})" class="px-3 py-1.5 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                             Edit Sekolah
                                         </button>
                                         
                                         <form action="{{ route('schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Hapus sekolah {{ $school->name }} beserta seluruh kelas di dalamnya?')">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-100 hover:border-rose-600 rounded-lg text-[10px] font-bold transition-all">
                                                 Hapus Sekolah
                                             </button>
                                         </form>
                                     </div>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-12 text-center text-slate-400 font-bold italic shadow-sm">
                                Belum ada data sekolah terdaftar.
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        {{ $schools->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Add School Form (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-5">Tambah Sekolah Baru</h3>

                    <form action="{{ route('schools.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Sekolah *</label>
                            <input type="text" id="name" name="name" required placeholder="Cth: SMAN 1 Karawang"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                            @error('name') <p class="text-rose-500 text-2xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="group_type" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Tipe Kelompok Penelitian *</label>
                            <div class="relative">
                                <select id="group_type" name="group_type" required 
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                    <option value="" disabled selected class="text-slate-450">-- Pilih Kelompok --</option>
                                    <option value="intervensi">Intervensi (Menggunakan App)</option>
                                    <option value="kontrol">Kontrol (Edukasi Standar)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('group_type') <p class="text-rose-500 text-2xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full mt-2 h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Sekolah
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Alpine Edit Modal Overlay -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Data Sekolah</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/schools') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Sekolah *</label>
                        <input type="text" name="name" required x-model="editName"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Tipe Kelompok Penelitian *</label>
                        <div class="relative">
                            <select name="group_type" required x-model="editGroupType"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                <option value="intervensi">Intervensi</option>
                                <option value="kontrol">Kontrol</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                        <button type="button" @click="editOpen = false" class="h-11 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all text-xs">
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
