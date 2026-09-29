<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleRuleBased extends Model
{
    protected $table = 'rules_rulebased';

    protected $fillable = [
        'kategori_diet',
        'tujuan_diet',
        'meal_plan_id',
        'rekomendasi_menu',
        'anjuran',
        'pantangan',
    ];

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }
}
