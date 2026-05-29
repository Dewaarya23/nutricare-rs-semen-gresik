<div class="border rounded p-4 mb-5 bg-white shadow-sm">

<h3 class="font-semibold text-lg mb-3 text-green-700">
    {{ $label }}
</h3>

<table class="w-full border text-sm">
    <thead class="bg-green-100 text-green-800">
        <tr>
            <th class="border px-2 py-1">Menu</th>
            <th class="border px-2 py-1">Opsi Berat</th>
            <th class="border px-2 py-1">Qty</th>
            <th class="border px-2 py-1">Kkal</th>
            <th class="border px-2 py-1">Karbo</th>
            <th class="border px-2 py-1">Protein</th>
            <th class="border px-2 py-1">Lemak</th>
            <th class="border px-2 py-1">Aksi</th>
        </tr>
    </thead>

    <tbody id="body-{{ $jenis }}">
        {{-- ROW DINAMIS DARI JS --}}
    </tbody>
</table>

<button type="button"
        onclick="addRow('{{ $jenis }}')"
        class="mt-3 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
    ➕ Tambah Menu
</button>

</div>
