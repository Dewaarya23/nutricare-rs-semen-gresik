<?php

namespace App\Services;

use App\Models\MealPlan;
use App\Models\RuleRuleBased;

class RuleBasedService
{
    public function findNearestMealPlan(float $targetKkal): ?MealPlan
    {
        return MealPlan::all()
            ->sortBy(fn ($mp) => abs($mp->target_energi - $targetKkal))
            ->first();
    }

    public function recommend(string $kategoriDiet, string $tujuanDiet, float $targetKkal): array
    {
        $mealPlan = $this->findNearestMealPlan($targetKkal);

        $rule = null;

        if ($mealPlan) {
            $rule = RuleRuleBased::where('kategori_diet', $kategoriDiet)
                ->where('tujuan_diet', $tujuanDiet)
                ->where('meal_plan_id', $mealPlan->id)
                ->first();
        }

        return [
            'meal_plan' => $mealPlan,
            'rule' => $rule,
        ];
    }
}
