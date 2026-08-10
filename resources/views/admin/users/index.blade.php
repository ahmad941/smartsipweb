<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Manajemen Akun Pengguna & Responden
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editName: '', 
        editEmail: '', 
        editRole: 'siswa',
        editSchoolId: '',
        openEdit(user) {
            this.editId = user.id;
            this.editName = user.name;
            this.editEmail = user.email;
            this.editRole = user.role;
            this.editSchoolId = user.school_id || '';
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
                
                <!-- Users List (Col 8) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800">Daftar Akun Terdaftar</h3>
                            <p class="text-slate-400 text-xs mt-1">Pengelolaan seluruh akun Siswa Responden, Guru Pemantau, dan Admin.</p>
                        </div>
                        
                        <!-- Search & Role Filter Form -->
                        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-2 sm:w-auto">
                            <select name="role" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 text-xs focus:ring-purple-500/20">
                                <option value="">Semua Role</option>
                                <option value="siswa" {{ ($roleFilter ?? '') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ ($roleFilter ?? '') === 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="admin" {{ ($roleFilter ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>

                            <div class="relative sm:w-56">
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / email..."
                                    class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 placeholder-slate-400 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white h-10 pl-9 pr-4 w-full focus:outline-none transition-all text-xs" />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-extrabold text-[10px]">
                                    <th class="pb-3 w-10 text-center">No</th>
                                    <th class="pb-3">Pengguna / Email</th>
                                    <th class="pb-3 w-24 text-center">Role</th>
                                    <th class="pb-3 w-40">Sekolah Mitra</th>
                                    <th class="pb-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($users as $index => $u)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 text-center text-slate-400 font-bold">
                                            {{ $users->firstItem() + $index }}
                                        </td>
                                        <td class="py-4 font-bold text-slate-800">
                                            <div>{{ $u->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal mt-0.5">{{ $u->email }}</div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <span class="px-2.5 py-1 text-[9px] font-extrabold rounded-full border uppercase
                                                @if($u->role === 'admin') bg-rose-50 border-rose-200 text-rose-600
                                                @elseif($u->role === 'guru') bg-emerald-50 border-emerald-200 text-emerald-600
                                                @else bg-purple-50 border-purple-200 text-purple-600 @endif">
                                                {{ $u->role }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-slate-600">
                                            @if($u->school)
                                                <span class="font-bold text-slate-800">{{ $u->school->name }}</span>
                                                <span class="block text-[9px] text-emerald-600 font-extrabold">Guru UKS</span>
                                            @elseif($u->student && $u->student->school)
                                                <span class="font-bold text-slate-700">{{ $u->student->school->name }}</span>
                                                <span class="block text-[9px] text-slate-400">{{ $u->student->schoolClass->name ?? '-' }}</span>
                                            @else
                                                <span class="text-slate-300">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="openEdit({{ json_encode($u) }})" class="px-2.5 py-1.5 bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white border border-purple-100 hover:border-purple-600 rounded-lg text-[10px] font-bold transition-all">
                                                    Edit
                                                </button>
                                                @if($u->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna {{ $u->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-100 hover:border-rose-600 rounded-lg text-[10px] font-bold transition-all">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400 font-bold italic">Belum ada akun pengguna terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Form Tambah Akun (Col 4) -->
                <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4">Buat Akun Baru</h3>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Pengguna *</label>
                            <input type="text" id="name" name="name" required placeholder="Cth: Bapak Budi Guru"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <div>
                            <label for="email" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Alamat Email *</label>
                            <input type="email" id="email" name="email" required placeholder="budi@smartsip.id"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <div>
                            <label for="role" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Role Akses *</label>
                            <select id="role" name="role" required class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs font-bold">
                                <option value="siswa">Siswa Responden</option>
                                <option value="guru">Guru / Tim Pemantau</option>
                                <option value="admin">Admin Peneliti</option>
                            </select>
                        </div>

                        <div>
                            <label for="school_id" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Sekolah Mengajar (Khusus Guru)</label>
                            <select id="school_id" name="school_id" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs font-bold">
                                <option value="">-- Tanpa Sekolah / Semua --</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }} ({{ strtoupper($school->group_type) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="password" class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Password *</label>
                            <input type="password" id="password" name="password" required placeholder="Min 8 karakter"
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white" />
                        </div>

                        <button type="submit" class="w-full mt-2 h-11 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-all shadow-md active:scale-95 duration-200">
                            Buat Akun
                        </button>
                    </form>
                </div>

            </div>

        </div>

        <!-- Alpine Edit Modal Overlay -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Akun Pengguna</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/users') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Nama Pengguna *</label>
                        <input type="text" name="name" required x-model="editName" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Alamat Email *</label>
                        <input type="email" name="email" required x-model="editEmail" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Role Akses *</label>
                        <select name="role" required x-model="editRole" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs font-bold">
                            <option value="siswa">Siswa Responden</option>
                            <option value="guru">Guru / Tim Pemantau</option>
                            <option value="admin">Admin Peneliti</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Sekolah Mengajar (Khusus Guru)</label>
                        <select name="school_id" x-model="editSchoolId" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs font-bold">
                            <option value="">-- Tanpa Sekolah / Semua --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }} ({{ strtoupper($school->group_type) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2">Reset Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" placeholder="Password baru..." class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-11 px-4 w-full text-xs" />
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
