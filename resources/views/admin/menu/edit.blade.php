@extends('layouts.app')

@section('title','Edit Menu')

@section('content')
<div class="p-6 max-w-3xl">

    <h1 class="text-2xl font-bold mb-4">Edit Menu</h1>

    <form action="{{ route('admin.menu.update',$menu->kode_menu) }}"
          method="POST"
          class="bg-white p-4 rounded shadow space-y-4">


        @csrf
        @method('PUT')

        <div>
            <label class="font-semibold">Kode Menu</label>
            <input type="text"
                   class="w-full border p-2 rounded bg-gray-100"
                   value="{{ $menu->kode_menu }}"
                   readonly>
        </div>

        <div>
            <label class="font-semibold">Nama Menu</label>
            <input type="text"
                   name="nama_menu"
                   value="{{ $menu->nama_menu }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>KKal / gram</label>
                <input type="number" step="any"
                       name="kkal_per_gram"
                       value="{{ $menu->kkal_per_gram }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label>Karbo / gram</label>
                <input type="number" step="any"
                       name="karbo_per_gram"
                       value="{{ $menu->karbo_per_gram }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label>Protein / gram</label>
                <input type="number" step="any"
                       name="protein_per_gram"
                       value="{{ $menu->protein_per_gram }}"
                       class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label>Lemak / gram</label>
                <input type="number" step="any"
                       name="lemak_per_gram"
                       value="{{ $menu->lemak_per_gram }}"
                       class="w-full border p-2 rounded" required>
            </div>
        </div>

       {{-- TAKARAN --}}
<div>
    <label class="font-semibold">Takaran</label>

    @foreach($menu->weightOptions as $w)

        @php
            $opsi = strtoupper(trim($w->opsi_berat));

            $standar = match($opsi) {
                'GRAM' => '1 gram',
                'GELAS' => '± 200 gram',
                'SENDOK (SDM)' => '± 15 gram',
                'SDT' => '± 5 gram',
                'BUAH' => '± 100 gram',
                'BUAH BESAR' => '± 150 gram',
                'BUAH SEDANG' => '± 100 gram',
                'BUAH KECIL' => '± 50 gram',
                'POTONG BESAR' => '± 100 gram',
                'POTONG SEDANG' => '± 50 gram',
                'POTONG KECIL' => '± 25 gram',
                'IRIS' => '± 10 gram',
                'BUTIR' => '± 50 gram',
                'BUTIR KECIL' => '± 30 gram',
                'BIJI' => '± 50 gram',
                'BIJI SEDANG' => '± 60 gram',
                'BULATAN' => '± 100 gram',
                'EKOR' => '± 80 gram',
                default => 'Gunakan takaran wajar'
            };

            $isGram = strtolower(trim($w->opsi_berat)) === 'gram';

            $labelOpsi = !$isGram
                ? '1 ' . $w->opsi_berat
                : $w->opsi_berat;
        @endphp

        <div class="grid grid-cols-2 gap-2 mb-2 items-center">

            <div>
                <div class="font-semibold">
                    {{ $labelOpsi }}
                </div>

                {{-- INFO STANDAR --}}
                <div class="text-xs text-gray-500">
                    {{ $standar }}
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input
                    type="number"
                    step="any"
                    name="takaran[{{ $w->id }}][gram]"
                    value="{{ $w->gram }}"
                    class="border p-1 rounded w-full"
                    required
                >

                @if(!$isGram)
                    <span class="text-sm text-gray-600 font-medium">
                        g
                    </span>
                @endif
            </div>

        </div>

    @endforeach
</div>

        {{-- PENYAKIT --}}
        <div>
            <label class="font-semibold flex items-center gap-2">
                Menu yang Tidak Diperbolehkan
                <span title="Centang penyakit yang TIDAK BOLEH mengonsumsi menu ini. Jika tidak dicentang, pasien dengan penyakit tersebut BOLEH memilih menu ini."
                class="cursor-help text-red-600 font-bold">
                    (!)
                </span>
            </label>


            <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach($diseases as $d)
                    <label class="flex items-center gap-2">
                        <input type="checkbox"
                            name="diseases[]"
                            value="{{ $d->id }}"
                            {{ $menu->diseases->contains($d->id) ? 'checked' : '' }}>
                        {{ $d->nama }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.menu.index') }}"
               class="px-4 py-2 bg-gray-300 rounded">
               Kembali
            </a>

            <button class="px-6 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </div>

    </form>

</div>
@endsection
