@extends('layouts.admin')

@section('title','Tambah Pasien')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-6 bg-white rounded-xl shadow">

    <h1 class="text-2xl font-bold text-green-700 mb-6">
        ➕ Tambah Pasien
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.patients.store') }}" class="grid grid-cols-2 gap-4">
        @csrf

        <input type="hidden" name="role" value="user">

        <div class="col-span-2">
            <label>Nama Lengkap</label>
            <input name="nama" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Email</label>
            <input name="email" type="email" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Password</label>
            <input name="password" type="password" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>No Telepon</label>
            <input name="no_telp" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div>
            <label>Tipe Pengguna</label>
            <select name="tipe_user" class="w-full border p-2 rounded font-semibold" required>
                <option value="">-- Pilih --</option>
                <option value="pasien">Pasien</option>
                <option value="pegawai">Pegawai</option>
            </select>
        </div>

        <div>
            <label>Berat Badan (kg)</label>
            <input name="berat_badan" type="number" step="0.1"
                class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Tinggi Badan (cm)</label>
            <input name="tinggi_badan" type="number" step="0.1"
                class="w-full border p-2 rounded" required>
        </div>

        <div class="col-span-2">
            <label>Ada Riwayat Penyakit?</label>
            <select id="riwayatSelect" name="ada_riwayat"
                class="w-full border p-2 rounded" required>
                <option value="">-- Pilih --</option>
                <option value="tidak">Tidak</option>
                <option value="ya">Ya</option>
            </select>
        </div>

        {{-- PILIH PENYAKIT --}}
        <div id="penyakitBox" class="col-span-2 hidden">
            <label class="font-semibold">
                Pilih Penyakit (boleh lebih dari satu)
            </label>

            <div class="grid grid-cols-3 gap-2 mt-2">
                @foreach($diseases as $d)
                    <label class="flex items-center gap-2">
                        <input type="checkbox"
                               name="riwayat_penyakit[]"
                               value="{{ $d->id }}">
                        {{ $d->nama }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="col-span-2 flex justify-end gap-4 mt-6">
            <a href="{{ route('admin.patients.index') }}"
               class="px-4 py-2 bg-gray-200 rounded">
                Batal
            </a>

            <button class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                💾 Simpan Pasien
            </button>
        </div>
    </form>
</div>

<script>
const riwayat = document.getElementById('riwayatSelect');
const penyakitBox = document.getElementById('penyakitBox');

riwayat.addEventListener('change', () => {
    penyakitBox.classList.toggle('hidden', riwayat.value !== 'ya');
});
</script>
@endsection
