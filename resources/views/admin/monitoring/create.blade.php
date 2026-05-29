@extends('layouts.form')

@section('title','Tambah Monitoring Pasien')

@section('content')

<div class="bg-white rounded shadow p-6">

<h2 class="text-2xl font-bold text-green-700 mb-4">
    Input Monitoring Harian Pasien
</h2>

<form method="POST" action="{{ route('admin.monitoring.store') }}">
@csrf

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    <div>
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal"
               value="{{ date('Y-m-d') }}"
               class="border rounded w-full px-3 py-2">
    </div>

    <div class="relative">
    <label class="font-semibold">Nama Pasien</label>

    <input type="text"
        id="patient-search"
        placeholder="Ketik nama pasien..."
        class="border rounded w-full px-3 py-2"
        required>

    <input type="hidden" name="user_id" id="patient_id">

    <div id="patient-result"
        class="absolute left-0 right-0 bg-white border shadow-lg z-50 hidden max-h-48 overflow-y-auto">
    </div>
    </div>

</div>

@include('admin.monitoring.partials.form',['label'=>'Makan Pagi','jenis'=>'pagi'])
@include('admin.monitoring.partials.form',['label'=>'Makan Siang','jenis'=>'siang'])
@include('admin.monitoring.partials.form',['label'=>'Makan Malam','jenis'=>'malam'])

<input type="hidden" name="items" id="items">

<div class="mt-6 text-right">
<button type="submit"
        onclick="return validateForm()"
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
    💾 Simpan Monitoring
</button>

</div>

</form>
</div>

@push('scripts')
<script>
const menus = @json($menus);
window.MENUS = menus;

let patientDiseases = [];

/* ================= TAMBAH ROW ================= */
window.addRow = function (jenis) {
$('#body-'+jenis).append(`
<tr class="hover:bg-gray-50 transition">

    <td class="border border-gray-300 px-2 py-2 align-middle relative">
        <div class="relative w-full">
            <input type="text"
                   class="menu-input w-full border rounded px-2 py-1 text-sm">
            <input type="hidden" class="menu">

            <div class="autocomplete-list absolute top-full left-0 w-full bg-white border shadow-lg z-[9999] hidden max-h-48 overflow-y-auto"></div>

            <div class="warning text-red-600 text-xs mt-1"></div>
        </div>
    </td>

    <td class="border border-gray-300 px-2 py-2 align-middle relative">
        <select class="weight w-full border rounded px-2 py-1 text-sm"></select>
    </td>

    <td class="border border-gray-300 px-2 py-2 text-center align-middle">
        <input type="number"
               class="qty w-full border rounded px-2 py-1 text-center text-sm"
               value="1"
               min="0"
               step="any">
    </td>

    <td class="border border-gray-300 px-2 py-2 text-center align-middle kkal">0</td>
    <td class="border border-gray-300 px-2 py-2 text-center align-middle karbo">0</td>
    <td class="border border-gray-300 px-2 py-2 text-center align-middle protein">0</td>
    <td class="border border-gray-300 px-2 py-2 text-center align-middle lemak">0</td>

    <td class="border border-gray-300 px-2 py-2 text-center align-middle">
        <button type="button"
                class="remove text-red-600 font-bold text-sm">✕</button>
    </td>

</tr>
`);
};

