<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tipe_user',
        'photo',

        // DATA PASIEN
        'nama',
        'tanggal_lahir',
        'no_telp',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'ada_riwayat',
        'defisit',
        'activity_factor',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // =======================
    // RELASI PENYAKIT
    // =======================
    public function diseases()
    {
        return $this->belongsToMany(
            \App\Models\Disease::class,
            'disease_user',
            'user_id',
            'disease_id'
        );
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }

    public function nutritionTarget()
    {
        return $this->hasOne(NutritionTarget::class);
    }

    public function dietLogs()
    {
        return $this->hasMany(\App\Models\DietLog::class);
    }

}
