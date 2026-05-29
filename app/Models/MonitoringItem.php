<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringItem extends Model
{
    protected $fillable = [
        'monitoring_detail_id',
        'kode_menu',
        'opsi_berat',
        'qty',
        'gram',
        'kkal',
        'karbo',
        'protein',
        'lemak'
    ];

    public function detail()
    {
        return $this->belongsTo(MonitoringDetail::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu', 'kode_menu');
    }

}
