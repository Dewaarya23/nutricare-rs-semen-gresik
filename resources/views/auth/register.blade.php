@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex flex-col bg-cover bg-center"
     style="background-image: url('{{ asset('images/Background_Register.png') }}')">

    {{-- ================= HEADER LOGO ================= --}}
    <div class="relative w-full p-4">
        <div class="absolute right-4 top-4 flex gap-4">
            <img src="{{ asset('images/Logo_kemenkes.png') }}" class="h-12 md:h-14">
            <img src="{{ asset('images/Logo_Akreditasi_RS (2).png') }}" class="h-12 md:h-14">
        </div>

        <div class="flex justify-center mt-16 md:mt-24">
            <img src="{{ asset('images/Logo_RS_Semen_Gresik (2).png') }}" class="h-28 md:h-36">
        </div>
    </div>

    {{-- ================= FORM REGISTER ================= --}}
    <div class="flex-1 flex justify-center items-start mt-10">
        <div class="bg-white/90 backdrop-blur shadow-xl rounded-2xl w-full max-w-lg p-8">

            <h1 class="text-2xl font-bold text-center text-blue-700 mb-6">
                Registrasi Akun Pasien
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="role" value="user">

                <div>
                    <label class="font-medium">Email</label>
                    <input type="email" name="username" value="{{ old('username') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="font-medium">Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="font-medium">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp"
                            class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat_badan"
                            class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <div>
                    <label>Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label>Tujuan Diet</label>
                    <select name="defisit" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="Menurunkan">Menurunkan</option>
                    <option value="Stabil">Stabil</option>
                    <option value="Menaikkan">Menaikkan</option>
                    </select>
                </div>

                <div>
                    <label>Activity Factor</label>
                    <select name="activity_factor" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="1.1">1.1 Bad Rest</option>
                    <option value="1.2">1.2 Bergerak Terbatas</option>
                    <option value="1.3">1.3 Aktivitas ringan</option>
                    <option value="1.4">1.4 Aktivitas sedang</option>
                    <option value="1.75">1.75 Aktivitas berat</option>
                    </select>
                </div>

                <div>
                    <label>Ada Riwayat Penyakit?</label>
                    <select id="riwayatSelect" name="ada_riwayat"
                        class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        <option value="tidak">Tidak</option>
                        <option value="ya">Ya</option>
                    </select>
                </div>

                {{-- 🔴 PERUBAHAN PENTING DI SINI --}}
<div id="penyakitBox" class="hidden">
    <label class="font-medium">
        Pilih Penyakit (boleh lebih dari satu)
    </label>

    <div class="grid grid-cols-2 gap-2 mt-2">
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



                <button
                    class="w-full bg-blue-600 text-white py-2 rounded-lg">
                    Daftar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-blue-900 text-white text-center py-3 mt-10 text-sm">
        © {{ date('Y') }} Rumah Sakit Semen Gresik
    </div>
</div>

<script>
const riwayat = document.getElementById('riwayatSelect');
const penyakitBox = document.getElementById('penyakitBox');

riwayat.addEventListener('change', () => {
    penyakitBox.classList.toggle('hidden', riwayat.value !== 'ya');
});
</script>
@endsection
