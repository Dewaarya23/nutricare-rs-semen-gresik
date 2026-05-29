<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietLog extends Model
{
    protected $fillable = [
        'user_id',
        'tujuan_diet',
        'activity_factor',
        'target_kkal',
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
}
