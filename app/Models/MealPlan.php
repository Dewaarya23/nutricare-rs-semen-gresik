<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    protected $fillable = [
        'nama',
        'target_energi',
    ];

    public function portions()
    {
        return $this->hasMany(MealPlanPortion::class);
    }

    public function ruleRuleBased()
    {
        return $this->hasMany(RuleRuleBased::class);
    }

    public function dietLogs()
    {
        return $this->hasMany(DietLog::class);
    }
}
