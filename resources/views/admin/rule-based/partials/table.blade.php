<table class="min-w-full bg-white border border-collapse rounded shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Kategori Diet</th>
            <th class="px-4 py-2 border">Tujuan Diet</th>
            <th class="px-4 py-2 border">Meal Plan</th>
            <th class="px-4 py-2 border">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rules as $i => $rule)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border text-center">
                {{ $rules->firstItem() + $i }}
            </td>
            <td class="px-4 py-2 border">
                {{ $rule->kategori_diet }}
            </td>
            <td class="px-4 py-2 border text-center">
                {{ $rule->tujuan_diet }}
            </td>
            <td class="px-4 py-2 border text-center">
                {{ $rule->mealPlan->nama ?? '-' }}
            </td>
            <td class="px-4 py-2 border text-center space-x-1 whitespace-nowrap">

                <button onclick="toggleDetail({{ $rule->id }})"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs transition">
                    Lihat
                </button>

                <a href="{{ route('admin.rule-based.edit', $rule->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition">
                    Edit
                </a>

                <form action="{{ route('admin.rule-based.destroy', $rule->id) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus aturan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs transition">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

        <tr id="detail-{{ $rule->id }}" class="hidden bg-gray-50">
            <td colspan="5" class="px-6 py-4 border">
                <div class="grid grid-cols-1 gap-3 text-sm">
                    <div>
                        <p class="font-semibold text-gray-600">Rekomendasi Menu</p>
                        <p>{{ $rule->rekomendasi_menu }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Anjuran</p>
                        <p>{{ $rule->anjuran }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Pantangan</p>
                        <p>{{ $rule->pantangan }}</p>
                    </div>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-6 text-gray-500">
                Data tidak ditemukan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $rules->links() }}
</div>

<script>
function toggleDetail(id) {
    const row = document.getElementById('detail-' + id);
    row.classList.toggle('hidden');
}
</script>
