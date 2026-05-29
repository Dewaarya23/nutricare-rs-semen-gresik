<table class="min-w-full bg-white border rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Kode</th>
            <th class="px-4 py-2 border">Nama Penyakit</th>
            <th class="px-4 py-2 border">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($diseases as $i => $disease)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border text-center">
                {{ $diseases->firstItem() + $i }}
            </td>
            <td class="px-4 py-2 border">
                {{ $disease->kode_penyakit }}
            </td>
            <td class="px-4 py-2 border">
                {{ $disease->nama }}
            </td>
            <td class="px-4 py-2 border text-center space-x-1">

                {{-- LIHAT DROPDOWN --}}
                <button onclick="toggleDetail({{ $disease->id }})"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs transition">
                    Lihat
                </button>

                {{-- EDIT --}}
                <a href="{{ route('admin.diseases.edit', $disease->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition">
                    Edit
                </a>

                {{-- HAPUS (FORM DELETE ASLI LARAVEL) --}}
                <form action="{{ route('admin.diseases.destroy', $disease->id) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus data penyakit ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs transition">
                        Hapus
                    </button>
                </form>

            </td>
        </tr>

        {{-- DETAIL DROPDOWN --}}
        <tr id="detail-{{ $disease->id }}" class="hidden bg-gray-50">
            <td colspan="4" class="px-6 py-4 border">
                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <p class="font-semibold text-gray-600">Kode Penyakit</p>
                        <p>{{ $disease->kode_penyakit }}</p>
                    </div>

                    <div>
                        <p class="font-semibold text-gray-600">Nama Penyakit</p>
                        <p>{{ $disease->nama }}</p>
                    </div>

                    <div class="col-span-2">
                        <p class="font-semibold text-gray-600">Menu Terkait</p>

                        @if($disease->menus->count())
                            <ul class="list-disc ml-5">
                                @foreach($disease->menus as $menu)
                                    <li>{{ $menu->nama_menu }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="italic text-gray-400">
                                Belum ada menu terkait
                            </p>
                        @endif
                    </div>

                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center py-6 text-gray-500">
                Data tidak ditemukan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $diseases->links() }}
</div>

<script>
function toggleDetail(id) {
    const row = document.getElementById('detail-' + id);
    row.classList.toggle('hidden');
}
</script>
