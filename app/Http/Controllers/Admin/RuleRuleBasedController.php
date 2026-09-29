<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPlan;
use App\Models\RuleRuleBased;
use Illuminate\Http\Request;

class RuleRuleBasedController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $rules = RuleRuleBased::with('mealPlan')
            ->when($search, function ($q) use ($search) {
                $q->where('kategori_diet', 'like', "%$search%")
                  ->orWhere('tujuan_diet', 'like', "%$search%");
            })
            ->orderBy('kategori_diet')
            ->orderBy('tujuan_diet')
            ->orderBy('meal_plan_id')
            ->paginate(15)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.rule-based.partials.table', compact('rules'))->render();
        }

        return view('admin.rule-based.index', compact('rules'));
    }

    public function create()
    {
        $mealPlans = MealPlan::orderBy('target_energi')->get();

        return view('admin.rule-based.create', compact('mealPlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_diet' => 'required|in:Diet Normal,Diet Diabetes Melitus,Diet Hipertensi Esensial,Diet Jantung Hipertensi',
            'tujuan_diet' => 'required|in:Menurunkan,Stabil,Menaikkan',
            'meal_plan_id' => 'required|exists:meal_plans,id',
            'rekomendasi_menu' => 'required|string',
            'anjuran' => 'required|string',
            'pantangan' => 'required|string',
        ]);

        $exists = RuleRuleBased::where('kategori_diet', $request->kategori_diet)
            ->where('tujuan_diet', $request->tujuan_diet)
            ->where('meal_plan_id', $request->meal_plan_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['meal_plan_id' => 'Kombinasi kategori diet, tujuan diet, dan meal plan ini sudah ada aturannya.']);
        }

        RuleRuleBased::create($request->only([
            'kategori_diet', 'tujuan_diet', 'meal_plan_id',
            'rekomendasi_menu', 'anjuran', 'pantangan',
        ]));

        return redirect()
            ->route('admin.rule-based.index')
            ->with('success', 'Aturan Rule-Based berhasil ditambahkan');
    }

    public function edit($id)
    {
        $rule = RuleRuleBased::findOrFail($id);
        $mealPlans = MealPlan::orderBy('target_energi')->get();

        return view('admin.rule-based.edit', compact('rule', 'mealPlans'));
    }

    public function update(Request $request, $id)
    {
        $rule = RuleRuleBased::findOrFail($id);

        $request->validate([
            'kategori_diet' => 'required|in:Diet Normal,Diet Diabetes Melitus,Diet Hipertensi Esensial,Diet Jantung Hipertensi',
            'tujuan_diet' => 'required|in:Menurunkan,Stabil,Menaikkan',
            'meal_plan_id' => 'required|exists:meal_plans,id',
            'rekomendasi_menu' => 'required|string',
            'anjuran' => 'required|string',
            'pantangan' => 'required|string',
        ]);

        $exists = RuleRuleBased::where('kategori_diet', $request->kategori_diet)
            ->where('tujuan_diet', $request->tujuan_diet)
            ->where('meal_plan_id', $request->meal_plan_id)
            ->where('id', '!=', $rule->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['meal_plan_id' => 'Kombinasi kategori diet, tujuan diet, dan meal plan ini sudah ada aturannya.']);
        }

        $rule->update($request->only([
            'kategori_diet', 'tujuan_diet', 'meal_plan_id',
            'rekomendasi_menu', 'anjuran', 'pantangan',
        ]));

        return redirect()
            ->route('admin.rule-based.index')
            ->with('success', 'Aturan Rule-Based berhasil diperbarui');
    }

    public function destroy($id)
    {
        RuleRuleBased::findOrFail($id)->delete();

        return redirect()
            ->route('admin.rule-based.index')
            ->with('success', 'Aturan Rule-Based berhasil dihapus');
    }
}
