/* =========================================================
| MONITORING.JS - FINAL AMAN
| SESUAI MonitoringController (JSON items)
========================================================= */

let items = {
    pagi: [],
    siang: [],
    malam: []
};

/* ===================== DATA GLOBAL MENU ===================== */
/*
WAJIB: kirim dari blade:

<script>
window.MENUS = @json($menus);
</script>
*/
const MENUS = window.MENUS || [];

/* ===================== ADD ROW ===================== */
window.addRow = function (jenis) {

    const tbody = document.getElementById(`${jenis}-rows`);
    if (!tbody) {
        console.error('Tbody tidak ditemukan:', jenis);
        return;
    }

    const index = items[jenis].length;

    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td class="border px-2 py-1">
            <input type="text"
                   class="menu-input border rounded w-full px-2 py-1"
                   placeholder="Kode / Nama Menu">
        </td>

        <td class="border px-2 py-1">
            <select class="opsi-berat border rounded w-full px-2 py-1">
                <option value="">-- pilih --</option>
            </select>
        </td>

        <td class="border px-2 py-1">
            <input type="number"
                   class="qty border rounded w-full px-2 py-1"
                   value="1" min="1">
        </td>

        <td class="border px-2 py-1 kkal text-center">0</td>

        <td class="border px-2 py-1 text-center">
            <button type="button"
                    class="hapus bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                Hapus
            </button>
        </td>
    `;

    tbody.appendChild(tr);

    items[jenis].push({
        kode_menu: '',
        opsi_berat: '',
        qty: 1,
        gram: 0,
        kkal: 0,
        karbo: 0,
        protein: 0,
        lemak: 0,
        menu: null // 🔥 TAMBAHAN
    });

    bindRowEvent(tr, jenis, index);
};

/* ===================== BIND EVENT ===================== */
function bindRowEvent(row, jenis, index) {

    const menuInput = row.querySelector('.menu-input');
    const opsiBerat = row.querySelector('.opsi-berat');
    const qtyInput  = row.querySelector('.qty');
    const kkalCell  = row.querySelector('.kkal');
    const hapusBtn  = row.querySelector('.hapus');

    /* MENU DIPILIH */
    menuInput.addEventListener('change', () => {

        const menu = MENUS.find(m => m.kode_menu === menuInput.value);

        if (!menu) return;

        items[jenis][index].kode_menu = menu.kode_menu;
        items[jenis][index].menu = menu;

        // 🔥 isi dropdown opsi berat
        opsiBerat.innerHTML = '<option value="">-- pilih --</option>';
        menu.weight_options.forEach(opt => {
            opsiBerat.innerHTML += `
                <option value="${opt.gram}">
                    ${opt.opsi_berat}
                </option>
            `;
        });

        updateHidden();
    });

    /* OPSI BERAT */
    opsiBerat.addEventListener('change', () => {
        items[jenis][index].opsi_berat = opsiBerat.value;
        hitung(jenis, index, kkalCell);
    });

    /* QTY */
    qtyInput.addEventListener('input', () => {
        items[jenis][index].qty = parseFloat(qtyInput.value) || 1;
        hitung(jenis, index, kkalCell);
    });

    /* HAPUS */
    hapusBtn.addEventListener('click', () => {
        row.remove();
        items[jenis].splice(index, 1);
        updateHidden();
    });
}

/* ===================== HITUNG ===================== */
function hitung(jenis, index, kkalCell) {

    let item = items[jenis][index];
    let row = document.querySelectorAll(`#${jenis}-rows tr`)[index];

    const opsi = row.querySelector('.opsi-berat');
    const selected = opsi.options[opsi.selectedIndex];

    if (!item.menu || !selected.value) return;

    const gramOpsi = parseFloat(selected.value);
    const qty = item.qty;

    // 🔥 TOTAL GRAM
    const totalGram = qty * gramOpsi;
    item.gram = totalGram;

    // 🔥 CEK APAKAH GRAM ATAU URT
    const opsiText = selected.text.trim().toLowerCase();
    const isGram = opsiText === 'gram';

    if (isGram) {
        // ✅ kalau GRAM → pakai per gram
        item.kkal   = totalGram * item.menu.kkal_per_gram;
        item.karbo  = totalGram * item.menu.karbo_per_gram;
        item.protein= totalGram * item.menu.protein_per_gram;
        item.lemak  = totalGram * item.menu.lemak_per_gram;

    } else {
        // ✅ kalau URT (gelas, potong, dll) → pakai per URT
        item.kkal   = qty * item.menu.kkal_per_urt;
        item.karbo  = qty * item.menu.karbo_per_urt;
        item.protein= qty * item.menu.protein_per_urt;
        item.lemak  = qty * item.menu.lemak_per_urt;
    }

    kkalCell.innerText = item.kkal.toFixed(2);

    updateHidden();
}

/* ===================== UPDATE HIDDEN ===================== */
function updateHidden() {
    const input = document.getElementById('items');
    if (input) {
        input.value = JSON.stringify(items);
    }
}

/* ===================== SUBMIT ===================== */
document.addEventListener('submit', function () {
    updateHidden();
});
