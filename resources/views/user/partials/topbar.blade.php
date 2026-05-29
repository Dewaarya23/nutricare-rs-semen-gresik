<header class="bg-white shadow p-4 flex justify-between items-center">

    <h1 class="font-semibold text-lg">
        @yield('title')
    </h1>

    <div class="flex items-center gap-3">

        {{-- TOMBOL UPDATE/TAMBAH PROFIL --}}
        <a href="{{ route('user.profile.edit') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            Update/Tambah Profil
        </a>

        {{-- NAMA PASIEN --}}
        <span class="text-sm font-medium text-gray-700">
            {{ auth()->user()->name ?? auth()->user()->nama }}
        </span>

        {{-- BADGE ROLE --}}
        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded font-semibold">
            USER / PASIEN
        </span>

    </div>

</header>
