<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Kelola Master Minuman Manis
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editName: '', 
        editCategoryId: '', 
        editSugar: '', 
        editImageUrl: '',
        openEdit(bev) {
            this.editId = bev.id;
            this.editName = bev.name;
            this.editCategoryId = bev.category_id;
            this.editSugar = bev.sugar_per_100ml;
            this.editImageUrl = bev.image_url || '';
            this.editOpen = true;
        }
    }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-6">

            <!-- Alert Notifications -->
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
                
                <!-- Beverage List (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Daftar Minuman Manis</h3>
                            <p class="text-slate-400 text-xs mt-1">Daftar takaran gula minuman kemasan populer untuk simulasi kognitif siswa.</p>
                        </div>
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('beverages.index') }}" class="relative sm:w-64">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari minuman / kategori..."
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
                                    <th class="pb-3 min-w-[160px]">Nama Minuman</th>
                                    <th class="pb-3 min-w-[190px]">Kategori</th>
                                    <th class="pb-3 text-right min-w-[130px]">Gula (per 100ml)</th>
                                    <th class="pb-3 text-center w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($beverages as $index => $bev)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">
                                            {{ $beverages->firstItem() + $index }}
                                        </td>
                                        <td class="py-4 font-bold text-slate-800">
                                            <div class="flex items-center gap-3">
                                                @if ($bev->image_url)
                                                    <img src="{{ $bev->image_url }}" alt="{{ $bev->name }}" class="w-8 h-8 rounded-lg object-cover bg-slate-100 border border-slate-200">
                                                @else
                                                    <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-base">🥤</div>
                                                @endif
                                                <span>{{ $bev->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-block whitespace-nowrap px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full font-bold text-[11px] border border-slate-200">
                                                {{ $bev->category->name }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-right text-rose-500 font-extrabold text-sm whitespace-nowrap">
                                            {{ $bev->sugar_per_100ml }} gram
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openEdit({{ json_encode($bev) }})" class="px-2.5 py-1.5 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                <form action="{{ route('beverages.destroy', $bev->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus minuman ini?')">
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
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-bold italic">
                                            Belum ada data minuman manis terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        {{ $beverages->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Add Beverage Form (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-5">Tambah Minuman Baru</h3>

                    <form action="{{ route('beverages.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Minuman *</label>
                            <input type="text" id="name" name="name" required placeholder="Cth: Sprite Kaleng 330ml"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                            @error('name') <p class="text-rose-500 text-2xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Kategori Minuman *</label>
                            <div class="relative">
                                <select id="category_id" name="category_id" required 
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                    <option value="" disabled selected class="text-slate-400">-- Pilih Kategori --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('category_id') <p class="text-rose-500 text-2xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="sugar_per_100ml" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Kadar Gula (gram / 100ml) *</label>
                            <div class="relative">
                                <input type="number" step="0.01" id="sugar_per_100ml" name="sugar_per_100ml" required placeholder="Cth: 10.6"
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 pl-4 pr-12 w-full focus:outline-none transition-all text-xs" />
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-2xs font-extrabold">g / 100ml</div>
                            </div>
                            @error('sugar_per_100ml') <p class="text-rose-500 text-2xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="image_url" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">URL Gambar (Opsional)</label>
                            <input type="text" id="image_url" name="image_url" placeholder="/images/beverages/sprite.png"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                            @error('image_url') <p class="text-rose-500 text-2xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full mt-2 h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Tambah Minuman
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Alpine Edit Modal Overlay -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Data Minuman</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/beverages') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Minuman *</label>
                        <input type="text" name="name" required x-model="editName"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Kategori Minuman *</label>
                        <div class="relative">
                            <select name="category_id" required x-model="editCategoryId"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all appearance-none cursor-pointer text-xs">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Kadar Gula (gram / 100ml) *</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="sugar_per_100ml" required x-model="editSugar"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 pl-4 pr-12 w-full focus:outline-none transition-all text-xs" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-2xs font-extrabold">g / 100ml</div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">URL Gambar (Opsional)</label>
                        <input type="text" name="image_url" x-model="editImageUrl"
                            class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-11 px-4 w-full focus:outline-none transition-all text-xs" />
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
