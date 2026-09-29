@extends('layouts.admin')

@section('title','Tambah Meal Plan')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-1">Tambah Meal Plan Baru</h1>
    <p class="text-sm text-gray-500 mb-4">
        Nama meal plan akan otomatis dibuat berdasarkan target energi yang diinput.
    </p>

    <form action="{{ route('admin.meal-plan.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Target Energi (kkal)</label>
            <input type="number" step="1"
                   name="target_energi"
                   value="{{ old('target_energi') }}"
                   placeholder="contoh: 2150"
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                   required>
            @error('target_energi')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.meal-plan.index') }}"
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
