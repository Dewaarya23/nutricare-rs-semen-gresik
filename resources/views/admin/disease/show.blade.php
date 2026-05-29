@extends('layouts.admin')

@section('title','Detail Penyakit')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-6">Detail Penyakit</h1>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">
            Kode Penyakit
        </label>
        <div class="border rounded px-3 py-2 bg-gray-50">
            {{ $disease->kode_penyakit }}
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">
            Nama Penyakit
        </label>
        <div class="border rounded px-3 py-2 bg-gray-50">
            {{ $disease->nama }}
        </div>
    </div>

    {{-- MENU TERKAIT --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Menu Terkait
        </label>

        @if($disease->menus->count())
            <ul class="list-disc pl-5 text-sm">
                @foreach($disease->menus as $menu)
                    <li>{{ $menu->nama_menu }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-gray-500 italic">
                Belum ada menu terkait
            </p>
        @endif
    </div>

    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.diseases.index') }}"
           class="px-4 py-2 bg-gray-400 text-white rounded">
            Kembali
        </a>

        <a href="{{ route('admin.diseases.edit', $disease->id) }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">
            Edit
        </a>
    </div>

</div>
@endsection
