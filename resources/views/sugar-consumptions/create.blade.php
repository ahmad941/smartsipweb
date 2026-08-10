<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
            <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
        </div>
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-primary px-3 py-1.5 bg-primary/10 rounded-full hover:bg-primary/20 transition-all">
            Kembali
        </a>
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

        @if (session('warning'))
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 text-xs font-bold leading-normal flex items-start gap-2 shadow-premium">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>{{ session('warning') }}</div>
            </div>
        @endif

        <div class="text-center">
            <span class="text-3xl">🥤</span>
            <h3 class="text-xl font-extrabold text-dark-navy mt-3">Catat Minuman</h3>
            <p class="text-xs text-muted-gray mt-1 leading-relaxed">
                Pilih minuman manis yang kamu konsumsi untuk melacak asupan gula harian.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-premium">
            <form method="POST" action="{{ route('sugar-consumptions.store') }}" class="space-y-5">
                @csrf
                
                <!-- Beverage -->
                <div>
                    <label for="beverage_id" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Pilih Minuman *</label>
                    <div class="relative">
                        <select id="beverage_id" name="beverage_id" required 
                            class="block w-full h-12 pl-4 pr-8 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-xs appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 cursor-pointer shadow-inner">
                            <option value="" disabled selected class="text-slate-400">-- Pilih Minuman Manis --</option>
                            @foreach($beverages->groupBy('category.name') as $categoryName => $beverageGroup)
                                <optgroup label="{{ $categoryName }}" class="bg-slate-100 text-primary font-bold text-xs">
                                    @foreach($beverageGroup as $beverage)
                                        <option value="{{ $beverage->id }}" class="text-dark-navy bg-white">
                                            {{ $beverage->name }} ({{ $beverage->sugar_per_100ml }}g gula / 100ml)
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('beverage_id')
                        <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Volume -->
                <div>
                    <label for="volume_ml" class="block text-xs font-extrabold text-muted-gray uppercase tracking-wider mb-2">Volume Minuman (ml) *</label>
                    <div class="relative">
                        <input type="number" id="volume_ml" name="volume_ml" min="1" placeholder="Contoh: 250" required 
                            class="block w-full h-12 pl-4 pr-12 bg-slate-50 border border-slate-150 rounded-xl text-dark-navy text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-300 shadow-inner" />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-muted-gray text-xs font-bold">ml</div>
                    </div>
                    <p class="mt-1.5 text-[10px] text-muted-gray leading-normal">
                        Info acuan: Gelas kecil (250 ml), Gelas sedang (350 ml), Gelas besar (450 ml).
                    </p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <button type="button" onclick="document.getElementById('volume_ml').value = 250" class="px-2.5 py-1 text-[11px] font-bold text-slate-600 bg-slate-100 hover:bg-primary/10 hover:text-primary rounded-lg border border-slate-200 transition-all cursor-pointer">
                            Gelas Kecil (250ml)
                        </button>
                        <button type="button" onclick="document.getElementById('volume_ml').value = 350" class="px-2.5 py-1 text-[11px] font-bold text-slate-600 bg-slate-100 hover:bg-primary/10 hover:text-primary rounded-lg border border-slate-200 transition-all cursor-pointer">
                            Gelas Sedang (350ml)
                        </button>
                        <button type="button" onclick="document.getElementById('volume_ml').value = 450" class="px-2.5 py-1 text-[11px] font-bold text-slate-600 bg-slate-100 hover:bg-primary/10 hover:text-primary rounded-lg border border-slate-200 transition-all cursor-pointer">
                            Gelas Besar (450ml)
                        </button>
                    </div>
                    @error('volume_ml')
                        <p class="mt-1.5 text-xs text-rose-500 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center items-center h-12 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-dark transition-all shadow-lg shadow-primary/25 active:scale-[0.98]">
                        Simpan Catatan Minum
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
