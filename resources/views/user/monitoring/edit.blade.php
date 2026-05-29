@extends('layouts.form')

@section('title','Edit Monitoring Pasien')

@section('content')

<div class="bg-white rounded shadow p-6">

<h2 class="text-2xl font-bold text-green-700 mb-4">
    Edit Monitoring Harian
</h2>

<form method="POST"
      action="{{ route('user.monitoring.update',$monitoring->id) }}">
    @csrf
    @method('PUT')

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    <div>
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal"
               value="{{ $monitoring->tanggal }}"
               class="border rounded w-full px-3 py-2">
    </div>

    {{-- USER TIDAK PERLU PILIH PASIEN --}}
    <input type="hidden"
           name="user_id"
           value="{{ auth()->id() }}">

</div>

@include('user.monitoring.partials.form',['label'=>'Makan Pagi','jenis'=>'pagi'])
@include('user.monitoring.partials.form',['label'=>'Makan Siang','jenis'=>'siang'])
@include('user.monitoring.partials.form',['label'=>'Makan Malam','jenis'=>'malam'])

<input type="hidden" name="items" id="items">

<div class="mt-6 text-right">
<button type="submit"
        onclick="return validateForm()"
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
        💾 Update Monitoring
    </button>
</div>

</form>
</div>


@push('scripts')
<script>

const menus = @json($menus);
let patientDiseases = @json(auth()->user()->diseases->pluck('id'));

/* ================= DETEKSI PERUBAHAN FORM ================= */

let formChanged = false;

// jika user mengubah input atau select
$(document).on('input change','input,select',function(){
    formChanged = true;
});

// jika user menutup / refresh halaman
window.addEventListener("beforeunload", function (e) {

    if(!formChanged) return;

    e.preventDefault();
    e.returnValue = '';
});

/* ================= DATA LAMA ================= */
const existing = @json(
    $monitoring->details->mapWithKeys(function($d){
        return [$d->jenis_makan => $d->items];
    })
);

/* ================= TAMBAH ROW ================= */
window.addRow = function (jenis, item = null) {

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
               value=""
               step="any"
               min="0">
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

    formChanged = true;

    if(item){
    let r = $('#body-'+jenis+' tr:last');
    let m = menus.find(x => x.kode_menu === item.kode_menu);
    if(!m) return;

    r.find('.menu-input').val(m.kode_menu + ' — ' + m.nama_menu);
    r.find('.menu').val(item.kode_menu);

    let opt = m.weight_options.map(w => `
        <option value="${w.opsi_berat}"
            data-g="${w.gram}"
            data-isgram="${w.is_gram}"
            data-kkal="${w.kkal_urt}"
            data-karbo="${w.karbo_urt}"
            data-protein="${w.protein_urt}"
            data-lemak="${w.lemak_urt}"
            ${w.opsi_berat.trim().toUpperCase() === item.opsi_berat.trim().toUpperCase() ? 'selected' : ''}>
            ${w.opsi_berat}
        </option>
    `).join('');

    r.find('.weight').html(opt);
    r.find('.qty').val(item.qty);

    setTimeout(() => {
        r.find('.weight').trigger('change');
    }, 50);

    checkMenuWarning(r, item.kode_menu);
}
};

/* ================= AUTOCOMPLETE ================= */
$(document).on('input','.menu-input',function(){
    let input = $(this);
    let box   = input.siblings('.autocomplete-list');
    let key   = input.val().toLowerCase();

    box.empty();
    if(key.length < 1){
        box.hide(); return;
    }

    menus.filter(m =>
        m.nama_menu.toLowerCase().includes(key) ||
        m.kode_menu.toLowerCase().includes(key)
    ).slice(0,10).forEach(m=>{
        box.append(`
        <div class="px-3 py-2 hover:bg-green-100 cursor-pointer"
             data-kode="${m.kode_menu}">
            ${m.kode_menu} — ${m.nama_menu}
        </div>`);
    });

    box.show();
});

/* ================= PILIH MENU ================= */
$(document).on('click','.autocomplete-list div',function(){
    let kode = $(this).data('kode');
    let m = menus.find(x => x.kode_menu === kode);
    if(!m) return;

    let box = $(this).closest('.autocomplete-list');
    let row = box.closest('tr');

    row.find('.menu-input').val(`${m.kode_menu} — ${m.nama_menu}`);
    row.find('.menu').val(m.kode_menu);

    let opt = m.weight_options.map((w, index) => `
        <option value="${w.opsi_berat}"
            data-g="${w.gram}"
            data-isgram="${w.is_gram}"
            data-kkal="${w.kkal_urt}"
            data-karbo="${w.karbo_urt}"
            data-protein="${w.protein_urt}"
            data-lemak="${w.lemak_urt}"
            ${index === 0 ? 'selected' : ''}>
            ${w.opsi_berat}
        </option>
    `).join('');

    row.find('.weight').html(opt).trigger('change');
    checkMenuWarning(row, m.kode_menu);

    box.hide();
    formChanged = true;
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
    formChanged = true;
});

/* ================= PRELOAD DATA ================= */
Object.keys(existing).forEach(jenis=>{
    existing[jenis].forEach(item=>{
        addRow(jenis,item);
    });
});

/* ================= SUBMIT ================= */
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

function validateForm() {
    beforeSubmit();
    formChanged = false;
    return true;
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

</script>
@endpush

@endsection
