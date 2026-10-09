@extends('layouts.user')

@section('title','Edit Profil')

@section('content')

<div class="bg-white p-6 rounded shadow max-w-xl">

    <h2 class="text-lg font-semibold mb-4">Form Profil User</h2>

    <form method="POST" action="{{ route('user.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block text-sm">Berat Badan</label>
            <input type="number" name="berat_badan"
                   value="{{ $user->berat_badan }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3">
            <label class="block text-sm">Tinggi Badan</label>
            <input type="number" name="tinggi_badan"
                   value="{{ $user->tinggi_badan }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3">
            <label class="block text-sm">Tekanan Darah Sistolik (mmHg)</label>
            <input type="number" name="tekanan_darah_sistolik"
                   value="{{ old('tekanan_darah_sistolik', $user->tekanan_darah_sistolik) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3">
            <label class="block text-sm">Glukosa Darah (mg/dL)</label>
            <input type="number" name="glukosa_darah"
                   value="{{ old('glukosa_darah', $user->glukosa_darah) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3">
            <label class="block text-sm">Kolesterol (mg/dL)</label>
            <input type="number" name="kolesterol"
                   value="{{ old('kolesterol', $user->kolesterol) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

            <div class="mb-3">
                <label class="block text-sm">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                        class="w-full border px-3 py-2 rounded">
                    <option value="L"
                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                        Laki-laki
                    </option>
                    <option value="P"
                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                        Perempuan
                    </option>
                </select>
            </div>

        <div class="mb-3">
            <label class="block text-sm">Tujuan Diet</label>
            <select name="defisit" class="w-full border px-3 py-2 rounded">
                <option value="Menurunkan" {{ $user->defisit=='Menurunkan'?'selected':'' }}>Menurunkan</option>
                <option value="Stabil" {{ $user->defisit=='Stabil'?'selected':'' }}>Stabil</option>
                <option value="Menaikkan" {{ $user->defisit=='Menaikkan'?'selected':'' }}>Menaikkan</option>
            </select>
        </div>

        <div class="mb-3">
    <label class="block text-sm">Activity Factor</label>

    <select name="activity_factor" class="w-full border px-3 py-2 rounded">

    <option value="1.1"
        {{ old('activity_factor', $user->activity_factor) == 1.1 ? 'selected' : '' }}>
        1.1 Bed rest
    </option>

    <option value="1.2"
        {{ old('activity_factor', $user->activity_factor) == 1.2 ? 'selected' : '' }}>
        1.2 Bergerak terbatas
    </option>

    <option value="1.3"
        {{ old('activity_factor', $user->activity_factor) == 1.3 ? 'selected' : '' }}>
        1.3 Aktivitas ringan
    </option>

    <option value="1.4"
        {{ old('activity_factor', $user->activity_factor) == 1.4 ? 'selected' : '' }}>
        1.4 Aktivitas sedang
    </option>

    <option value="1.75"
        {{ old('activity_factor', $user->activity_factor) == 1.75 ? 'selected' : '' }}>
        1.75 Aktivitas berat
    </option>

</select>

</div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection
