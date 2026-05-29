@extends('layouts.user')

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

            <a href="{{ route('user.monitoring.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                ➕ Tambah Monitoring
            </a>

            <form id="form-filter" class="flex flex-wrap gap-2 items-end">

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

            </form>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-lg border">
        <table class="w-full text-sm table-fixed">
            <thead class="bg-green-600 text-white">
        <tr>
            <th class="px-3 py-2 w-28">Tanggal</th>
            <th class="px-3 py-2 w-48">Nama Pasien</th>
            <th class="px-3 py-2 w-24">Jenis Kelamin</th>
            <th class="px-3 py-2 w-20 text-center">Pagi</th>
            <th class="px-3 py-2 w-20 text-center">Siang</th>
            <th class="px-3 py-2 w-20 text-center">Malam</th>
            <th class="px-3 py-2 w-24 text-center">Total Kkal</th>
            <th class="px-3 py-2 w-28 text-center">Persen (%)</th>
            <th class="px-3 py-2 w-32 text-center">Aksi</th>
        </tr>
        </thead>

            <tbody id="monitoring-body">
                @include('user.monitoring.partials._table')
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
$('input[name="tanggal_mulai"], input[name="tanggal_sampai"]').on('change', function (e) {
    e.preventDefault();
    clearTimeout(timer);

    timer = setTimeout(() => {
        $.get("{{ route('user.monitoring.search') }}", {
            tanggal_mulai: $('input[name="tanggal_mulai"]').val(),
            tanggal_sampai: $('input[name="tanggal_sampai"]').val()
        }, function (res) {
            $('#monitoring-body').html(res);
        });
    }, 300);
});

// Prevent normal submit
$('#form-filter').on('submit', function(e) {
    e.preventDefault();
    $('input[name="tanggal_mulai"]').trigger('change');
});
</script>
@endpush
