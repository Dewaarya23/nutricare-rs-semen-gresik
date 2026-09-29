<table class="min-w-full bg-white border border-collapse rounded shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Nama</th>
            <th class="px-4 py-2 border">Target Energi</th>
            <th class="px-4 py-2 border">Jumlah Baris Porsi</th>
            <th class="px-4 py-2 border">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($mealPlans as $mp)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border">
                {{ $mp->nama }}
            </td>
            <td class="px-4 py-2 border text-center">
                {{ $mp->target_energi }} kkal
            </td>
            <td class="px-4 py-2 border text-center">
                {{ $mp->portions_count }} baris
            </td>
            <td class="px-4 py-2 border text-center space-x-1 whitespace-nowrap">

                <a href="{{ route('admin.meal-plan-portion.index', $mp->id) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs transition">
                    Kelola Porsi
                </a>

                <a href="{{ route('admin.meal-plan.edit', $mp->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition">
                    Edit
                </a>

                <form action="{{ route('admin.meal-plan.destroy', $mp->id) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus meal plan ini? Semua baris porsi di dalamnya akan ikut terhapus.')">
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
