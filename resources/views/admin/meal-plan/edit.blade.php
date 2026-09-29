@extends('layouts.admin')

@section('title','Edit Meal Plan')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-xl font-bold mb-4">Edit Meal Plan</h1>

    <form action="{{ route('admin.meal-plan.update', $mealPlan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Target Energi (kkal)</label>
            <input type="number" step="1"
                   name="target_energi"
                   value="{{ old('target_energi', $mealPlan->target_energi) }}"
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
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
