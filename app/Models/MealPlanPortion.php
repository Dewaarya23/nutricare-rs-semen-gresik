<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlanPortion extends Model
{
    protected $fillable = [
        'meal_plan_id',
        'kategori_menu',
        'nama_jenis',
        'penukar',
        'kalori',
    ];

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }
}
