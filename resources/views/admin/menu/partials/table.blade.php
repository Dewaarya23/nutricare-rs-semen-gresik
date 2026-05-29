@php
    $keyword = request('search');
@endphp

<table class="w-full border border-gray-300 bg-white rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">Kode</th>
            <th class="p-2 border">Kategori</th>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">KKal/g</th>
            <th class="p-2 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($menus as $m)
        <tr class="text-center">
            <td class="p-2 border">{{ $m->kode_menu }}</td>
            <td class="p-2 border">{{ $m->kategori_label }}</td>

            {{-- HIGHLIGHT SEARCH --}}
            <td class="p-2 border text-left">
                @if($keyword)
                    {!! preg_replace(
                        "/(" . preg_quote($keyword, '/') . ")/i",
                        '<span class="bg-yellow-200 font-semibold">$1</span>',
                        e($m->nama_menu)
                    ) !!}
                @else
                    {{ $m->nama_menu }}
                @endif
            </td>

            <td class="p-2 border">{{ number_format($m->kkal_per_gram, 2) }}</td>

            <td class="p-2 border flex justify-center gap-2">
                <a href="{{ route('admin.menu.edit',$m->kode_menu) }}"
                   class="px-3 py-1 bg-yellow-400 rounded">
                    Edit
                </a>

                <form action="{{ route('admin.menu.destroy',$m->kode_menu) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus menu ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="p-4 text-center text-gray-500">
                Data menu kosong
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $menus->links() }}
</div>
