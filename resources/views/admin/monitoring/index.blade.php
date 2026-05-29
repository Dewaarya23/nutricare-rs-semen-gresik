@extends('layouts.admin')
@section('title','Monitoring Harian')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-green-700">Monitoring Harian</h1>
            <p class="text-gray-500 text-sm">Pencatatan asupan gizi pasien per hari</p>
        </div>
        <input type="date"
               name="tanggal"
               form="formMonitoring"
               value="{{ now()->toDateString() }}"
               class="border rounded-lg px-4 py-2 text-sm font-semibold">
    </div>

    <form method="POST" action="{{ route('admin.monitoring.store') }}" id="formMonitoring">
    @csrf
    {{-- PASIEN --}}
    <div class="mb-4">
        <label class="font-semibold text-green-700">Nama Pasien</label>
        <select name="user_id"
                form="formMonitoring"
                class="w-full border rounded-lg px-3 py-2 mt-1"
                required>
            <option value="">-- Pilih Pasien --</option>
            @foreach($patients as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->jenis_kelamin }})
    </option>
            @endforeach
        </select>
    </div>

    {{-- FORM --}}
        <input type="hidden" name="items" id="itemsInput">

        @foreach(['pagi'=>'🍳 Makan Pagi','siang'=>'🍛 Makan Siang','malam'=>'🍲 Makan Malam'] as $k=>$label)
        <div class="mb-8 bg-white rounded-xl shadow-md border border-green-100 overflow-visible">

            {{-- HEADER MAKAN --}}
            <div class="bg-green-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="font-semibold text-lg">{{ $label }}</h2>
                <button type="button"
                        onclick="addRow('{{ $k }}')"
                        class="bg-yellow-300 text-green-900 px-4 py-1.5 rounded-lg font-bold hover:bg-yellow-400">
                    + Tambah Menu
                </button>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-green-50 text-green-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Menu</th>
                            <th class="px-3 py-3">Opsi Berat</th>
                            <th class="px-3 py-3 text-center">Qty</th>
                            <th class="px-3 py-3 text-center">KKAL</th>
                            <th class="px-3 py-3 text-center">Karbo</th>
                            <th class="px-3 py-3 text-center">Protein</th>
                            <th class="px-3 py-3 text-center">Lemak</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="body-{{ $k }}"></tbody>
                </table>
            </div>

            {{-- TOTAL --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-yellow-50 px-6 py-4 text-sm font-semibold text-green-800">
                <div>KKAL: <span id="tk-{{ $k }}">0</span></div>
                <div>Karbo: <span id="tc-{{ $k }}">0</span></div>
                <div>Protein: <span id="tp-{{ $k }}">0</span></div>
                <div>Lemak: <span id="tl-{{ $k }}">0</span></div>
            </div>

            {{-- SIMPAN PER MAKAN --}}
            <div class="px-6 pb-4 text-right">
                <button type="button"
                        onclick="submitMakan('{{ $k }}')"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
                    💾 Simpan {{ $label }}
                </button>
            </div>

        </div>
        @endforeach
    </form>
</div>
@endsection


{{-- ================= SCRIPT (TAMBAHAN SAJA, TIDAK UBAH HTML) ================= --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const menus = @json($menus);

/* ===== submit per makan ===== */
function submitMakan(jenis) {
    let data = {};
    data[jenis] = [];

    $('#body-' + jenis + ' tr').each(function () {
        let r = $(this);
        if (!r.find('.menu').val()) return;

        let o = r.find('.weight option:selected');

        data[jenis].push({
            kode_menu: r.find('.menu').val(),
            opsi_berat: o.val(),
            qty: +r.find('.qty').val(),
            gram: o.data('g') * r.find('.qty').val(),
            kkal: 0,
            karbo: 0,
            protein: 0,
            lemak: 0,
        });
    });

    if (data[jenis].length === 0) {
        alert('Belum ada menu di ' + jenis);
        return;
    }

    document.getElementById('itemsInput').value = JSON.stringify(data);
    document.getElementById('formMonitoring').submit();
}

/* ===== TAMBAH ROW ===== */
window.addRow = function (jenis) {
$('#body-'+jenis).append(`
<tr>
<td class="relative overflow-visible">
    <input type="text" class="menu-input w-full border rounded px-2 py-1" placeholder="Ketik menu...">
    <div class="autocomplete-list absolute bg-white border z-[9999] hidden max-h-48 overflow-y-auto shadow-lg"></div>
    <input type="hidden" class="menu">
</td>
<td><select class="weight w-full border rounded px-2 py-1"></select></td>
<td><input type="number" class="qty w-16 border rounded px-2 py-1 text-center" value="1" min="1"></td>
<td class="kkal text-center font-semibold">0</td>
<td class="karbo text-center font-semibold">0</td>
<td class="protein text-center font-semibold">0</td>
<td class="lemak text-center font-semibold">0</td>
<td class="text-center">
    <button type="button" class="remove text-red-600 font-bold">✕</button>
</td>
</tr>
`);
}

/* ===== AUTOCOMPLETE ===== */
$(document).on('input','.menu-input',function(){
let input = $(this);
let key = input.val().toLowerCase();
let box = input.siblings('.autocomplete-list');
box.empty();

if(key.length < 1){
    box.hide();
    return;
}

let offset = input.offset();
box.css({
    top: offset.top + input.outerHeight(),
    left: offset.left,
    width: input.outerWidth()
});

menus.filter(m =>
    m.nama_menu.toLowerCase().includes(key) ||
    m.kode_menu.toLowerCase().includes(key)
).slice(0,10).forEach(m=>{
    box.append(`
    <div class="px-3 py-2 hover:bg-green-100 cursor-pointer"
        data-kode="${m.kode_menu}">
        ${m.kode_menu} — ${m.nama_menu}
    </div>
    `);
});

box.show();
});

/* ===== PILIH MENU ===== */
$(document).on('click','.autocomplete-list div',function(){
let row = $(this).closest('tr');
let kode = $(this).data('kode');
let m = menus.find(x=>x.kode_menu==kode);
if(!m) return;

row.find('.menu-input').val(m.kode_menu+' — '+m.nama_menu);
row.find('.menu').val(m.kode_menu);
row.find('.autocomplete-list').hide();

if(!m.weight_options || m.weight_options.length === 0){
    row.find('.weight').html(`<option>-</option>`);
    return;
}

let opt = m.weight_options.map(w=>`
<option value="${w.opsi_berat}"
    data-g="${w.gram}"
    data-k="${w.kkal_urt}"
    data-karbo="${w.karbo_urt}"
    data-protein="${w.protein_urt}"
    data-lemak="${w.lemak_urt}">
${w.opsi_berat}
</option>
`).join('');

row.find('.weight').html(opt).trigger('change');
});

/* ===== HITUNG (FIX GRAM vs URT) ===== */
$(document).on('change input','.weight,.qty',function(){
let r=$(this).closest('tr');
let o=r.find('.weight option:selected');
if(!o.length) return;

let q = +r.find('.qty').val();
let gram = o.data('g') * q;

let m = menus.find(x=>x.kode_menu==r.find('.menu').val());
if(!m) return;

// 🔥 DETEKSI GRAM
let isGram = o.text().toLowerCase().includes('gram');

let kkal, karbo, protein, lemak;

if (isGram) {
    // ✅ HITUNG DARI GRAM
    kkal    = gram * m.kkal_per_gram;
    karbo   = gram * m.karbo_per_gram;
    protein = gram * m.protein_per_gram;
    lemak   = gram * m.lemak_per_gram;
} else {
    // ✅ HITUNG DARI URT
    kkal    = o.data('k') * q;
    karbo   = o.data('karbo') * q;
    protein = o.data('protein') * q;
    lemak   = o.data('lemak') * q;
}

r.find('.kkal').text(kkal.toFixed(2));
r.find('.karbo').text(karbo.toFixed(2));
r.find('.protein').text(protein.toFixed(2));
r.find('.lemak').text(lemak.toFixed(2));

totalAll();
});

/* ===== REMOVE ===== */
$(document).on('click','.remove',function(){
$(this).closest('tr').remove();
totalAll();
});

/* ===== TOTAL SEMUA ===== */
function totalAll(){
['pagi','siang','malam'].forEach(jenis=>{
    let tk=0,tc=0,tp=0,tl=0;

    $('#body-'+jenis+' tr').each(function(){
        let r=$(this);
        tk += +r.find('.kkal').text() || 0;
        tc += +r.find('.karbo').text() || 0;
        tp += +r.find('.protein').text() || 0;
        tl += +r.find('.lemak').text() || 0;
    });

    $('#tk-'+jenis).text(tk.toFixed(2));
    $('#tc-'+jenis).text(tc.toFixed(2));
    $('#tp-'+jenis).text(tp.toFixed(2));
    $('#tl-'+jenis).text(tl.toFixed(2));
});
}
</script>
@endpush
