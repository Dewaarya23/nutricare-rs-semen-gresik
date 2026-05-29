<header class="bg-white shadow p-4 flex justify-between items-center">

    <div>
        <h1 class="font-semibold text-lg">
            @yield('title')
        </h1>
    </div>

    <div class="flex items-center gap-4">

        {{-- TOMBOL UPDATE/TAMBAH PROFIL --}}
        <a href="{{ route('admin.profile.form') }}"
           class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 transition">
            Update/Tambah Profil
        </a>

        {{-- NAMA ADMIN --}}
        <span class="text-sm font-medium text-gray-700">
            {{ auth()->user()->name }}
        </span>

        {{-- BADGE ROLE --}}
        @if(auth()->user()->role === 'admin')
            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded font-semibold">
                ADMIN GIZI
            </span>
        @endif
    </div>

</header>
