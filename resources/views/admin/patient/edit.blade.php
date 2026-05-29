@extends('layouts.admin')

@section('title','Edit Pasien')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-1">Edit Data Pasien</h1>
    <p class="text-gray-600 mb-6">
        Perbarui identitas dan kondisi kesehatan pasien
    </p>

    <form method="POST"
          action="{{ route('admin.patients.update',$patient->id) }}"
          class="bg-white p-6 rounded-xl shadow space-y-6">
        @csrf
        @method('PUT')

        {{-- ================= IDENTITAS PASIEN ================= --}}
        <div>
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">
                Identitas Pasien
            </h2>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm font-medium">Nama Lengkap</label>
                    <input
                        name="nama"
                        value="{{ $patient->nama }}"
                        class="border p-2 rounded w-full"
                        required
                    >
                </div>

                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input
                        value="{{ $patient->email }}"
                        class="border p-2 rounded w-full bg-gray-100"
                        readonly
                    >
                    <p class="text-xs text-gray-500">Email tidak dapat diubah</p>
                </div>

                <div>
                    <label class="text-sm font-medium">Password</label>
                    <input
                            type="password"
                            name="password"
                            placeholder="********"
                            class="border p-2 rounded w-full"
                        >
                     <p class="text-xs text-gray-500">
                            Kosongkan jika tidak ingin mengubah password
                    </p>
                </div>


                <div>
                    <label class="text-sm font-medium">Nomor Telepon</label>
                    <input
                        name="no_telp"
                        value="{{ $patient->no_telp }}"
                        class="border p-2 rounded w-full"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium">Tanggal Lahir</label>
                    <input
                        type="date"
                        name="tanggal_lahir"
                        value="{{ $patient->tanggal_lahir }}"
                        class="border p-2 rounded w-full"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="border p-2 rounded w-full">
                        <option value="L" {{ $patient->jenis_kelamin=='L'?'selected':'' }}>
                            Laki-laki
                        </option>
                        <option value="P" {{ $patient->jenis_kelamin=='P'?'selected':'' }}>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Tipe Pengguna</label>
                    <select name="tipe_user" class="border p-2 rounded w-full font-semibold">
                        <option value="pasien" {{ $patient->tipe_user=='pasien'?'selected':'' }}>
                            Pasien
                        </option>
                        <option value="pegawai" {{ $patient->tipe_user=='pegawai'?'selected':'' }}>
                            Pegawai
                        </option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ================= DATA KESEHATAN ================= --}}
        <div>
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">
                Data Kesehatan
            </h2>

            <div class="grid grid-cols-3 gap-4">

                <div>
                    <label class="text-sm font-medium">Berat Badan (kg)</label>
                    <input
                        name="berat_badan"
                        value="{{ $patient->berat_badan }}"
                        class="border p-2 rounded w-full"
                    >
                </div>

                <div>
                    <label class="text-sm font-medium">Tinggi Badan (cm)</label>
                    <input
                        name="tinggi_badan"
                        value="{{ $patient->tinggi_badan }}"
                        class="border p-2 rounded w-full"
                    >
                </div>

                <div class="col-span-3">
                    <label class="text-sm font-semibold">Riwayat Penyakit</label>
                    <p class="text-xs text-gray-500 mb-2">
                        Centang satu atau lebih penyakit yang pernah atau sedang dialami pasien
                    </p>

                    <div class="grid grid-cols-3 gap-2">
                        @foreach($diseases as $d)
                            <label class="flex items-center gap-2 text-sm">
                                <input
                                    type="checkbox"
                                    name="diseases[]"
                                    value="{{ $d->id }}"
                                    {{ $patient->diseases->contains($d->id) ? 'checked' : '' }}
                                >
                                {{ $d->nama }}
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- ================= AKSI ================= --}}
        <div class="flex justify-between border-t pt-4">
            <a href="{{ route('admin.patients.index') }}"
               class="px-4 py-2 bg-gray-200 rounded">
                ← Kembali
            </a>

            <button class="px-6 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
