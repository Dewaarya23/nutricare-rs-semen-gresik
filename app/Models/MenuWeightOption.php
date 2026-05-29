<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuWeightOption extends Model
{
    protected $table = 'menu_weight_options';

    protected $fillable = [
        'kode_menu',
        'opsi_berat',
        'gram',
        'kkal_urt',
        'karbo_urt',
        'protein_urt',
        'lemak_urt'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu', 'kode_menu');
    }
}
