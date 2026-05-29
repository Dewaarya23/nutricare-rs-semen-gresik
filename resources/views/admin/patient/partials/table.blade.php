<table class="w-full border border-gray-300 bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border text-left">Nama</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Jenis Kelamin</th>
            <th class="p-2 border">BB</th>
            <th class="p-2 border">TB</th>
            <th class="p-2 border">Riwayat</th>
            <th class="p-2 border">Tipe</th>
            <th class="p-2 border">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($patients as $p)

        {{-- ROW UTAMA --}}
        <tr class="text-center hover:bg-gray-50 transition">

            <td class="p-2 border text-left font-semibold">
                {{ $p->nama }}
            </td>

            <td class="p-2 border">
                {{ $p->email }}
            </td>

            <td class="p-2 border">
                {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
            </td>

            <td class="p-2 border">
                {{ $p->berat_badan ?? '-' }}
            </td>

            <td class="p-2 border">
                {{ $p->tinggi_badan ?? '-' }}
            </td>

            {{-- Riwayat Penyakit --}}
            <td class="p-2 border text-left">
                <span class="px-2 py-1 rounded text-white text-xs
                    {{ $p->diseases->count() ? 'bg-red-500' : 'bg-gray-400' }}">
                    {{ $p->diseases->count() ? 'Ada' : 'Tidak' }}
                </span>
            </td>

            {{-- Tipe User --}}
            <td class="p-2 border">
                <span class="px-3 py-1 rounded-full text-white text-sm font-semibold
                    {{ $p->tipe_user === 'pegawai' ? 'bg-orange-500' : 'bg-green-600' }}">
                    {{ ucfirst($p->tipe_user) }}
                </span>
            </td>

            {{-- AKSI --}}
            <td class="p-2 border">
                <div class="flex justify-center gap-2 flex-wrap">

                    {{-- LIHAT --}}
                    <button type="button"
                            onclick="toggleDetail({{ $p->id }})"
                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                        Lihat
                    </button>

                    {{-- EDIT --}}
                    <a href="{{ route('admin.patients.edit',$p->id) }}"
                       class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 rounded text-sm">
                        Edit
                    </a>

                    {{-- HAPUS --}}
                    <form action="{{ route('admin.patients.destroy',$p->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                            Hapus
                        </button>
                    </form>

                </div>
            </td>
        </tr>

        {{-- ROW DETAIL (HIDDEN) --}}
        <tr id="detail-{{ $p->id }}" class="hidden bg-gray-50">
            <td colspan="8" class="p-4 text-left">
                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <p><b>Nama:</b> {{ $p->nama }}</p>
                        <p><b>Email:</b> {{ $p->email }}</p>
                        <p><b>No Telp:</b> {{ $p->no_telp ?? '-' }}</p>
                        <p><b>Tanggal Lahir:</b> {{ $p->tanggal_lahir ?? '-' }}</p>
                    </div>

                    <div>
                        <p><b>Berat Badan:</b> {{ $p->berat_badan ?? '-' }} kg</p>
                        <p><b>Tinggi Badan:</b> {{ $p->tinggi_badan ?? '-' }} cm</p>
                        <p class="mb-1"><b>Riwayat Penyakit:</b></p>

                        @if($p->diseases->count())
                            <div class="flex flex-wrap gap-1">
                                @foreach($p->diseases as $d)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded">
                                        {{ $d->nama }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400">Tidak ada riwayat penyakit</span>
                        @endif
                    </div>

                </div>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="8" class="p-4 text-center text-gray-500">
                Data pasien tidak ditemukan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $patients->links() }}
</div>

{{-- SCRIPT TOGGLE DETAIL --}}
<script>
function toggleDetail(id) {
    const row = document.getElementById('detail-' + id);
    row.classList.toggle('hidden');
}
</script>
