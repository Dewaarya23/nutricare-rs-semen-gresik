<div class="border rounded p-4 mb-5 bg-white shadow-sm">

<h3 class="font-semibold text-lg mb-3 text-green-700">
    {{ $label }}
</h3>

<div class="overflow-x-auto" style="overflow: visible;">
<table class="w-full border text-sm table-fixed relative">

    <thead class="bg-green-100 text-green-800">
        <tr>
            <th class="border px-2 py-2 w-[25%]">Menu</th>
            <th class="border px-2 py-2 w-[15%]">Opsi Berat</th>
            <th class="border px-2 py-2 w-[10%]">Qty</th>
            <th class="border px-2 py-2 w-[10%]">Kkal</th>
            <th class="border px-2 py-2 w-[10%]">Karbo</th>
            <th class="border px-2 py-2 w-[10%]">Protein</th>
            <th class="border px-2 py-2 w-[10%]">Lemak</th>
            <th class="border px-2 py-2 w-[10%]">Aksi</th>
        </tr>
    </thead>

    <tbody id="body-{{ $jenis }}"></tbody>

</table>
</div>

<button type="button"
        onclick="addRow('{{ $jenis }}')"
        class="mt-3 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
    ➕ Tambah Menu
</button>

</div>
