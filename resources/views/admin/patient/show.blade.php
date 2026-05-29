@extends('layouts.admin')

@section('title','Detail Pasien')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Detail Data Pasien</h1>

        <div class="flex gap-2">
            <a href="{{ route('admin.patients.edit', $patient->id) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                ✏️ Edit
            </a>

            <a href="{{ route('admin.patients.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                🔙 Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="font-semibold">{{ $patient->nama }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-semibold">{{ $patient->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">No HP</p>
                <p class="font-semibold">{{ $patient->no_telp ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Jenis Kelamin</p>
                <p class="font-semibold">
                    {{ $patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Lahir</p>
                <p class="font-semibold">
                    {{ $patient->tanggal_lahir ? date('d M Y', strtotime($patient->tanggal_lahir)) : '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-2 py-1 rounded text-white text-sm
                    {{ $patient->tipe_user == 'pegawai' ? 'bg-orange-500' : 'bg-green-600' }}">
                    {{ ucfirst($patient->tipe_user) }}
                </span>
            </div>

        </div>

        <hr class="my-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <p class="text-sm text-gray-500">Berat Badan (kg)</p>
                <p class="font-semibold">{{ $patient->berat_badan ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tinggi Badan (cm)</p>
                <p class="font-semibold">{{ $patient->tinggi_badan ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">IMT</p>
                <p class="font-semibold">
                    {{ $patient->bmi ?? '-' }}
                </p>
            </div>

        </div>

        <hr class="my-6">

        <div>
            <p class="text-sm text-gray-500 mb-2">Riwayat Penyakit</p>

            @if($patient->diseases && $patient->diseases->count())
                <ul class="list-disc list-inside">
                    @foreach($patient->diseases as $d)
                        <li>{{ $d->nama }}</li>
                    @endforeach
                </ul>
            @else
                <p class="font-semibold text-gray-400">Tidak ada riwayat penyakit</p>
            @endif
        </div>

    </div>

    <hr class="my-8">

<h2 class="text-xl font-bold mb-4 text-center">
    Grafik Monitoring 7 Hari Terakhir
</h2>

<canvas id="adminChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($data->pluck('tanggal'));
const karbo = @json($data->pluck('total_karbo'));
const protein = @json($data->pluck('total_protein'));
const lemak = @json($data->pluck('total_lemak'));
const kkal = @json($data->pluck('total_kkal'));

new Chart(document.getElementById('adminChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            { label: 'Karbo', data: karbo, borderWidth: 2 },
            { label: 'Protein', data: protein, borderWidth: 2 },
            { label: 'Lemak', data: lemak, borderWidth: 2 },
            { label: 'Total Kkal', data: kkal, borderWidth: 2 }
        ]
    },
    options: {
        scales: { y: { beginAtZero: true } }
    }
});
</script>

</div>
@endsection
