@extends('layouts.admin')

@section('title','Tambah Aturan Decision Tree')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow"
     x-data="decisionTreeForm()">

    <h1 class="text-xl font-bold mb-1">Tambah Aturan Decision Tree</h1>
    <p class="text-sm text-gray-500 mb-4">
        Satu grup aturan adalah satu cabang pohon keputusan. Tambahkan
        satu atau lebih kondisi yang harus terpenuhi bersamaan (AND)
        untuk menghasilkan satu kategori diet.
    </p>

    <form action="{{ route('admin.decision-tree.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nomor Grup Aturan</label>
            <input type="number"
                   name="rule_group"
                   value="{{ old('rule_group', $nextGroup) }}"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   required>
            @error('rule_group')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Hasil Kategori Diet (THEN)</label>
            <select name="kategori_diet"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Diet Normal">Diet Normal</option>
                <option value="Diet Diabetes Melitus">Diet Diabetes Melitus</option>
                <option value="Diet Hipertensi Esensial">Diet Hipertensi Esensial</option>
                <option value="Diet Jantung Hipertensi">Diet Jantung Hipertensi</option>
            </select>
            @error('kategori_diet')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Kondisi (IF)</label>

            <template x-for="(condition, index) in conditions" :key="index">
                <div class="flex gap-2 mb-2 items-start">

                    <select :name="`conditions[${index}][parameter]`"
                            x-model="condition.parameter"
                            class="border rounded px-2 py-2 text-sm flex-1" required>
                        <option value="glukosa_darah">Glukosa Darah</option>
                        <option value="tekanan_darah_sistolik">Tekanan Darah Sistolik</option>
                        <option value="kolesterol">Kolesterol</option>
                        <option value="usia">Usia</option>
                    </select>

                    <select :name="`conditions[${index}][operator]`"
                            x-model="condition.operator"
                            class="border rounded px-2 py-2 text-sm w-20" required>
                        <option value="<=">&le;</option>
                        <option value=">">&gt;</option>
                    </select>

                    <input type="number" step="0.1"
                           :name="`conditions[${index}][threshold]`"
                           x-model="condition.threshold"
                           placeholder="Nilai"
                           class="border rounded px-2 py-2 text-sm w-28" required>

                    <button type="button"
                            @click="removeCondition(index)"
                            x-show="conditions.length > 1"
                            class="text-red-600 hover:text-red-800 px-2 py-2 text-sm">
                        &times;
                    </button>
                </div>
            </template>

            <button type="button"
                    @click="addCondition()"
                    class="text-sm text-blue-600 hover:underline mt-1">
                + Tambah Kondisi
            </button>

            @error('conditions')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.decision-tree.index') }}"
               class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded">
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
function decisionTreeForm() {
    return {
        conditions: [
            { parameter: 'glukosa_darah', operator: '<=', threshold: '' }
        ],
        addCondition() {
            this.conditions.push({ parameter: 'glukosa_darah', operator: '<=', threshold: '' });
        },
        removeCondition(index) {
            this.conditions.splice(index, 1);
        }
    }
}
</script>
@endsection
