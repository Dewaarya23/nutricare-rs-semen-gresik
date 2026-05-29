<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Disease extends Model
{
    protected $fillable = ['kode_penyakit','nama'];

    public function menus()
    {
        return $this->belongsToMany(
            Menu::class,
            'disease_menu',
            'disease_id',
            'menu_id',
            'id',
            'kode_menu'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'disease_user',
            'disease_id',
            'user_id'
        );
    }

}
