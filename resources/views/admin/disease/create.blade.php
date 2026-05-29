@extends('layouts.admin')

@section('title','Tambah Penyakit')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-4">Tambah Penyakit</h1>

    <form action="{{ route('admin.diseases.store') }}" method="POST">
        @csrf

        {{-- NAMA PENYAKIT --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Nama Penyakit
            </label>

            <input type="text"
                   name="nama"
                   value="{{ old('nama') }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   placeholder="Contoh: Hipertensi"
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
                    class="px-4 py-2 bg-green-600 text-white rounded">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
