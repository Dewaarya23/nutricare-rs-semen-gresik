@extends('layouts.admin')

@section('title','Edit Aturan Decision Tree')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow"
     x-data="decisionTreeForm()">

    <h1 class="text-xl font-bold mb-1">Edit Aturan Decision Tree (Grup {{ $ruleGroup }})</h1>
    <p class="text-sm text-gray-500 mb-4">
        Ubah kondisi (IF) dan/atau hasil kategori diet (THEN) untuk grup aturan ini.
    </p>

    <form action="{{ route('admin.decision-tree.update', $ruleGroup) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nomor Grup Aturan</label>
            <input type="text"
                   value="{{ $ruleGroup }}"
                   class="w-full border rounded px-3 py-2 bg-gray-100"
                   readonly>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Hasil Kategori Diet (THEN)</label>
            <select name="kategori_diet"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                @foreach(['Diet Normal','Diet Diabetes Melitus','Diet Hipertensi Esensial','Diet Jantung Hipertensi'] as $opt)
                    <option value="{{ $opt }}" @selected(old('kategori_diet', $kategoriDiet) == $opt)>
                        {{ $opt }}
                    </option>
                @endforeach
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

        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.decision-tree.index') }}"
               class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </div>
    </form>
</div>

<script>
function decisionTreeForm() {
    return {
        conditions: @json($conditionsForJs),
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
