<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'judul',
        'gambar',
        'ringkasan',
        'isi',
        'tanggal'
    ];
}