/* ================= AUTOCOMPLETE ================= */
$(document).on('input','.menu-input',function(){
    let input = $(this);
    let box   = input.siblings('.autocomplete-list');
    let key   = input.val().toLowerCase();

    box.empty();
    if(key.length < 1){
        box.hide();
        return;
    }

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

/* ================= PILIH MENU ================= */
$(document).on('click','.autocomplete-list div',function(){
    let kode = $(this).data('kode');
    let m = menus.find(x=>x.kode_menu===kode);
    if(!m) return;

    let box = $(this).closest('.autocomplete-list');
    let row = box.closest('tr');

    row.find('.menu-input').val(`${m.kode_menu} — ${m.nama_menu}`);
    row.find('.menu').val(m.kode_menu);

    let opt = m.weight_options.map(w=>`
        <option
    data-g="${w.gram}"
    data-kkal="${w.kkal_urt}"
    data-karbo="${w.karbo_urt}"
    data-protein="${w.protein_urt}"
    data-lemak="${w.lemak_urt}">
            ${w.opsi_berat}
        </option>
    `).join('');

    row.find('.weight').html(opt).trigger('change');
    checkMenuWarning(row, m.kode_menu);
    box.hide();
});

/* ================= HITUNG ================= */
$(document).on('change input','.weight,.qty',function(){

    let r = $(this).closest('tr');
    let o = r.find('.weight option:selected');

    if(!o.length) return;

    let q = parseFloat(r.find('.qty').val()) || 0;

    let kode = r.find('.menu').val();
    let m = menus.find(x => x.kode_menu === kode);
    if(!m) return;

    let text = o.text().toLowerCase().trim();

    let kkal = 0;
    let karbo = 0;
    let protein = 0;
    let lemak = 0;

    let gramPerUnit = parseFloat(o.attr('data-g')) || 0;

    let totalGram = q * gramPerUnit;

    kkal    = totalGram * (parseFloat(m.kkal_per_gram) || 0);
    karbo   = totalGram * (parseFloat(m.karbo_per_gram) || 0);
    protein = totalGram * (parseFloat(m.protein_per_gram) || 0);
    lemak   = totalGram * (parseFloat(m.lemak_per_gram) || 0);

    r.find('.kkal').text(kkal.toFixed(2));
    r.find('.karbo').text(karbo.toFixed(2));
    r.find('.protein').text(protein.toFixed(2));
    r.find('.lemak').text(lemak.toFixed(2));
});

/* ================= HAPUS ================= */
$(document).on('click','.remove',function(){
    $(this).closest('tr').remove();
});

/* ================= TUTUP SAAT KLIK LUAR ================= */
$(document).on('click',function(e){
    if(!$(e.target).closest('.menu-input,.autocomplete-list').length){
        $('.autocomplete-list').hide();
    }
});

function beforeSubmit(){
    let data = {};

    ['pagi','siang','malam'].forEach(jenis=>{
        data[jenis] = [];

        $('#body-'+jenis+' tr').each(function(){
            let r = $(this);
            let kode = r.find('.menu').val();
            if(!kode) return;

            data[jenis].push({
                kode_menu : kode,
                opsi_berat: r.find('.weight option:selected').text(),
                qty       : +r.find('.qty').val(),
                gram      : +r.find('.weight option:selected').data('g') * r.find('.qty').val(),
                kkal      : +r.find('.kkal').text(),
                karbo     : +r.find('.karbo').text(),
                protein   : +r.find('.protein').text(),
                lemak     : +r.find('.lemak').text(),
            });
        });
    });

    $('#items').val(JSON.stringify(data));
}

function checkMenuWarning(row, kodeMenu){

    if(patientDiseases.length === 0){
        row.find('.warning').html('');
        return;
    }

    let menu = menus.find(m => m.kode_menu === kodeMenu);
    if(!menu || !menu.diseases){
        row.find('.warning').html('');
        return;
    }

    let forbidden = menu.diseases.map(d => d.id);

    let conflict = forbidden.filter(id =>
        patientDiseases.includes(id)
    );

    let warningBox = row.find('.warning');

    if(conflict.length > 0){

        let names = menu.diseases
            .filter(d => conflict.includes(d.id))
            .map(d => d.nama)
            .join(', ');

        warningBox.html(`
            <span class="text-sm text-red-500">
                (!) Sebaiknya dibatasi untuk kondisi : ${names}
            </span>
        `);

    } else {
        warningBox.html('');
    }
}

function validateForm() {

    if(!$('#patient_id').val()){
        alert('Silakan pilih pasien dari daftar yang muncul.');
        return false;
    }

    beforeSubmit();
    return true;
}

/* ================= LIVE SEARCH PASIEN ================= */
$('#patient-search').on('input', function () {

    let keyword = $(this).val();

    if (keyword.length < 2) {
        $('#patient-result').hide();
        return;
    }

    $.ajax({
        url: "{{ route('admin.patients.search') }}",
        method: "GET",
        data: { keyword: keyword },
        success: function (data) {

            let box = $('#patient-result');
            box.empty();

            if (data.length === 0) {
                box.hide();
                return;
            }

            data.forEach(function (p) {
                box.append(`
                    <div class="px-3 py-2 hover:bg-green-100 cursor-pointer"
                         data-id="${p.id}"
                         data-nama="${p.nama}"
                         data-diseases='${JSON.stringify(p.diseases ?? [])}'>
                        ${p.nama} (${p.jenis_kelamin})
                    </div>
                `);
            });

            box.show();
        }
    });
});

/* ================= PILIH PASIEN ================= */
$(document).on('click', '#patient-result div', function () {

    let id = $(this).data('id');
    let nama = $(this).data('nama');
    let diseases = $(this).data('diseases') || [];

    $('#patient_id').val(id);
    $('#patient-search').val(nama);

    patientDiseases = diseases.map(d => d.id);

    $('#patient-result').hide();
});

/* ================= TUTUP DROPDOWN ================= */
$(document).on('click', function(e){
    if(!$(e.target).closest('#patient-search, #patient-result').length){
        $('#patient-result').hide();
    }
});

</script>
@endpush
