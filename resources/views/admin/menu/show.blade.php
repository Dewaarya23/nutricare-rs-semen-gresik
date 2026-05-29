@extends('layouts.app')

@section('title','Detail Menu')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-2">{{ $menu->nama_menu }}</h1>

    <p>Kode: {{ $menu->kode_menu }}</p>
    <p>Kategori: {{ $menu->kategori_label }}</p>
    <p>KKal/g: {{ $menu->kkal_per_gram }}</p>

    <h2 class="mt-4 font-semibold">Opsi Berat</h2>

    <table class="w-full border mt-2">
        <thead class="bg-gray-200">
            <tr>
                <th>Opsi</th>
                <th>Gram</th>
                <th>KKal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menu->weightOptions as $w)
            <tr>
                <td>{{ $w->opsi_berat }}</td>
                <td>{{ $w->gram }}</td>
                <td>{{ $w->kkal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-4 font-semibold">Boleh Dikonsumsi Oleh</h2>

    @if($menu->diseases->count())
        <ul class="list-disc ml-6">
            @foreach($menu->diseases as $d)
                <li>{{ $d->nama }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-red-600">Tidak boleh dikonsumsi pasien dengan penyakit tertentu</p>
    @endif

    <a href="{{ route('admin.menu.index') }}" class="text-blue-600 underline mt-4 inline-block">
        ← Kembali
    </a>
</div>
@endsection
