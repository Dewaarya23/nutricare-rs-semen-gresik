@extends('layouts.user')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/icon/dashboard.png') }}"
                 class="w-10 h-10">

            <h1 class="text-2xl font-bold text-gray-800">
                Dashboard Pasien
            </h1>
        </div>

        <p class="text-gray-500 mt-1">
           Selamat datang,
{{ auth()->user()->nama ?: auth()->user()->name ?: 'Pasien' }} 👋
        </p>
    </div>


{{-- ================= ARTIKEL TERBARU (DENGAN TANGGAL) ================= --}}
@if($latestArticle)
<div class="bg-white shadow rounded-2xl p-6 mb-6 transition hover:shadow-lg">

    <h2 class="text-xl font-bold text-gray-800 mb-4">
        Artikel Terbaru
    </h2>

    <div class="flex flex-col md:flex-row gap-6">

        <div class="md:w-2/3">

            @if($latestArticle->gambar)
                <img src="{{ asset('storage/'.$latestArticle->gambar) }}"
                     class="w-full h-60 object-cover rounded-xl mb-4 shadow-sm">
            @endif

            <p class="text-sm text-gray-500 mb-1">
                {{ \Carbon\Carbon::parse($latestArticle->tanggal)->translatedFormat('d F Y') }}
            </p>

            <h3 class="text-lg font-semibold text-gray-800">
                {{ $latestArticle->judul }}
            </h3>

            <p class="text-gray-600 mt-2">
                {{ $latestArticle->ringkasan }}
            </p>

            <a href="{{ route('user.articles.show',$latestArticle->id) }}"
               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm transition">
                Info Lebih Lanjut →
            </a>

        </div>

        <div class="md:w-1/3 flex items-center justify-center">
            <a href="{{ route('user.articles.index') }}"
               class="border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-xl text-center transition">
                Lihat Artikel Lainnya
            </a>
        </div>

    </div>
</div>
@endif
{{-- ================= END ARTIKEL TERBARU ================= --}}
  {{-- CARD IMT & BBI --}}
@if($imt && $bbi)
<div class="grid md:grid-cols-3 gap-6">

    {{-- IMT --}}
    <div class="bg-white p-6 rounded-xl shadow text-center relative group">

        <img src="{{ asset('images/icon/user.png') }}"
     class="w-8 h-8 absolute top-4 right-4 opacity-80">

        <p class="text-gray-500 mb-2 flex justify-center items-center gap-2">
            IMT
            <span class="cursor-pointer text-purple-600">ℹ️</span>
        </p>

        <h2 class="text-3xl font-bold text-purple-600">
            {{ number_format($imt,2) }}
        </h2>

        <p class="mt-2 font-semibold {{ $imtColor }}">
            {{ $imtKategori }}
        </p>

        <div class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2
                    hidden group-hover:block
                    bg-gray-800 text-white text-xs
                    px-3 py-2 rounded w-64 shadow-lg">
            IMT (Indeks Massa Tubuh) adalah ukuran untuk mengetahui
            apakah berat badan Anda ideal berdasarkan tinggi badan.
        </div>
    </div>

    {{-- BBI --}}
    <div class="bg-white p-6 rounded-xl shadow text-center relative group">

        <img src="{{ asset('images/icon/weight-scale.png') }}"
     class="w-8 h-8 absolute top-4 right-4 opacity-80">

        <p class="text-gray-500 mb-2 flex justify-center items-center gap-2">
            BBI
            <span class="cursor-pointer text-orange-600">ℹ️</span>
        </p>

        <h2 class="text-3xl font-bold text-orange-600">
            {{ number_format($bbi,2) }} Kg
        </h2>

        <div class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2
                    hidden group-hover:block
                    bg-gray-800 text-white text-xs
                    px-3 py-2 rounded w-64 shadow-lg">
            BBI (Berat Badan Ideal) adalah berat badan yang disarankan
            sesuai tinggi badan untuk menjaga kesehatan optimal.
        </div>
    </div>

{{-- TARGET KKAL --}}
<div class="bg-white p-6 rounded-xl shadow text-center relative group">

    <img src="{{ asset('images/icon/calories-calculator.png') }}"
     class="w-8 h-8 absolute top-4 right-4 opacity-80">

    <p class="text-gray-500 mb-2 flex justify-center items-center gap-2">
        Target Total Kkal
        <span class="cursor-pointer text-red-600">ℹ️</span>
    </p>

    <h2 class="text-3xl font-bold text-red-600">
        {{ number_format($targetKkal,0) }} Kkal
    </h2>

    <div class="mt-4 text-sm space-y-1">

        <div class="flex justify-between border-t pt-2">
            <span class="text-purple-600 font-semibold">Karbohidrat</span>
            <span>{{ number_format($targetKarbo,0) }} gr</span>
        </div>

        <div class="flex justify-between">
            <span class="text-green-600 font-semibold">Protein</span>
            <span>{{ number_format($targetProtein,0) }} gr</span>
        </div>

        <div class="flex justify-between">
            <span class="text-orange-600 font-semibold">Lemak</span>
            <span>{{ number_format($targetLemak,0) }} gr</span>
        </div>

    </div>

    <div class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2
                hidden group-hover:block
                bg-gray-800 text-white text-xs
                px-3 py-2 rounded w-64 shadow-lg">
        Target Kalori adalah jumlah energi harian yang perlu Anda
        konsumsi untuk mencapai tujuan diet Anda.
        Distribusi makronutrien dihitung otomatis berdasarkan
        kebutuhan kalori dan tujuan diet Anda.
    </div>
