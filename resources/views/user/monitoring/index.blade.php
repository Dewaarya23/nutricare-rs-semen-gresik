@extends('layouts.user')
@section('title','Monitoring Harian')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    @php $user = auth()->user(); @endphp

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
        <img src="{{ asset('images/icon/restaurant.png') }}"
             alt="Monitoring Harian"
             class="w-10 h-10">

        <div>
            <h1 class="text-3xl font-bold text-green-700">
                Monitoring Harian
            </h1>
            <p class="text-gray-500 text-sm">
                Rekap asupan gizi harian anda
            </p>
        </div>
    </div>

        <a href="{{ route('user.monitoring.create') }}"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
            ➕ Tambah Monitoring
        </a>
    </div>

    {{-- FILTER TANGGAL --}}
<div class="bg-white p-4 rounded-xl shadow border border-green-100 mb-6">
    <form method="GET" action="{{ route('user.monitoring.index') }}"
          class="flex flex-wrap items-end gap-4">

        <div>
            <label class="block text-sm font-semibold text-gray-600">Dari</label>
            <input type="date"
                   name="dari"
                   value="{{ request('dari') }}"
                   class="border rounded-lg px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-600">Sampai</label>
            <input type="date"
                   name="sampai"
                   value="{{ request('sampai') }}"
                   class="border rounded-lg px-3 py-2">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
                🔍 Filter
            </button>

            <a href="{{ route('user.monitoring.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold">
                Reset
            </a>

            <a href="{{ route('user.monitoring.export.pdf', request()->query()) }}"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                📄 Export PDF
            </a>

        </div>
    </form>
</div>

    {{-- REMINDER UPDATE PROFIL --}}
<div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 rounded-xl shadow mb-4">
    <div class="flex items-start gap-3">

        <div class="text-2xl">ℹ️</div>

        <div>
            <p class="font-semibold text-base">
                Informasi Penting
            </p>

            <p class="text-sm mt-1">
                Pastikan Anda melakukan <strong>Update / Tambah Profil</strong> terlebih dahulu <strong>apabila akun dibuat oleh pihak gizi</strong>, agar sistem dapat membuat target diet dan logbook monitoring gizi secara otomatis.
                <strong>Pasien yang melakukan registrasi mandiri tetap dapat menggunakan fitur Update / Tambah Profil </strong> untuk mengubah target kebutuhan gizinya.
            </p>
        </div>

    </div>
</div>

    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-green-100">
        <table class="w-full text-sm">

            <thead class="bg-green-50 text-green-700">
                <tr>
                    <th class="border px-3 py-3 text-center">Tanggal</th>
                    <th class="border px-3 py-3 text-center">Nama</th>
                    <th class="border px-3 py-3 text-center">JK</th>
                    <th class="border px-3 py-3 text-center">Pagi</th>
                    <th class="border px-3 py-3 text-center">Siang</th>
                    <th class="border px-3 py-3 text-center">Malam</th>
                    <th class="border px-3 py-3 text-center">Total</th>
                    <th class="border px-3 py-3 text-center font-semibold">Persen Kebutuhan (%)</th>
                    <th class="border px-3 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @include('user.monitoring.partials.table')
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        {{ $monitorings->links() }}
    </div>

</div>
@endsection
