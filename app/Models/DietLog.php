<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietLog extends Model
{
    protected $fillable = [
        'user_id',
        'tujuan_diet',
        'kategori_diet',
        'activity_factor',
        'target_kkal',
        'meal_plan_id',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }
}
