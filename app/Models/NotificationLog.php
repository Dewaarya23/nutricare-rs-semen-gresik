<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = [
        'user_id',
        'pesan',
        'status',
        'tanggal_kirim',
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