</div>

</div>
@endif

    {{-- DIET, PANTANGAN, PORSI & MENU --}}
@if(($rekomendasi['status'] ?? null) === 'ok')

    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 shadow">
        <h2 class="text-lg font-bold text-gray-800 mb-4">
            Diet &amp; Alert Pantangan Makanan
        </h2>

        <div class="flex flex-col md:flex-row gap-6 md:items-start">

            <div>
                <span class="inline-block bg-red-100 text-red-700 font-semibold px-4 py-2 rounded-lg">
                    {{ $rekomendasi['kategori_diet'] }}
                </span>
            </div>

            @if($rekomendasi['rule'])
            <div class="flex-1 grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-semibold text-green-700 mb-1">Dianjurkan:</p>
                    <p class="text-gray-700">{{ $rekomendasi['rule']->anjuran }}</p>
                </div>
                <div>
                    <p class="font-semibold text-red-700 mb-1">Dibatasi:</p>
                    <p class="text-gray-700">{{ $rekomendasi['rule']->pantangan }}</p>
                </div>
            </div>
            @else
            <p class="flex-1 text-sm text-gray-500">
                Aturan rekomendasi untuk kombinasi diet ini belum tersedia.
                Silakan hubungi admin gizi.
            </p>
            @endif
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-bold text-gray-800 mb-1">
                Tabel Pembagian Porsi
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                @if($rekomendasi['meal_plan'])
                    {{ $rekomendasi['meal_plan']->nama }}
                    ({{ number_format($rekomendasi['meal_plan']->target_energi, 0) }} Kkal)
                @else
                    Meal plan belum tersedia
                @endif
            </p>

            @if($rekomendasi['portions']->isNotEmpty())
            <table class="min-w-full text-sm border border-collapse">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="p-2 border text-left">Jenis</th>
                        <th class="p-2 border">Penukar</th>
                        <th class="p-2 border">Kalori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekomendasi['portions'] as $portion)
                    <tr>
                        <td class="p-2 border">{{ $portion->nama_jenis }}</td>
                        <td class="p-2 border text-center">{{ $portion->penukar }}</td>
                        <td class="p-2 border text-center">{{ $portion->kalori }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-100 font-semibold">
                    <tr>
                        <td class="p-2 border">Total</td>
                        <td class="p-2 border text-center">{{ $rekomendasi['portions']->sum('penukar') }}</td>
                        <td class="p-2 border text-center">{{ $rekomendasi['portions']->sum('kalori') }}</td>
                    </tr>
                </tfoot>
            </table>
            @else
            <p class="text-sm text-gray-500">
                Tabel pembagian porsi untuk meal plan ini belum diisi oleh admin gizi.
            </p>
            @endif
        </div>

        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-lg font-bold text-gray-800 mb-1">
                Daftar Menu Meal Plan Hari Ini
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                Contoh pilihan makanan untuk tiap jenis pada tabel porsi
            </p>

            @if($rekomendasi['portions']->isNotEmpty())
            <div class="space-y-3 text-sm">
                @foreach($rekomendasi['portions'] as $portion)
                <div>
                    <p class="font-semibold text-gray-700">{{ $portion->nama_jenis }}</p>
                    <p class="text-gray-600">
                        {{ implode(', ', $rekomendasi['menu_contoh'][$portion->id] ?? []) ?: '-' }}
                    </p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500">
                Daftar menu akan muncul setelah tabel pembagian porsi diisi oleh admin gizi.
            </p>
            @endif
        </div>

    </div>

@else

    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-sm text-yellow-800">
        @if(($rekomendasi['status'] ?? null) === 'kategori_tidak_ditemukan')
            Kategori diet belum dapat ditentukan dari data klinis Anda.
            Silakan hubungi admin gizi.
        @else
            Lengkapi data klinis Anda (tekanan darah sistolik, glukosa darah, dan kolesterol)
            melalui menu <strong>Update/Tambah Profil</strong> agar sistem dapat menentukan
            kategori diet dan rekomendasi untuk Anda.
        @endif
    </div>

@endif

    {{-- CONTAINER GRAFIK MAKRO --}}
    <div class="bg-white p-6 rounded-xl shadow border relative">

        <img src="{{ asset('images/icon/person.png') }}"
         class="w-8 h-8 absolute top-4 left-4 opacity-80">

    <img src="{{ asset('images/icon/binoculars.png') }}"
         class="w-8 h-8 absolute top-4 right-4 opacity-80">

        {{-- FILTER --}}
        <form method="GET" class="flex justify-center gap-6 mb-6 flex-wrap">
            <div class="flex flex-col items-center">
                <label class="text-sm mb-1">Dari</label>
                <input type="date" name="from" value="{{ $from }}"
                    class="border rounded px-3 py-2">
            </div>

            <div class="flex flex-col items-center">
                <label class="text-sm mb-1">Sampai</label>
                <input type="date" name="to" value="{{ $to }}"
                    class="border rounded px-3 py-2">
            </div>

            <div class="flex items-end">
                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Filter
                </button>
            </div>
        </form>

        {{-- LABEL WARNA --}}
        <div class="flex justify-center gap-6 mb-4 text-sm font-semibold">
            <span class="text-purple-600">Karbohidrat</span>
            <span class="text-green-600">Protein</span>
            <span class="text-orange-600">Lemak</span>
        </div>

        <canvas id="nutrisiChart" height="100"></canvas>
    </div>

    {{-- CONTAINER GRAFIK TOTAL KKAL --}}
   <div class="bg-white p-6 rounded-xl shadow border relative">

    {{-- ICON KIRI --}}
    <img src="{{ asset('images/icon/independent.png') }}"
         class="w-8 h-8 absolute top-4 left-4 opacity-80">

    {{-- ICON KANAN --}}
    <img src="{{ asset('images/icon/amazed.png') }}"
         class="w-8 h-8 absolute top-4 right-4 opacity-80">

    <h2 class="text-lg font-bold text-gray-700 mb-4 text-center">
        Total Kalori Harian
    </h2>


        @if($overLimit)
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-4 text-center font-semibold">
            ⚠️ Peringatan! Asupan kalori hari ini melebihi target.
        </div>
        @endif

        <canvas id="kkalChart" height="100"></canvas>
    </div>

    <div class="flex justify-center items-center gap-2 mb-4">
        <img src="{{ asset('images/icon/medical-report.png') }}"
             class="w-7 h-7 opacity-80">

        <h2 class="text-lg font-bold text-gray-700">
            Logbook Perubahan Target Diet
        </h2>
    </div>
    <div class="overflow-x-auto">
    <table class="min-w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Mulai</th>
                <th class="p-2 border">Selesai</th>
                <th class="p-2 border">Tujuan</th>
                <th class="p-2 border">AF</th>
                <th class="p-2 border">Target Kkal</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dietLogs as $log)
            <tr class="text-center">

                <td class="p-2 border">
                        {{ $log->tanggal_mulai->format('d-m-Y H:i') }}
                    </td>

                <td class="p-2 border">
                    {{ $log->tanggal_selesai
                        ? $log->tanggal_selesai->format('d-m-Y H:i')
                        : '-' }}
                </td>

               <td class="p-2 border">{{ $log->tujuan_diet }}</td>
               <td class="p-2 border">{{ $log->activity_factor }}</td>
               <td class="p-2 border">{{ number_format($log->target_kkal,0) }}</td>

               <td class="p-2 border">
                   <form action="{{ route('user.dietlog.delete', $log->id) }}"
                         method="POST"
                         onsubmit="return confirm('Yakin ingin menghapus log ini?')">

                       @csrf
                       @method('DELETE')

                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                            Hapus
                        </button>
                   </form>
               </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
    {{ $dietLogs->links() }}
