@extends('layouts.form')

@section('title','Tambah Monitoring Saya')

@section('content')

<div class="bg-white rounded shadow p-6">

<h2 class="text-2xl font-bold text-green-700 mb-4">
    Input Monitoring Harian Saya
</h2>

<form method="POST"
      action="{{ route('user.monitoring.store') }}"
      id="monitoringForm">
@csrf

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    <div>
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal"
               value="{{ date('Y-m-d') }}"
               class="border rounded w-full px-3 py-2">
    </div>

</div>

@include('user.monitoring.partials.form',['label'=>'Makan Pagi','jenis'=>'pagi'])
@include('user.monitoring.partials.form',['label'=>'Makan Siang','jenis'=>'siang'])
@include('user.monitoring.partials.form',['label'=>'Makan Malam','jenis'=>'malam'])

<input type="hidden" name="items" id="items">

<div class="mt-6 text-right">
<button type="submit"
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
    💾 Simpan Monitoring
</button>
</div>

</form>
</div>

<script>
$(document).ready(function(){

window.MENUS = @json($menus);

let patientDiseases = @json(
    auth()->user()->diseases->pluck('id')
);

/* ================= TAMBAH ROW ================= */
window.addRow = function (jenis) {
   $('#body-'+jenis).append(`
<tr class="hover:bg-gray-50 transition">
    <td class="border border-gray-300 px-2 py-2">
        <div class="relative">
            <input type="text" class="menu-input w-full border rounded px-2 py-1">
            <input type="hidden" class="menu">
            <div class="autocomplete-list absolute left-0 right-0 bg-white border shadow-lg z-[9999] hidden max-h-48 overflow-y-auto"></div>
            <div class="warning text-red-600 text-xs mt-1"></div>
        </div>
    </td>

    <td class="border border-gray-300 px-2 py-2">
        <select class="weight w-full border rounded px-2 py-1"></select>
    </td>

    <td class="border border-gray-300 px-2 py-2 text-center">
        <input type="number"
               class="qty w-16 border rounded px-2 py-1 text-center"
               value="1"
               min="0"
               step="any">
    </td>

    <td class="border border-gray-300 px-2 py-2 text-center kkal">0</td>
    <td class="border border-gray-300 px-2 py-2 text-center karbo">0</td>
    <td class="border border-gray-300 px-2 py-2 text-center protein">0</td>
    <td class="border border-gray-300 px-2 py-2 text-center lemak">0</td>

    <td class="border border-gray-300 px-2 py-2 text-center">
        <button type="button" class="remove text-red-600 font-bold">✕</button>
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

    let menus = window.MENUS || [];

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

    let menus = window.MENUS || [];

    let kode = $(this).data('kode');
    let m = menus.find(x=>x.kode_menu===kode);
    if(!m) return;

    let box = $(this).closest('.autocomplete-list');
    let row = box.closest('tr');

    row.find('.menu-input').val(`${m.kode_menu} — ${m.nama_menu}`);
    row.find('.menu').val(m.kode_menu);

    let opt = (m.weight_options || []).map(w => `
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
$(document).on('input change','.weight, .qty',function(){

    let menus = window.MENUS || [];
    let row = $(this).closest('tr');
    let opt = row.find('.weight option:selected');

    if(!opt.length) return;

    let kode = row.find('.menu').val();
    let m = menus.find(x => x.kode_menu === kode);
    if(!m) return;

    let qty = parseFloat(row.find('.qty').val()) || 0;

    let gramPerUnit = parseFloat(opt.attr('data-g')) || 0;
    let totalGram = qty * gramPerUnit;

    let totalKkal    = totalGram * (parseFloat(m.kkal_per_gram) || 0);
    let totalKarbo   = totalGram * (parseFloat(m.karbo_per_gram) || 0);
    let totalProtein = totalGram * (parseFloat(m.protein_per_gram) || 0);
    let totalLemak   = totalGram * (parseFloat(m.lemak_per_gram) || 0);

    row.find('.kkal').text(totalKkal.toFixed(2));
    row.find('.karbo').text(totalKarbo.toFixed(2));
    row.find('.protein').text(totalProtein.toFixed(2));
    row.find('.lemak').text(totalLemak.toFixed(2));
});

/* ================= HAPUS ================= */
$(document).on('click','.remove',function(){
    $(this).closest('tr').remove();
});

/* ================= TUTUP AUTOCOMPLETE ================= */
$(document).on('click',function(e){
    if(!$(e.target).closest('.menu-input,.autocomplete-list').length){
        $('.autocomplete-list').hide();
    }
});

/* ================= SIAPKAN DATA ================= */
function beforeSubmit(){

    let data = {};

    ['pagi','siang','malam'].forEach(jenis=>{
        data[jenis] = [];

        $('#body-'+jenis+' tr').each(function(){

            let r = $(this);
            let kode = r.find('.menu').val();

            if(!kode) return;

            let qty = parseFloat(r.find('.qty').val()) || 0;
            let isGram = r.find('.weight option:selected').data('isgram');

            let gramPerUnit = parseFloat(r.find('.weight option:selected').attr('data-g')) || 0;

            let gram = gramPerUnit * qty;

            data[jenis].push({
                kode_menu : kode,
                opsi_berat: r.find('.weight option:selected').text().trim(),
                qty       : qty,
                gram      : gram,
                kkal      : parseFloat(r.find('.kkal').text()) || 0,
                karbo     : parseFloat(r.find('.karbo').text()) || 0,
                protein   : parseFloat(r.find('.protein').text()) || 0,
                lemak     : parseFloat(r.find('.lemak').text()) || 0,
            });
        });
    });

    $('#items').val(JSON.stringify(data));
}

/* ================= VALIDASI PENYAKIT ================= */
function checkMenuWarning(row, kodeMenu){

    let menus = window.MENUS || [];

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

/* ================= SUBMIT FORM FINAL FIX ================= */
$('#monitoringForm').on('submit', function(e){

    beforeSubmit();

    let itemsValue = $('#items').val();

    console.log("ITEMS JSON =", itemsValue);

    let parsed = JSON.parse(itemsValue || '{}');

    let totalItems =
        (parsed.pagi?.length || 0) +
        (parsed.siang?.length || 0) +
        (parsed.malam?.length || 0);

    if(totalItems === 0){
        e.preventDefault();
        alert('Silakan tambahkan minimal 1 menu terlebih dahulu.');
        return false;
    }

    return true;
});

});
</script>

@endsection
