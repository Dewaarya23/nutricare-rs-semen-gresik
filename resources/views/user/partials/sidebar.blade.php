<aside class="w-64 shrink-0 bg-white shadow-lg flex flex-col">

    {{-- Logo / Header --}}
    <div class="p-6 border-b text-center">
        <h2 class="text-xl font-bold text-green-700">
            RS Semen Gresik
        </h2>
        <p class="text-xs text-gray-500">
            Sistem Pemantauan Gizi
        </p>
    </div>

    {{-- Menu / Navigasi --}}
    <nav class="flex-1 p-4 space-y-2 text-sm">

        <a href="{{ route('dashboard.user') }}"
           class="flex items-center gap-2 px-4 py-2 rounded
           {{ request()->routeIs('dashboard.user') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">
            <span>Dashboard</span>
        </a>

        <a href="{{ route('user.monitoring.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded
           {{ request()->routeIs('user.monitoring.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">
            <span>Monitoring Asupan Gizi</span>
        </a>

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
