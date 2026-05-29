<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionTarget extends Model
{
    protected $fillable = [
        'user_id',
        'target_kkal',
        'target_karbo',
        'target_protein',
        'target_lemak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