</div>

    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($data->pluck('tanggal'));

const karbo = @json($data->pluck('total_karbo'));
const protein = @json($data->pluck('total_protein'));
const lemak = @json($data->pluck('total_lemak'));
const kkal = @json($data->pluck('total_kkal'));

// GRAFIK MAKRO
new Chart(document.getElementById('nutrisiChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            { label: 'Karbohidrat', data: karbo, borderColor: 'purple', borderWidth: 2 },
            { label: 'Protein', data: protein, borderColor: 'green', borderWidth: 2 },
            { label: 'Lemak', data: lemak, borderColor: 'orange', borderWidth: 2 },

            // ===== TAMBAHAN TARGET (TIDAK MENGUBAH YANG LAIN) =====
            {
                label: 'Target Protein',
                data: Array(labels.length).fill({{ $targetProtein }}),
                borderDash: [5,5],
                borderColor: 'green',
                fill:false
            },
            {
                label: 'Target Lemak',
                data: Array(labels.length).fill({{ $targetLemak }}),
                borderDash: [5,5],
                borderColor: 'orange',
                fill:false
            },
            {
                label: 'Target Karbo',
                data: Array(labels.length).fill({{ $targetKarbo }}),
                borderDash: [5,5],
                borderColor: 'purple',
                fill:false
            }
        ]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
    y: {
        beginAtZero: true,
        title:{
            display:true,
            text:'Gram'
        }
    }
}
    }
});

// GRAFIK TOTAL KKAL
new Chart(document.getElementById('kkalChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total Kkal',
                data: kkal,
                backgroundColor: 'rgba(59,130,246,0.6)'
            },

            // ===== TAMBAHAN TARGET KKAL =====
            {
                label: 'Target Kkal',
                data: Array(labels.length).fill({{ $targetKkal }}),
                borderDash: [5,5],
                borderColor: 'red',
                fill:false
            }
        ]
    },
    options: {
        scales: {
           y: {
beginAtZero:true,
title:{
display:true,
text:'Kkal'
}
}
        }
    }
});
</script>

@endsection
