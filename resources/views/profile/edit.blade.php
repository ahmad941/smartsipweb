<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SmartSip &rsaquo; Pengaturan</span>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight tracking-tight mt-0.5">
                    Pengaturan Profil & Akun
                </h2>
            </div>
            <a href="{{ route('panduan.download', Auth::user()->role) }}" target="_blank" class="px-3.5 py-2 bg-primary hover:bg-primary-dark text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-1.5 shrink-0">
                📄 Unduh Panduan PDF ({{ strtoupper(Auth::user()->role) }})
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        @if(Auth::check() && Auth::user()->role === 'siswa')
            <!-- SISWA CLEAN MOBILE CONTAINER VIEW -->
            <div class="max-w-md mx-auto space-y-6">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
                @include('profile.partials.delete-user-form')
            </div>
        @else
            <!-- ADMIN & GURU ELEGANT CLEAN CONTAINER VIEW -->
            <div class="max-w-2xl mx-auto space-y-6">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
                @include('profile.partials.delete-user-form')
            </div>
        @endif
    </div>
</x-app-layout>
