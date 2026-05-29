<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $fillable = [
        'tanggal',
        'user_id',
        'target_kkal',
        'target_karbo',
        'target_protein',
        'target_lemak',
        'total_kkal',
    ];

    public function details()
    {
        return $this->hasMany(MonitoringDetail::class, 'monitoring_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TOTAL KKAL HARIAN
    public function getTotalHarianAttribute()
    {
        return $this->details->sum('total_kkal');
    }

    // 🔒 PERSEN TERKUNCI PER TANGGAL
    public function getPersenKebutuhanAttribute()
    {
        $total = $this->total_harian;

        // 1️⃣ PRIORITAS: target yang DISIMPAN
        if ($this->target_kkal && $this->target_kkal > 0) {
            return ($total / $this->target_kkal) * 100;
        }

        // 2️⃣ FALLBACK (DATA LAMA)
        $target = optional(
            optional($this->user)->nutritionTarget
        )->target_kkal ?? 0;

        if ($target <= 0) {
            return 0;
        }

        return ($total / $target) * 100;
    }
}
