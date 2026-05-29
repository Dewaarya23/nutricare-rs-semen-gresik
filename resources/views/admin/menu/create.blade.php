@extends('layouts.app')

@section('title','Tambah Menu')

@section('content')
<div class="p-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">Tambah Menu Gizi</h1>

    <form action="{{ route('admin.menu.store') }}" method="POST"
          class="bg-white p-4 rounded shadow space-y-4">
        @csrf

        {{-- KATEGORI --}}
        <div>
            <label class="font-semibold block mb-1">Kategori</label>
            <select name="kategori" id="kategori"
                    class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="K">Karbohidrat</option>
                <option value="PN">Protein Nabati</option>
                <option value="PHR">Protein Hewani Rendah Lemak</option>
                <option value="PHS">Protein Hewani Sedang Lemak</option>
                <option value="PST">Protein Hewani Tinggi Lemak</option>
                <option value="S">Sayuran</option>
                <option value="BG">Buah & Gula</option>
                <option value="M">Minyak</option>
                <option value="STL">Susu Tanpa Lemak</option>
                <option value="SRL">Susu Rendah Lemak</option>
                <option value="STIL">Susu Tinggi Lemak</option>
            </select>
        </div>

        {{-- KODE MENU --}}
        <div>
            <label class="font-semibold block mb-1">Kode Menu (Otomatis)</label>
            <input type="text" name="kode_menu" id="kode_menu"
                   class="w-full border p-2 rounded bg-gray-100"
                   readonly required>
        </div>

        {{-- NAMA MENU --}}
        <div>
            <label class="font-semibold block mb-1">Nama Menu</label>
            <input type="text" name="nama_menu"
                   class="w-full border p-2 rounded" required>
        </div>

        {{-- TAKARAN --}}
        <div>
            <label class="font-semibold block mb-1">
                Takaran (maks 2, salah satu WAJIB GRAM)
            </label>

            <div id="takaran-box" class="grid grid-cols-2 gap-2 mt-2"></div>

            <p id="takaran-info" class="text-sm text-red-600 mt-1 hidden">
                Wajib memilih GRAM
            </p>
        </div>

        {{-- NILAI GIZI --}}
        <div>
            <label class="font-semibold block mb-2">Nilai Gizi per 1 Gram</label>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-700 block mb-1">
                        KKal / gram
                    </label>
                    <input type="number" step="any"
                           name="kkal_per_gram"
                           class="w-full border p-2 rounded"
                           required>
                </div>

                <div>
                    <label class="text-sm text-gray-700 block mb-1">
                        Karbo / gram
                    </label>
                    <input type="number" step="any"
                           name="karbo_per_gram"
                           class="w-full border p-2 rounded"
                           required>
                </div>

                <div>
                    <label class="text-sm text-gray-700 block mb-1">
                        Protein / gram
                    </label>
                    <input type="number" step="any"
                           name="protein_per_gram"
                           class="w-full border p-2 rounded"
                           required>
                </div>

                <div>
                    <label class="text-sm text-gray-700 block mb-1">
                        Lemak / gram
                    </label>
                    <input type="number" step="any"
                           name="lemak_per_gram"
                           class="w-full border p-2 rounded"
                           required>
                </div>
            </div>
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
                        <input type="checkbox" name="diseases[]" value="{{ $d->id }}">
                        {{ $d->nama }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-between">
            <a href="{{ route('admin.menu.index') }}"
               class="px-4 py-2 bg-gray-300 rounded">
                Kembali
            </a>

            <button class="px-6 py-2 bg-green-600 text-white rounded">
                Simpan
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
const takaranMap = {
    K:['GELAS','BIJI SEDANG','POTONG SEDANG','BUAH','BUAH BESAR','IRIS','GRAM','SDM'],
    PHR:['POTONG SEDANG','GRAM'],
    PHS:['BIJI KECIL','POTONG SEDANG','BUAH SEDANG','POTONG BESAR','BULATAN','BUTIR','BUTIR KECIL','GELAS','EKOR','GRAM'],
    PST:['POTONG SEDANG','SDM','BUTIR','GRAM'],
    PN:['POTONG SEDANG','SDM','GRAM'],
    S:['GRAM'],
    BG:['BUAH KECIL','BUAH SEDANG','BUAH BESAR','BIJI','BUAH','POTONG','GELAS','SDM','GRAM'],
    STL:['GELAS','SDM','GRAM'],
    SRL:['POTONG KECIL','GELAS','SDM','GRAM'],
    STIL:['SDM','GRAM'],
    M:['SDT','SDM','POTONG KECIL','GRAM'],
};

const kategori = document.getElementById('kategori');
const box = document.getElementById('takaran-box');
const info = document.getElementById('takaran-info');

kategori.addEventListener('change', () => {
    box.innerHTML = '';
    info.classList.add('hidden');

    (takaranMap[kategori.value] || []).forEach(o => {
        box.innerHTML += `
            <label>
                <input type="checkbox" name="takaran[]" value="${o}"> ${o}
            </label>
        `;
    });

    attachLogic();

    fetch(`/admin/menu/generate-code/${kategori.value}`)
        .then(r => r.json())
        .then(d => document.getElementById('kode_menu').value = d.kode);
});

function attachLogic() {
    const checks = box.querySelectorAll('input');

    checks.forEach(c => {
        c.addEventListener('change', () => {
            let checked = [...checks].filter(x => x.checked);
            let hasGram = checked.some(x => x.value === 'GRAM');

            if (checked.length > 2) {
                c.checked = false;
                return;
            }

            if (!hasGram && checked.length === 2) {
                c.checked = false;
                info.classList.remove('hidden');
            } else {
                info.classList.add('hidden');
            }

            checks.forEach(x => {
                x.disabled = !x.checked && checked.length === 2;
            });
        });
    });
}
</script>
@endsection
