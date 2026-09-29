@extends('layouts.admin')

@section('title','Tambah Aturan Rule-Based')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-4">Tambah Aturan Rule-Based</h1>

    <form action="{{ route('admin.rule-based.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Kategori Diet</label>
            <select name="kategori_diet"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Diet Normal" @selected(old('kategori_diet')=='Diet Normal')>Diet Normal</option>
                <option value="Diet Diabetes Melitus" @selected(old('kategori_diet')=='Diet Diabetes Melitus')>Diet Diabetes Melitus</option>
                <option value="Diet Hipertensi Esensial" @selected(old('kategori_diet')=='Diet Hipertensi Esensial')>Diet Hipertensi Esensial</option>
                <option value="Diet Jantung Hipertensi" @selected(old('kategori_diet')=='Diet Jantung Hipertensi')>Diet Jantung Hipertensi</option>
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
                <option value="">-- Pilih Tujuan --</option>
                <option value="Menurunkan" @selected(old('tujuan_diet')=='Menurunkan')>Menurunkan Berat Badan</option>
                <option value="Stabil" @selected(old('tujuan_diet')=='Stabil')>Mempertahankan Berat Badan</option>
                <option value="Menaikkan" @selected(old('tujuan_diet')=='Menaikkan')>Menaikkan Berat Badan</option>
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
                <option value="">-- Pilih Meal Plan --</option>
                @foreach($mealPlans as $mp)
                    <option value="{{ $mp->id }}" @selected(old('meal_plan_id')==$mp->id)>
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
                      required>{{ old('rekomendasi_menu') }}</textarea>
            @error('rekomendasi_menu')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Anjuran (Makanan yang Dianjurkan)</label>
            <textarea name="anjuran" rows="2"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                      required>{{ old('anjuran') }}</textarea>
            @error('anjuran')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Pantangan (Makanan yang Dibatasi)</label>
            <textarea name="pantangan" rows="2"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                      required>{{ old('pantangan') }}</textarea>
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
                    class="px-4 py-2 bg-green-600 text-white rounded">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
