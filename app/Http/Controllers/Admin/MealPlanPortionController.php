<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPlan;
use App\Models\MealPlanPortion;
use Illuminate\Http\Request;

class MealPlanPortionController extends Controller
{
    protected array $kategoriOptions = [
        'K' => 'Karbohidrat',
        'PN' => 'Protein Nabati',
        'PHR' => 'Protein Hewani Rendah Lemak',
        'PHS' => 'Protein Hewani Sedang Lemak',
        'PST' => 'Protein Sedang Tinggi Lemak',
        'S' => 'Sayur',
        'BG' => 'Buah dan Gula',
        'M' => 'Minyak',
        'STL' => 'Susu Tanpa Lemak',
        'SRL' => 'Susu Rendah Lemak',
        'STIL' => 'Susu Tinggi Lemak',
    ];

    public function index($mealPlanId)
    {
        $mealPlan = MealPlan::findOrFail($mealPlanId);
        $portions = $mealPlan->portions()->orderBy('id')->get();

        return view('admin.meal-plan-portion.index', [
            'mealPlan' => $mealPlan,
            'portions' => $portions,
            'kategoriOptions' => $this->kategoriOptions,
        ]);
    }

    public function store(Request $request, $mealPlanId)
    {
        $mealPlan = MealPlan::findOrFail($mealPlanId);

        $request->validate([
            'kategori_menu' => 'required|in:' . implode(',', array_keys($this->kategoriOptions)),
            'penukar' => 'required|numeric|min:0',
            'kalori' => 'required|numeric|min:0',
        ]);

        MealPlanPortion::create([
            'meal_plan_id' => $mealPlan->id,
            'kategori_menu' => $request->kategori_menu,
            'nama_jenis' => $this->kategoriOptions[$request->kategori_menu],
            'penukar' => $request->penukar,
            'kalori' => $request->kalori,
        ]);

        return redirect()
            ->route('admin.meal-plan-portion.index', $mealPlan->id)
            ->with('success', 'Baris pembagian porsi berhasil ditambahkan');
    }

    public function update(Request $request, $mealPlanId, $portionId)
    {
        $portion = MealPlanPortion::where('meal_plan_id', $mealPlanId)->findOrFail($portionId);

        $request->validate([
            'kategori_menu' => 'required|in:' . implode(',', array_keys($this->kategoriOptions)),
            'penukar' => 'required|numeric|min:0',
            'kalori' => 'required|numeric|min:0',
        ]);

        $portion->update([
            'kategori_menu' => $request->kategori_menu,
            'nama_jenis' => $this->kategoriOptions[$request->kategori_menu],
            'penukar' => $request->penukar,
            'kalori' => $request->kalori,
        ]);

        return redirect()
            ->route('admin.meal-plan-portion.index', $mealPlanId)
            ->with('success', 'Baris pembagian porsi berhasil diperbarui');
    }

    public function destroy($mealPlanId, $portionId)
    {
        $portion = MealPlanPortion::where('meal_plan_id', $mealPlanId)->findOrFail($portionId);
        $portion->delete();

        return redirect()
            ->route('admin.meal-plan-portion.index', $mealPlanId)
            ->with('success', 'Baris pembagian porsi berhasil dihapus');
    }
}
