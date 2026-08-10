<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartSip') }}</title>
        <link rel="icon" href="{{ asset('images/smartsip_favicon.png') }}" type="image/png">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,850&display=swap" rel="stylesheet" />

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-dark-navy bg-secondary min-h-screen">
        
        @if(Auth::check() && Auth::user()->role === 'siswa')
            <!-- SISWA: FULLY RESPONSIVE SCREEN WITH TOP NAV (DESKTOP) AND BOTTOM NAV (MOBILE) -->
            <div class="min-h-screen flex flex-col pb-20 sm:pb-0 bg-secondary">
                <!-- Navigation -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-slate-100 py-5 shrink-0 shadow-sm">
                        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-between items-center">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-6">
                    {{ $slot }}
                </main>
            </div>
        @elseif(Auth::check() && Auth::user()->role === 'admin')
            <!-- ADMIN: FLOATING SIDEBAR LIGHT MODE (CODINGLAB DESIGN) -->
            <div x-data="{ sidebarCollapsed: false, sidebarSearch: '' }" class="min-h-screen bg-[#f2f4fc] flex text-slate-800 p-3 sm:p-4 gap-4">
                <!-- Sidebar -->
                @include('layouts.admin-sidebar')

                <!-- Main Content Area -->
                <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
                    <!-- Top Navbar / Header -->
                    <header class="h-16 bg-white border border-slate-200/80 rounded-2xl px-6 sm:px-8 flex items-center justify-between shrink-0 shadow-sm mb-4">
                        @isset($header)
                            {{ $header }}
                        @else
                            <div></div>
                        @endisset
                        
                        <!-- Top Right Profile -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-xs font-bold text-slate-700 focus:outline-none py-1.5 px-3 hover:bg-slate-50 rounded-xl transition-all border border-slate-200">
                                <div class="w-7 h-7 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-600 font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg py-1.5 z-50">
                                <span class="block px-4 py-1.5 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Kelola Akun</span>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Profil Akun</a>
                                <hr class="border-slate-100 my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-xs font-semibold text-rose-500 hover:bg-slate-50 transition-colors">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <!-- Page Body -->
                    <main class="flex-grow">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        @else
            <!-- GURU: WIDE FULL-WIDTH VIEWPORT FOR STATISTICS (LIGHT MODE) -->
            <div class="min-h-screen bg-[#f5f6fa] text-slate-700">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white border-b border-slate-200 py-6 shadow-sm">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="py-8">
                    {{ $slot }}
                </main>
            </div>
        @endif

        @isset($scripts)
            {{ $scripts }}
        @endisset
    </body>
</html>
