<aside class="w-64 shrink-0 bg-white shadow-lg flex flex-col">

    {{-- Logo --}}
    <div class="p-4 border-b">
        <h2 class="text-xl font-bold text-center text-green-700">
            RS Semen Gresik
        </h2>
        <p class="text-xs text-center text-gray-500">
            Sistem Pemantauan Gizi
        </p>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 p-4 space-y-2 text-sm">

        {{-- ================= DASHBOARD ================= --}}
        <a href="{{ route('dashboard.admin') }}"
           class="flex items-center gap-3 px-4 py-2 rounded
           {{ request()->routeIs('dashboard.admin') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">

            <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 9.75L12 4l9 5.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z"/>
            </svg>

            <span>Dashboard</span>
        </a>

        {{-- ================= ENTRY DROPDOWN ================= --}}
        <div x-data="{ open: {{ request()->routeIs('admin.monitoring.*') ? 'true' : 'false' }} }">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-green-100">

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5h6M9 3h6a2 2 0 012 2v2H7V5a2 2 0 012-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 7h14v14a2 2 0 01-2 2H7a2 2 0 01-2-2V7z"/>
                    </svg>
                    <span>Entry</span>
                </div>

                <svg :class="open ? 'rotate-180' : ''"
                     class="w-4 h-4 transition-transform"
                     fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-2 space-y-1">

                <a href="{{ route('admin.monitoring.index') }}"
   class="flex items-center gap-2 px-4 py-2 rounded
   {{ request()->routeIs('admin.monitoring.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">

    <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3v18h18"/>
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M7 14l3-3 4 4 5-5"/>
    </svg>

    Monitoring Harian
</a>

            </div>
        </div>

        {{-- ================= MASTER DROPDOWN (FIXED) ================= --}}
        <div x-data="{ open: {{ (
            request()->routeIs('admin.menu.*') ||
            request()->routeIs('admin.patients.*') ||
            request()->routeIs('admin.diseases.*') ||
            request()->routeIs('admin.articles.*')
        ) ? 'true' : 'false' }} }">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-green-100">

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7h18M3 12h18M3 17h18"/>
                    </svg>
                    <span>Master</span>
                </div>

                <svg :class="open ? 'rotate-180' : ''"
                     class="w-4 h-4 transition-transform"
                     fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-2 space-y-1">

    {{-- DATA PASIEN --}}
    <a href="{{ route('admin.patients.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded
       {{ request()->routeIs('admin.patients.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">

        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5.121 17.804A9 9 0 1118.364 4.56 9 9 0 015.121 17.804z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>

        Data Pasien
    </a>

    {{-- MASTER MENU --}}
    <a href="{{ route('admin.menu.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded
       {{ request()->routeIs('admin.menu.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">

        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 3h18v4H3zM3 9h18v12H3z"/>
        </svg>

        Master Menu
    </a>

    {{-- MASTER PENYAKIT --}}
    <a href="{{ route('admin.diseases.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded
       {{ request()->routeIs('admin.diseases.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">

        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 2v20M2 12h20"/>
        </svg>

        Master Penyakit
    </a>

    {{-- ENTRY ARTIKEL --}}
    <a href="{{ route('admin.articles.index') }}"
       class="flex items-center gap-2 px-4 py-2 rounded
       {{ request()->routeIs('admin.articles.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">

        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 21H5a2 2 0 01-2-2V7l5-4h8l5 4v12a2 2 0 01-2 2z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 9h6M9 13h6M9 17h4"/>
        </svg>

        Entry Artikel
    </a>

    </div>
        </div>

    </nav>

    {{-- Logout --}}
    <div class="p-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-red-600 text-white py-2 rounded">
                Logout
            </button>
        </form>
    </div>

</aside>
