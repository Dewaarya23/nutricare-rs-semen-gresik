<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPlan;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $mealPlans = MealPlan::withCount('portions')
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('target_energi', 'like', "%$search%");
            })
            ->orderBy('target_energi')
            ->get();

        if ($request->ajax()) {
            return view('admin.meal-plan.partials.table', compact('mealPlans'))->render();
        }

        return view('admin.meal-plan.index', compact('mealPlans'));
    }

    public function create()
    {
        return view('admin.meal-plan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_energi' => 'required|numeric|min:1|unique:meal_plans,target_energi',
        ], [
            'target_energi.unique' => 'Meal plan dengan target energi ini sudah ada.',
        ]);

        MealPlan::create([
            'nama' => 'Meal Plan ' . (int) $request->target_energi,
            'target_energi' => $request->target_energi,
        ]);

        return redirect()
            ->route('admin.meal-plan.index')
            ->with('success', 'Meal Plan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mealPlan = MealPlan::findOrFail($id);

        return view('admin.meal-plan.edit', compact('mealPlan'));
    }

    public function update(Request $request, $id)
    {
        $mealPlan = MealPlan::findOrFail($id);

        $request->validate([
            'target_energi' => 'required|numeric|min:1|unique:meal_plans,target_energi,' . $mealPlan->id,
        ], [
            'target_energi.unique' => 'Meal plan dengan target energi ini sudah ada.',
        ]);

        $mealPlan->update([
            'nama' => 'Meal Plan ' . (int) $request->target_energi,
            'target_energi' => $request->target_energi,
        ]);

        return redirect()
            ->route('admin.meal-plan.index')
            ->with('success', 'Meal Plan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mealPlan = MealPlan::findOrFail($id);

        if ($mealPlan->ruleRuleBased()->exists()) {
            return back()->with('error', 'Meal Plan ini masih dipakai di aturan Rule-Based, tidak bisa dihapus.');
        }

        $mealPlan->delete();

        return redirect()
            ->route('admin.meal-plan.index')
            ->with('success', 'Meal Plan berhasil dihapus');
    }
}
