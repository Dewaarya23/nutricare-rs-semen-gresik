<table class="min-w-full bg-white border border-collapse rounded shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Grup</th>
            <th class="px-4 py-2 border">Kondisi (IF)</th>
            <th class="px-4 py-2 border">Hasil Kategori Diet</th>
            <th class="px-4 py-2 border">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($groups as $ruleGroup => $conditions)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border text-center font-semibold">
                {{ $ruleGroup }}
            </td>
            <td class="px-4 py-2 border">
                <ul class="list-disc ml-4 text-sm">
                    @foreach($conditions as $condition)
                    <li>
                        {{ $condition->parameter }}
                        {{ $condition->operator }}
                        {{ $condition->threshold }}
                    </li>
                    @endforeach
                </ul>
            </td>
            <td class="px-4 py-2 border text-center">
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded">
                    {{ $conditions->first()->kategori_diet }}
                </span>
            </td>
            <td class="px-4 py-2 border text-center space-x-1 whitespace-nowrap">
                <a href="{{ route('admin.decision-tree.edit', $ruleGroup) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition">
                    Edit
                </a>

                <form action="{{ route('admin.decision-tree.destroy', $ruleGroup) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus grup aturan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs transition">
                        Hapus
                    </button>
                </form>
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
