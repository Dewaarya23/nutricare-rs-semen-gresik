@extends('layouts.admin')

@section('title','Tambah Profil Admin')

@section('content')

<div class="bg-white p-6 rounded shadow max-w-xl">

    <h2 class="text-xl font-bold mb-4">Profil Admin</h2>

    <form action="{{ route('admin.profile.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Berat Badan (Kg)</label>
            <input type="number" step="0.1"
                   name="berat_badan"
                   value="{{ old('berat_badan', $user->berat_badan) }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tinggi Badan (cm)</label>
            <input type="number"
                   name="tinggi_badan"
                   value="{{ old('tinggi_badan', $user->tinggi_badan) }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih --</option>
                <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan
        </button>

    </form>

</div>

@endsection
