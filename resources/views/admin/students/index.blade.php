<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengelolaan</span>
            <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                Data Profil & Antropometri Siswa Responden
            </h2>
        </div>
    </x-slot>

    <div class="py-8 text-slate-700" x-data="{ 
        editOpen: false, 
        editId: null, 
        editNickname: '', 
        editSchoolId: '',
        editClassId: '',
        editGender: 'L',
        editDob: '',
        editHeight: '',
        editWeight: '',
        editBodyFat: '',
        editPocketMoney: '',
        editFatherEdu: '',
        editMotherEdu: '',
        openEdit(student) {
            this.editId = student.id;
            this.editNickname = student.nickname;
            this.editSchoolId = student.school_id;
            this.editClassId = student.class_id;
            this.editGender = student.gender;
            this.editDob = student.date_of_birth;
            this.editHeight = student.height_cm;
            this.editWeight = student.weight_kg;
            this.editBodyFat = student.body_fat_percentage || '';
            this.editPocketMoney = student.pocket_money || '';
            this.editFatherEdu = student.father_education || '';
            this.editMotherEdu = student.mother_education || '';
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

            <!-- Ringkasan Statistik Siswa -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Responden</span>
                    <span class="text-2xl font-black text-slate-800 mt-1 block">{{ $students->total() }}</span>
                </div>
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                    <span class="text-[10px] font-extrabold text-indigo-400 uppercase tracking-wider block">Siswa Laki-Laki</span>
                    <span class="text-2xl font-black text-indigo-600 mt-1 block">{{ $students->where('gender', 'L')->count() }}</span>
                </div>
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                    <span class="text-[10px] font-extrabold text-rose-400 uppercase tracking-wider block">Siswa Perempuan</span>
                    <span class="text-2xl font-black text-rose-600 mt-1 block">{{ $students->where('gender', 'P')->count() }}</span>
                </div>
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                    <span class="text-[10px] font-extrabold text-emerald-400 uppercase tracking-wider block">Rata-Rata IMT</span>
                    <span class="text-2xl font-black text-emerald-600 mt-1 block">
                        {{ number_format($students->avg('bmi_score') ?? 0, 1) }}
                    </span>
                </div>
            </div>

            <!-- Main Table Container -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">Daftar Data Antropometri & Demografi Siswa</h3>
                        <p class="text-slate-400 text-xs mt-1">Data rinci profil fisik, sekolah, kelas, serta faktor demografi siswa responden.</p>
                    </div>

                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.students.index') }}" class="flex flex-wrap items-center gap-2">
                        <!-- Sekolah Filter -->
                        <select name="school_id" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs h-10 px-3 font-bold">
                            <option value="">-- Semua Sekolah --</option>
                            @foreach($schools as $sch)
                                <option value="{{ $sch->id }}" {{ $schoolFilter == $sch->id ? 'selected' : '' }}>{{ $sch->name }}</option>
                            @endforeach
                        </select>

                        <!-- Gender Filter -->
                        <select name="gender" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-xs h-10 px-3 font-bold">
                            <option value="">Semua Gender</option>
                            <option value="L" {{ $genderFilter === 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                            <option value="P" {{ $genderFilter === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>

                        <!-- Search Box -->
                        <div class="relative w-48 sm:w-56">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / pseudonim..."
                                class="bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 h-10 pl-9 pr-4 w-full text-xs focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all" />
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
                                <th class="pb-3">Siswa & Pseudonim</th>
                                <th class="pb-3">Sekolah & Kelas</th>
                                <th class="pb-3 text-center">Gender / Usia</th>
                                <th class="pb-3 text-center">TB / BB</th>
                                <th class="pb-3 text-center">IMT & Kategori</th>
                                <th class="pb-3 text-center">Lemak Tubuh</th>
                                <th class="pb-3 text-center">Uang Saku</th>
                                <th class="pb-3 w-28 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($students as $index => $s)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 text-center text-slate-400 font-bold">
                                        {{ $students->firstItem() + $index }}
                                    </td>

                                    <!-- Nama & Pseudonim -->
                                    <td class="py-4 font-bold text-slate-800">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full {{ $s->gender === 'L' ? 'bg-indigo-50 text-indigo-600' : 'bg-rose-50 text-rose-600' }} font-black flex items-center justify-center text-xs">
                                                {{ substr($s->nickname ?? $s->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-extrabold text-slate-800">{{ $s->nickname }}</div>
                                                <div class="text-[10px] text-slate-400 font-normal">{{ $s->user->name ?? '-' }} ({{ $s->user->email ?? '-' }})</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Sekolah & Kelas -->
                                    <td class="py-4">
                                        <span class="font-extrabold text-slate-700 block">{{ $s->school->name ?? '-' }}</span>
                                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md inline-block mt-0.5">
                                            {{ $s->schoolClass->name ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- Gender & Usia -->
                                    <td class="py-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $s->gender === 'L' ? 'bg-indigo-100 text-indigo-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $s->gender === 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                        </span>
                                        <div class="text-[10px] text-slate-400 font-medium mt-1">
                                            {{ $s->age }} thn ({{ \Carbon\Carbon::parse($s->date_of_birth)->format('d/m/Y') }})
                                        </div>
                                    </td>

                                    <!-- TB / BB -->
                                    <td class="py-4 text-center">
                                        <div class="font-extrabold text-slate-800">{{ $s->height_cm }} cm</div>
                                        <div class="text-[10px] text-slate-500 font-semibold">{{ $s->weight_kg }} kg</div>
                                    </td>

                                    <!-- IMT & Status Kategori -->
                                    <td class="py-4 text-center">
                                        <div class="font-black text-sm text-slate-800">{{ $s->bmi_score }}</div>
                                        @php
                                            $bmi = $s->bmi_score;
                                            if ($bmi < 18.5) {
                                                $badgeClass = 'bg-amber-50 text-amber-600 border-amber-200';
                                                $statusText = 'Kurus';
                                            } elseif ($bmi <= 22.9) {
                                                $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                                $statusText = 'Normal';
                                            } elseif ($bmi <= 24.9) {
                                                $badgeClass = 'bg-orange-50 text-orange-600 border-orange-200';
                                                $statusText = 'Overweight';
                                            } else {
                                                $badgeClass = 'bg-rose-50 text-rose-600 border-rose-200';
                                                $statusText = 'Obesitas';
                                            }
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-md border text-[9px] font-extrabold uppercase mt-0.5 inline-block {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>

                                    <!-- Lemak Tubuh -->
                                    <td class="py-4 text-center font-bold text-slate-700">
                                        {{ $s->body_fat_percentage ? $s->body_fat_percentage . '%' : '-' }}
                                    </td>

                                    <!-- Uang Saku -->
                                    <td class="py-4 text-center font-bold text-slate-700">
                                        {{ $s->pocket_money ? 'Rp ' . number_format($s->pocket_money, 0, ',', '.') : '-' }}
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button @click="openEdit({{ json_encode($s) }})" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white border border-indigo-100 hover:border-indigo-600 rounded-lg text-[10px] font-bold transition-all">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.students.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus profil siswa {{ $s->nickname }}?')">
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
                                    <td colspan="9" class="py-12 text-center text-slate-400 font-bold italic">Belum ada data siswa responden terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 border-t border-slate-100 pt-4">
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>

        </div>

        <!-- Modal Edit Profil Siswa -->
        <div x-show="editOpen" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs" style="display: none;">
            <div @click.outside="editOpen = false" class="bg-white border border-slate-200 rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h4 class="text-base font-extrabold text-slate-800">Edit Profil & Antropometri Siswa</h4>
                    <button @click="editOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/admin/students') }}' + '/' + editId" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pseudonim / Nickname *</label>
                            <input type="text" name="nickname" required x-model="editNickname" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Jenis Kelamin *</label>
                            <select name="gender" required x-model="editGender" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold">
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Sekolah *</label>
                            <select name="school_id" required x-model="editSchoolId" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold">
                                @foreach($schools as $sch)
                                    <option value="{{ $sch->id }}">{{ $sch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Kelas *</label>
                            <select name="class_id" required x-model="editClassId" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold">
                                @foreach($classes as $cls)
                                    <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Tanggal Lahir *</label>
                            <input type="date" name="date_of_birth" required x-model="editDob" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Tinggi Badan (cm) *</label>
                            <input type="number" step="0.1" name="height_cm" required x-model="editHeight" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Berat Badan (kg) *</label>
                            <input type="number" step="0.1" name="weight_kg" required x-model="editWeight" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs font-bold" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Persentase Lemak Tubuh (%)</label>
                            <input type="number" step="0.1" name="body_fat_percentage" x-model="editBodyFat" placeholder="Contoh: 18.5" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Uang Saku Per Hari (Rp)</label>
                            <input type="number" name="pocket_money" x-model="editPocketMoney" placeholder="Contoh: 20000" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pendidikan Ayah</label>
                            <input type="text" name="father_education" x-model="editFatherEdu" placeholder="SMA / S1 / D3" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Pendidikan Ibu</label>
                            <input type="text" name="mother_education" x-model="editMotherEdu" placeholder="SMA / S1 / D3" class="bg-slate-50 border border-slate-200 rounded-xl text-slate-850 h-10 px-3 w-full text-xs" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                        <button type="button" @click="editOpen = false" class="h-10 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">Batal</button>
                        <button type="submit" class="h-10 px-5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
