@if(Auth::check() && Auth::user()->role === 'siswa')
    <!-- SISWA: RESPONSIVE BOTTOM NAVIGATION (MOBILE) AND TOP NAVIGATION (DESKTOP) -->
    
    <!-- 1. DESKTOP NAVIGATION BAR (sm:flex hidden) -->
    <nav class="hidden sm:flex bg-white border-b border-slate-100 shadow-premium h-16 items-center sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">S</div>
                    <span class="font-extrabold text-lg text-dark-navy tracking-tight">Smart<span class="text-primary">Sip</span></span>
                </a>

                <!-- Navigation Links -->
                <div class="flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold transition-all px-3 py-2 rounded-lg
                        {{ request()->routeIs('dashboard') ? 'text-primary bg-primary/5' : 'text-muted-gray hover:text-dark-navy' }}">
                        Dashboard
                    </a>
                    
                    @if(Auth::user()->student)
                        <a href="{{ route('challenges.index') }}" class="text-xs font-bold transition-all px-3 py-2 rounded-lg
                            {{ request()->routeIs('challenges.*') ? 'text-primary bg-primary/5' : 'text-muted-gray hover:text-dark-navy' }}">
                            Tantangan
                        </a>
                        <a href="{{ route('leaderboard.index') }}" class="text-xs font-bold transition-all px-3 py-2 rounded-lg
                            {{ request()->routeIs('leaderboard.*') ? 'text-primary bg-primary/5' : 'text-muted-gray hover:text-dark-navy' }}">
                            Leaderboard
                        </a>
                        <a href="{{ route('education.index') }}" class="text-xs font-bold transition-all px-3 py-2 rounded-lg
                            {{ request()->routeIs('education.*') ? 'text-primary bg-primary/5' : 'text-muted-gray hover:text-dark-navy' }}">
                            Edukasi & Kuis
                        </a>
                        <a href="{{ route('survey.index') }}" class="text-xs font-bold transition-all px-3 py-2 rounded-lg
                            {{ request()->routeIs('survey.*') || request()->routeIs('questionnaire.*') ? 'text-primary bg-primary/5' : 'text-muted-gray hover:text-dark-navy' }}">
                            📋 Kuesioner
                        </a>
                        <a href="{{ route('sugar-consumptions.create') }}" class="text-xs font-bold transition-all px-3 py-2 rounded-lg text-emerald-600 bg-emerald-50 hover:bg-emerald-100">
                            + Catat Minuman
                        </a>
                    @endif
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 text-xs font-bold text-dark-navy focus:outline-none py-2 px-3 hover:bg-slate-50 rounded-xl transition-all">
                    <span>{{ Auth::user()->student->nickname ?? 'Siswa' }}</span>
                    <div class="w-8 h-8 rounded-full bg-primary/10 border-2 border-primary/20 flex items-center justify-center text-primary font-bold">
                        {{ substr(Auth::user()->student->nickname ?? 'S', 0, 1) }}
                    </div>
                </button>
                <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-premium py-2 z-50">
                    <span class="block px-4 py-2 text-xs text-muted-gray">Halo, {{ Auth::user()->student->nickname ?? 'Siswa' }}</span>
                    <hr class="border-slate-100 my-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-dark-navy hover:bg-slate-50">Profil Akun</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-xs font-semibold text-rose-500 hover:bg-slate-50">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. MOBILE BOTTOM NAVIGATION BAR (sm:hidden flex) -->
    <nav class="sm:hidden flex fixed bottom-0 inset-x-0 h-20 bg-white border-t border-slate-100 shadow-navbar justify-around items-center px-4 z-40">
        
        <!-- Tab 1: Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-xl transition-all
            {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-400 hover:text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] font-bold mt-1">Home</span>
        </a>

        <!-- Tab 2: Tantangan / Misi -->
        <a href="{{ route('challenges.index') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-xl transition-all
            {{ request()->routeIs('challenges.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="text-[10px] font-bold mt-1">Misi</span>
        </a>

        <!-- FAB (Middle): Add Sugar Log -->
        <div class="relative -top-4">
            <a href="{{ route('sugar-consumptions.create') }}" class="w-16 h-16 rounded-full bg-primary hover:bg-primary-dark text-white flex items-center justify-center shadow-lg shadow-primary/30 transform active:scale-95 transition-all duration-200">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                </svg>
            </a>
        </div>

        <!-- Tab 3: Leaderboard -->
        <a href="{{ route('leaderboard.index') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-xl transition-all
            {{ request()->routeIs('leaderboard.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="text-[10px] font-bold mt-1">Peringkat</span>
        </a>

        <!-- Tab 4: Edukasi & Kuis -->
        <a href="{{ route('education.index') }}" class="flex flex-col items-center justify-center w-14 h-14 rounded-xl transition-all
            {{ request()->routeIs('education.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="text-[10px] font-bold mt-1">Edukasi</span>
        </a>

    </nav>
@else
    <!-- GURU: TOP NAVIGATION BAR (STANDARD RESPONSIVE - LIGHT MODE) -->
    <nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                <span class="text-white font-bold text-sm">S</span>
                            </div>
                            <span class="text-slate-800 font-extrabold text-sm">SmartSip</span>
                        </a>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-xl text-slate-600 bg-white hover:text-slate-900 hover:bg-slate-50 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-slate-700 hover:bg-slate-50">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="text-slate-700 hover:bg-slate-50"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-50 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-200">
            <div class="pt-4 pb-1 border-t border-slate-200">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-600 hover:bg-slate-50">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" class="text-slate-600 hover:bg-slate-50"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endif
