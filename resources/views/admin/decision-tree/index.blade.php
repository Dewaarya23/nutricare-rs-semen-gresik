@extends('layouts.admin')

@section('title','Master Decision Tree')

@section('content')
<div class="flex justify-between mb-4">
    <div>
        <h1 class="text-2xl font-bold">Master Decision Tree</h1>
        <p class="text-gray-600 text-sm">
            Aturan klasifikasi kategori diet berdasarkan parameter klinis pasien
        </p>
    </div>

    <a href="{{ route('admin.decision-tree.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded h-fit">
        + Tambah Aturan
    </a>
</div>

<input type="text" id="search"
       placeholder="Cari kategori diet..."
       class="border rounded px-3 py-2 mb-3 w-1/3">

<div id="table-data">
    @include('admin.decision-tree.partials.table')
</div>

<script>
let timeout;
const searchInput = document.getElementById('search');

searchInput.addEventListener('keyup', () => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        fetch(`?search=${encodeURIComponent(searchInput.value)}`, {
            headers: {'X-Requested-With':'XMLHttpRequest'}
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('table-data').innerHTML = html;
        });
    }, 300);
});
</script>
@endsection
