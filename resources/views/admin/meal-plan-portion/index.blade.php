@extends('layouts.admin')

@section('title','Tabel Pembagian Porsi')

@section('content')
<div x-data="portionPage()">

    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="{{ route('admin.meal-plan.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Master Meal Plan
            </a>
            <h1 class="text-2xl font-bold mt-1">
                Tabel Pembagian Porsi — {{ $mealPlan->nama }} ({{ $mealPlan->target_energi }} kkal)
            </h1>
            <p class="text-gray-600 text-sm">
                Rincian jenis makanan, jumlah penukar, dan kalori untuk meal plan ini
            </p>
        </div>

        <button @click="openCreate()"
                class="bg-green-600 text-white px-4 py-2 rounded h-fit">
            + Tambah Baris
        </button>
    </div>

    <table class="min-w-full bg-white border border-collapse rounded shadow overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Jenis</th>
                <th class="px-4 py-2 border">Penukar</th>
                <th class="px-4 py-2 border">Kalori</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($portions as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $p->nama_jenis }}</td>
                <td class="px-4 py-2 border text-center">{{ $p->penukar }}</td>
                <td class="px-4 py-2 border text-center">{{ $p->kalori }}</td>
                <td class="px-4 py-2 border text-center space-x-1 whitespace-nowrap">

                    <button @click='openEdit(@json($p))'
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs transition">
                        Edit
                    </button>

                    <form action="{{ route('admin.meal-plan-portion.destroy', [$mealPlan->id, $p->id]) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Yakin ingin menghapus baris ini?')">
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
                    Belum ada baris pembagian porsi untuk meal plan ini
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div x-show="showModal"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg shadow p-6 w-full max-w-md" @click.outside="showModal = false">

            <h2 class="text-lg font-bold mb-4" x-text="mode === 'create' ? 'Tambah Baris Porsi' : 'Edit Baris Porsi'"></h2>

            <form :action="formAction" method="POST">
                @csrf
                <template x-if="mode === 'edit'">
                    @method('PUT')
                </template>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Jenis Makanan</label>
                    <select name="kategori_menu" x-model="form.kategori_menu"
                            class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($kategoriOptions as $code => $label)
                            <option value="{{ $code }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Jumlah Penukar</label>
                    <input type="number" step="0.1" name="penukar" x-model="form.penukar"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Kalori</label>
                    <input type="number" step="0.1" name="kalori" x-model="form.kalori"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="showModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function portionPage() {
    return {
        showModal: false,
        mode: 'create',
        formAction: '',
        form: { kategori_menu: '', penukar: '', kalori: '' },

        openCreate() {
            this.mode = 'create';
            this.form = { kategori_menu: '', penukar: '', kalori: '' };
            this.formAction = "{{ route('admin.meal-plan-portion.store', $mealPlan->id) }}";
            this.showModal = true;
        },

        openEdit(portion) {
            this.mode = 'edit';
            this.form = {
                kategori_menu: portion.kategori_menu,
                penukar: portion.penukar,
                kalori: portion.kalori,
            };
            this.formAction = "{{ url('admin/meal-plan') }}/{{ $mealPlan->id }}/portions/" + portion.id;
            this.showModal = true;
        }
    }
}
</script>
@endsection
