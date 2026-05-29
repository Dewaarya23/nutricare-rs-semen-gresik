<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $primaryKey = 'kode_menu';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_menu',
        'kategori',
        'nama_menu',
        'kkal_per_gram',
        'karbo_per_gram',
        'protein_per_gram',
        'lemak_per_gram',
    ];

    /* ===== LABEL KATEGORI ===== */
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'K'    => 'Karbohidrat',
            'PN'   => 'Protein Nabati',
            'PHR'  => 'Protein Hewani Rendah Lemak',
            'PHS'  => 'Protein Hewani Sedang Lemak',
            'PST'  => 'Protein Hewani Tinggi Lemak',
            'S'    => 'Sayuran',
            'BG'   => 'Buah & Gula',
            'M'    => 'Minyak',
            'STL'  => 'Susu Tanpa Lemak',
            'SRL'  => 'Susu Rendah Lemak',
            'STIL' => 'Susu Tinggi Lemak',
            default => 'Tidak diketahui',
        };
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu', 'kode_menu');
    }


    public function weightOptions()
    {
        return $this->hasMany(MenuWeightOption::class, 'kode_menu', 'kode_menu');
    }

    /* ===== RELASI PENYAKIT (DIKUNCI) ===== */
    public function diseases()
    {
        return $this->belongsToMany(
            Disease::class,
            'disease_menu',
            'menu_id',
            'disease_id',
            'kode_menu',
            'id'
        );
    }
}
