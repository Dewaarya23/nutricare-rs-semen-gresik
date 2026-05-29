<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['email' => 'ADMINGIZI1', 'password' => 'GIZI1'],
            ['email' => 'ADMINGIZI2', 'password' => 'GIZI2'],
            ['email' => 'ADMINGIZI3', 'password' => 'GIZI3'],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['email'],
                    'password' => Hash::make($admin['password']),
                    'role' => 'admin',
                    'nama' => 'Admin Gizi',
                    'tanggal_lahir' => now(),
                    'no_telp' => '-',
                    'jenis_kelamin' => 'L',
                    'berat_badan' => 0,
                    'tinggi_badan' => 0,
                    'ada_riwayat' => 'tidak',
                ]
            );
        }
    }
}
