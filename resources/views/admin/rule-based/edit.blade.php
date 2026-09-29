@extends('layouts.admin')

@section('title','Edit Aturan Rule-Based')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-4">Edit Aturan Rule-Based</h1>

    <form action="{{ route('admin.rule-based.update', $rule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Kategori Diet</label>
            <select name="kategori_diet"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                @foreach(['Diet Normal','Diet Diabetes Melitus','Diet Hipertensi Esensial','Diet Jantung Hipertensi'] as $opt)
                    <option value="{{ $opt }}" @selected(old('kategori_diet', $rule->kategori_diet) == $opt)>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>
            @error('kategori_diet')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tujuan Diet</label>
            <select name="tujuan_diet"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                <option value="Menurunkan" @selected(old('tujuan_diet', $rule->tujuan_diet)=='Menurunkan')>Menurunkan Berat Badan</option>
                <option value="Stabil" @selected(old('tujuan_diet', $rule->tujuan_diet)=='Stabil')>Mempertahankan Berat Badan</option>
                <option value="Menaikkan" @selected(old('tujuan_diet', $rule->tujuan_diet)=='Menaikkan')>Menaikkan Berat Badan</option>
            </select>
            @error('tujuan_diet')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Meal Plan</label>
            <select name="meal_plan_id"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                @foreach($mealPlans as $mp)
                    <option value="{{ $mp->id }}" @selected(old('meal_plan_id', $rule->meal_plan_id)==$mp->id)>
                        {{ $mp->nama }} ({{ $mp->target_energi }} kkal)
                    </option>
                @endforeach
            </select>
            @error('meal_plan_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Rekomendasi Menu</label>
            <textarea name="rekomendasi_menu" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                      required>{{ old('rekomendasi_menu', $rule->rekomendasi_menu) }}</textarea>
            @error('rekomendasi_menu')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Anjuran (Makanan yang Dianjurkan)</label>
            <textarea name="anjuran" rows="2"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                      required>{{ old('anjuran', $rule->anjuran) }}</textarea>
            @error('anjuran')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Pantangan (Makanan yang Dibatasi)</label>
            <textarea name="pantangan" rows="2"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                      required>{{ old('pantangan', $rule->pantangan) }}</textarea>
            @error('pantangan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.rule-based.index') }}"
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
@endsection
