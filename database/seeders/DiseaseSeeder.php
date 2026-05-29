<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('diseases')->insert([
            [
                'kode_penyakit' => 'D001',
                'nama' => 'Obesitas',
            ],
            [
                'kode_penyakit' => 'D002',
                'nama' => 'Diabetes',
            ],
        ]);
    }
}
