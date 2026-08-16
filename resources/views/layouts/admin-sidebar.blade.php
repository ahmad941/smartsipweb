<aside :class="sidebarCollapsed ? 'w-20' : 'w-64'" class="bg-white border border-slate-200/80 rounded-[28px] p-4 sm:p-5 shadow-xl min-h-[calc(100vh-2rem)] flex flex-col justify-between shrink-0 transition-all duration-300 relative z-30">
    
    <!-- Floating Circular Expand/Collapse Button -->
    <button @click="sidebarCollapsed = !sidebarCollapsed" 
        class="w-6 h-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full flex items-center justify-center absolute -right-3 top-8 shadow-md hover:scale-110 transition-all duration-200 z-50 focus:outline-none">
        <svg class="w-3.5 h-3.5 transform transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <div class="space-y-5">
        <!-- Brand Header -->
        <div class="flex items-center gap-3 px-1">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-extrabold text-lg flex items-center justify-center shrink-0 shadow-lg shadow-indigo-600/30">
                SS
            </div>
            <div x-show="!sidebarCollapsed" class="overflow-hidden transition-all duration-200">
                <h1 class="text-sm font-extrabold text-slate-800 tracking-tight leading-tight block">SmartSip</h1>
                <span class="text-[10px] font-bold text-slate-400 block">Web Developer / Admin</span>
            </div>
        </div>

        <!-- Sidebar Search Bar -->
        <div x-show="!sidebarCollapsed" class="relative">
            <div class="bg-[#f4f4fe] rounded-xl px-3 py-2.5 flex items-center gap-2.5 text-slate-400 focus-within:ring-2 focus-within:ring-indigo-600/20 focus-within:bg-white border border-transparent focus-within:border-indigo-600/30 transition-all">
                <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" x-model="sidebarSearch" placeholder="Search menu..." 
                    class="bg-transparent border-none p-0 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-0 w-full" />
            </div>
        </div>
        
        <div x-show="sidebarCollapsed" class="flex justify-center">
            <div class="w-9 h-9 bg-[#f4f4fe] rounded-xl flex items-center justify-center text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Navigation Menu List -->
        <nav class="space-y-1.5 pt-1">
            
            <!-- 1. Dashboard -->
            <a href="{{ route('dashboard') }}" 
                x-show="!sidebarSearch || 'dashboard'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Dashboard</span>
            </a>

            <!-- 2. Minuman Manis -->
            <a href="{{ route('beverages.index') }}" 
                x-show="!sidebarSearch || 'minuman manis beverages'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('beverages.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Minuman Manis</span>
            </a>

            <!-- 3. Kategori Minuman -->
            <a href="{{ route('admin.categories.index') }}" 
                x-show="!sidebarSearch || 'kategori minuman categories'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Kategori Minuman</span>
            </a>

            <!-- 4. Sekolah & Kelas -->
            <a href="{{ route('schools.index') }}" 
                x-show="!sidebarSearch || 'sekolah kelas schools'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('schools.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Sekolah & Kelas</span>
            </a>

            <!-- 5. Instrumen TPB & Misi -->
            <a href="{{ route('admin.instruments.index') }}" 
                x-show="!sidebarSearch || 'tpb instrumen misi tantangan'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.instruments.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Instrumen TPB & Misi</span>
            </a>

            <!-- 6. Soal Pengetahuan -->
            <a href="{{ route('admin.knowledge.index') }}" 
                x-show="!sidebarSearch || 'soal pengetahuan gula'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.knowledge.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Soal Pengetahuan</span>
            </a>

            <!-- 7. Materi Edukasi -->
            <a href="{{ route('admin.educations.index') }}" 
                x-show="!sidebarSearch || 'materi edukasi artikel video'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.educations.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Materi Edukasi</span>
            </a>

            <!-- 8. Tim Peneliti -->
            <a href="{{ route('admin.teams.index') }}" 
                x-show="!sidebarSearch || 'tim peneliti hibah'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.teams.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Tim Peneliti</span>
            </a>

            <!-- 9. User & Responden -->
            <a href="{{ route('admin.users.index') }}" 
                x-show="!sidebarSearch || 'user pengguna responden siswa guru'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">User & Akun</span>
            </a>

            <!-- 10. Data Siswa Responden -->
            <a href="{{ Route::has('admin.students.index') ? route('admin.students.index') : '#' }}" 
                x-show="!sidebarSearch || 'data siswa responden antropometri imt'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.students.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Data Siswa (Profil)</span>
            </a>

            <!-- 10. Ekspor Data Riset -->
            <a href="{{ route('admin.exports.index') }}" 
                x-show="!sidebarSearch || 'ekspor export data spss excel csv riset'.includes(sidebarSearch.toLowerCase())"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all group
                    {{ request()->routeIs('admin.exports.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Ekspor Data Riset</span>
            </a>

        </nav>
    </div>

    <!-- Sidebar Bottom Section (Logout & Mode) -->
    <div class="border-t border-slate-100 pt-3 space-y-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-rose-600 hover:bg-rose-50/80 transition-all group">
                <svg class="w-5 h-5 shrink-0 text-slate-500 group-hover:text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="truncate">Logout</span>
            </button>
        </form>

        <!-- Dark Mode Toggle Switch Bar (Simulated) -->
        <div x-data="{ darkMode: false }" class="bg-[#f4f4fe] rounded-xl p-2.5 flex items-center justify-between transition-all">
            <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <span x-show="!sidebarCollapsed" class="text-xs font-bold text-slate-600">Dark Mode</span>
            </div>
            <button @click="darkMode = !darkMode" class="w-9 h-5 rounded-full transition-colors p-0.5 focus:outline-none" :class="darkMode ? 'bg-indigo-600' : 'bg-slate-300'">
                <div class="w-4 h-4 rounded-full bg-white transition-transform duration-200" :class="darkMode ? 'translate-x-4' : 'translate-x-0'"></div>
            </button>
        </div>
    </div>

</aside>
