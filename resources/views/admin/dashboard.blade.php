@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">Dashboard Admin Gizi</h1>

<div class="flex items-center gap-8 mb-8">

    {{-- FOTO PROFIL --}}
    <div class="text-center">

        <form action="{{ route('admin.profile.update') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <label class="cursor-pointer block">
                <img
                    src="{{ Auth::user()->photo
                        ? asset('storage/' . Auth::user()->photo)
                        : asset('images/default-avatar.png') }}"
                    class="w-28 h-28 rounded-full object-cover shadow-lg border-4 border-white hover:scale-105 transition"
                >
                <input type="file"
                       name="photo"
                       class="hidden"
                       onchange="this.form.submit()">
            </label>
        </form>

        @if(Auth::user()->photo)
        <form action="{{ route('admin.profile.delete') }}"
              method="POST"
              class="mt-3">
            @csrf
            @method('DELETE')
            <button class="text-sm text-red-600 hover:underline">
                Hapus Foto
            </button>
        </form>
        @endif

        <p class="text-xs text-gray-400 mt-2">
            Klik foto untuk mengganti
        </p>

    </div>

    {{-- TEKS SAMBUTAN --}}
    <div>
        <p class="text-3xl font-bold bg-blue-600 bg-clip-text text-transparent">
            Selamat datang {{ Auth::user()->name ?? Auth::user()->nama }}
        </p>
        <p class="text-base text-gray-600 mt-2">
            Anda sedang berada di Dashboard Administrator Sistem Gizi.
        </p>
    </div>

</div>


{{-- ===================== KOTAK STATISTIK ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-5 rounded-xl shadow text-center">
        <h2 class="text-sm text-gray-500">Total Menu</h2>
        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalMenu }}
        </p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-center">
        <h2 class="text-sm text-gray-500">Total Pasien</h2>
        <p class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalPasien }}
        </p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-center">
        <h2 class="text-sm text-gray-500">Total Penyakit</h2>
        <p class="text-3xl font-bold text-red-600 mt-2">
            {{ $totalPenyakit }}
        </p>
    </div>

</div>


{{-- ===================== IMT & BBI ===================== --}}
@if($imt && $bbi)
<div class="flex justify-center mt-10">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full md:w-2/3">

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h2 class="text-sm text-gray-500">
                IMT {{ strtoupper(Auth::user()->name ?? Auth::user()->nama) }}
            </h2>
            <p class="text-3xl font-bold text-purple-600 mt-2">
                {{ number_format($imt,2) }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h2 class="text-sm text-gray-500">
                BBI {{ strtoupper(Auth::user()->name ?? Auth::user()->nama) }}
            </h2>
            <p class="text-3xl font-bold text-orange-600 mt-2">
                {{ number_format($bbi,2) }} Kg
            </p>
        </div>

    </div>

</div>
@endif



{{-- ===================== GRAFIK MONITORING ===================== --}}
<div class="bg-white p-6 rounded-xl shadow mt-10">

    <h2 class="text-lg font-semibold mb-4">
        Grafik Monitoring Pasien (7 Hari Terakhir)
    </h2>

    {{-- 🔥 LIVE SEARCH DROPDOWN --}}
    <form method="GET" class="mb-4">
    <input
        type="text"
        name="user_name"
        list="pasienList"
        placeholder="Ketik nama pasien..."
        class="w-full border rounded px-3 py-2"
        autocomplete="off"
        value="{{ request('user_name') }}"
    >

    <datalist id="pasienList">
        @foreach($pasienList as $pasien)
            <option value="{{ $pasien->name ?? $pasien->nama }}">
        @endforeach
    </datalist>

    {{-- Hidden untuk kirim ID --}}
    <input type="hidden" name="user_id" id="selectedUserId" value="{{ $selectedUserId }}">
</form>


    <canvas id="monitoringChart"></canvas>

</div>



{{-- ===================== CDN ===================== --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



{{-- ===================== SCRIPT ===================== --}}
<script>
    // 🔥 Chart
    const labels = {!! json_encode($monitoringData->pluck('tanggal')) !!};
    const data = {!! json_encode($monitoringData->pluck('total_kkal')) !!};

    const ctx = document.getElementById('monitoringChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Kalori',
                    data: data,
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

</script>

<script>
    const input = document.querySelector('input[name="user_name"]');
    const hiddenId = document.getElementById('selectedUserId');

    const pasienData = @json($pasienList);

    input.addEventListener('change', function() {

        // ✅ Kalau input dikosongkan
        if (this.value.trim() === "") {
            hiddenId.value = "";
            this.form.submit();
            return;
        }

        const selected = pasienData.find(p =>
            (p.name || p.nama) === this.value
        );

        if (selected) {
            hiddenId.value = selected.id;
            this.form.submit();
        } else {
            hiddenId.value = "";
        }
    });
</script>

@endsection
