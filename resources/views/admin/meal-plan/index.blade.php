@extends('layouts.admin')

@section('title','Master Meal Plan & Tabel Pembagian Porsi')

@section('content')
<div class="flex justify-between mb-4">
    <div>
        <h1 class="text-2xl font-bold">Master Meal Plan & Tabel Pembagian Porsi</h1>
        <p class="text-gray-600 text-sm">
            Kelola tingkatan target energi harian beserta rincian pembagian porsi tiap meal plan
        </p>
    </div>

    <a href="{{ route('admin.meal-plan.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded h-fit">
        + Tambah Meal Plan
    </a>
</div>

<input type="text" id="search"
       placeholder="Cari nama / target energi..."
       class="border rounded px-3 py-2 mb-3 w-1/3">

<div id="table-data">
    @include('admin.meal-plan.partials.table')
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
