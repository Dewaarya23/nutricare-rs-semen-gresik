@extends('layouts.admin')

@section('title','Master Menu Gizi')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
    <div>
        <h1 class="text-2xl font-bold">Master Menu Gizi</h1>
<p class="text-gray-600 text-sm">
    Kelola dan atur daftar menu gizi</p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('admin.menu.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Tambah Menu
        </a>
    </div>
</div>

{{-- FILTER --}}
<div class="mb-4 flex flex-wrap gap-2">
    <select id="kategori"
            class="border rounded px-3 py-2 w-full md:w-1/4">

        <option value="ALL">ALL (Semua Kategori)</option>
        <option value="K">Karbohidrat</option>
        <option value="PHR">Protein Hewani Rendah Lemak</option>
        <option value="PHS">Protein Hewani Sedang Lemak</option>
        <option value="PST">Protein Hewani Tinggi Lemak</option>
        <option value="PN">Protein Nabati</option>
        <option value="S">Sayuran</option>
        <option value="BG">Buah & Gula</option>
        <option value="STL">Susu Tanpa Lemak</option>
        <option value="SRL">Susu Rendah Lemak</option>
        <option value="STIL">Susu Tinggi Lemak</option>
        <option value="M">Minyak</option>
    </select>

    <input type="text"
           id="search"
           placeholder="Cari nama menu..."
           class="border rounded px-3 py-2 w-full md:w-1/3">
</div>

<div id="table-container">
    @include('admin.menu.partials.table')
</div>

<script>
let timeout = null;

function loadData(page = 1) {
    let kategori = document.getElementById('kategori').value;
    let search   = document.getElementById('search').value;

    fetch(`?page=${page}&kategori=${encodeURIComponent(kategori)}&search=${encodeURIComponent(search)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('table-container').innerHTML = html;
    });
}

document.getElementById('kategori').addEventListener('change', function () {
    loadData();
});

document.getElementById('search').addEventListener('keyup', function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => loadData(), 300);
});

document.addEventListener('click', function(e){
    let link = e.target.closest('.pagination a');
    if(link){
        e.preventDefault();
        let url  = link.getAttribute('href');
        let page = new URL(url).searchParams.get('page');
        loadData(page);
    }
});
</script>

@endsection
