@extends('layouts.admin')

@section('title','Edit Penyakit')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-4">Edit Penyakit</h1>

    <form action="{{ route('admin.diseases.update', $disease->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- KODE PENYAKIT (READ ONLY) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Kode Penyakit
            </label>
            <input type="text"
                   value="{{ $disease->kode_penyakit }}"
                   class="w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        {{-- NAMA PENYAKIT --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Nama Penyakit
            </label>

            <input type="text"
                   name="nama"
                   value="{{ old('nama', $disease->nama) }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   required>

            @error('nama')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.diseases.index') }}"
               class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
