<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringDetail extends Model
{
    protected $fillable = [
        'monitoring_id',
        'jenis_makan',
        'total_kkal',
        'total_karbo',
        'total_protein',
        'total_lemak',
    ];

    public function items()
    {
        return $this->hasMany(MonitoringItem::class);
    }
}
