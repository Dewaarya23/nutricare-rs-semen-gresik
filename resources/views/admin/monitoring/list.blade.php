@extends('layouts.admin')

@section('title','Entry Monitoring Gizi')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-5">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">

        <div>
            <h2 class="text-2xl font-bold text-green-700">
                Entry Monitoring Harian
            </h2>
            <p class="text-sm text-gray-500">
                Rekap data asupan gizi pasien per hari
            </p>
        </div>

        <div class="flex gap-2 flex-wrap">

            <a href="{{ route('admin.monitoring.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                ➕ Tambah Pasien
            </a>

            {{-- FILTER GET NORMAL --}}
            <form method="GET"
                  action="{{ route('admin.monitoring.index') }}"
                  class="flex flex-wrap gap-2 items-end">

                <div>
                    <label class="text-xs font-semibold text-gray-600">Nama Pasien</label>
                    <input type="text"
                           name="nama"
                           placeholder="Ketik nama pasien..."
                           class="border rounded-lg px-3 py-2 w-48"
                           value="{{ request('nama') }}">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600">Dari</label>
                    <input type="date"
                           name="tanggal_mulai"
                           value="{{ request('tanggal_mulai') }}"
                           class="border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600">Sampai</label>
                    <input type="date"
                           name="tanggal_sampai"
                           value="{{ request('tanggal_sampai') }}"
                           class="border rounded-lg px-3 py-2">
                </div>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                    🔍 Filter
                </button>

                <a href="{{ route('admin.monitoring.export.pdf', request()->query()) }}"
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                    📄 Export PDF
                </a>

            </form>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-lg border">
        <table class="w-full text-sm">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-3 py-2">Tanggal</th>
                    <th class="px-3 py-2">Nama Pasien</th>
                    <th class="px-3 py-2">Jenis Kelamin</th>
                    <th class="px-3 py-2">Pagi</th>
                    <th class="px-3 py-2">Siang</th>
                    <th class="px-3 py-2">Malam</th>
                    <th class="px-3 py-2">Total Kkal</th>
                    <th class="px-3 py-2 text-center">Persen Kebutuhan (%)</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @include('admin.monitoring.partials._table')
            </tbody>

        </table>
    </div>

    <div class="mt-4">
        {{ $monitorings->links() }}
    </div>

</div>
@endsection

@push('scripts')
<script>
let timer = null;

// Live search AJAX
$('#search-nama, input[name="tanggal_mulai"], input[name="tanggal_sampai"]').on('keyup change', function (e) {
    e.preventDefault();
    clearTimeout(timer);

    timer = setTimeout(() => {
        $.get("{{ route('admin.monitoring.search') }}", {
            nama: $('#search-nama').val(),
            tanggal_mulai: $('input[name="tanggal_mulai"]').val(),
            tanggal_sampai: $('input[name="tanggal_sampai"]').val()
        }, function (res) {
            $('#monitoring-body').html(res);
        });
    }, 300); // 300ms debounce
});

// Optional: prevent full form submit on Enter
$('#form-filter').on('submit', function(e) {
    e.preventDefault(); // stop normal GET submit
    $('#search-nama').trigger('change'); // trigger AJAX
});
</script>
@endpush
