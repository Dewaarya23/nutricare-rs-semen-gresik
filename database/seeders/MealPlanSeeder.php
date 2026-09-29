<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MealPlan;

class MealPlanSeeder extends Seeder
{
    public function run(): void
    {
        $mealPlans = [1250, 1350, 1450, 1550, 1650, 1750, 1850, 1950, 2050];

        foreach ($mealPlans as $kkal) {
            MealPlan::updateOrCreate(
                ['target_energi' => $kkal],
                ['nama' => 'Meal Plan ' . $kkal]
            );
        }
    }
}
