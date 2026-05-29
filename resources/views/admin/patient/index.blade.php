@extends('layouts.admin')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Data Pasien</h1>
        <p class="text-gray-600 text-sm">
            Daftar pasien dan pegawai yang terdaftar dalam sistem
        </p>
    </div>

    {{-- ➕ TOMBOL TAMBAH PASIEN --}}
    <a href="{{ route('admin.patients.create') }}"
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow transition">
        + Tambah Pasien
    </a>
</div>

{{-- FILTER & SEARCH --}}
<div class="flex items-center gap-4 mb-4">

    <input type="text"
           id="search"
           placeholder="Cari nama / email pasien..."
           class="border rounded px-3 py-2 w-1/3">

    <select id="filterUser"
            class="border rounded px-3 py-2">
        <option value="">Semua User</option>
        <option value="pasien">Pasien</option>
        <option value="pegawai">Pegawai</option>
    </select>

</div>

{{-- TABLE --}}
<div id="table-data">
    @include('admin.patient.partials.table')
</div>
@endsection

@push('scripts')
<script>
let typingTimer;
let doneTypingInterval = 300;

// LOAD DATA AJAX
function loadData(url = "{{ route('admin.patients.index') }}") {
    $.get(url, {
        search: $('#search').val(),
        keterangan_user: $('#filterUser').val()
    }, function (data) {
        $('#table-data').html(data);
    });
}

// LIVE SEARCH
$('#search').on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(loadData, doneTypingInterval);
});

// FILTER USER
$('#filterUser').on('change', function () {
    loadData();
});

// PAGINATION AJAX
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    loadData($(this).attr('href'));
});

// TOGGLE DETAIL PASIEN
function toggleDetail(id) {
    const row = document.getElementById('detail-' + id);
    if (row) {
        row.classList.toggle('hidden');
    }
}
</script>
@endpush
