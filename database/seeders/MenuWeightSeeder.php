<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuWeightSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('seeders/menu_weight_options.csv'), 'r');

        // skip header
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            DB::table('menu_weight_options')->insert([
                'kode_menu'   => trim($row[0]),
                'opsi_berat'  => trim($row[1]),
                'gram'        => floatval($row[2]),
                'kkal_urt'    => floatval($row[3]),
                'karbo_urt'   => floatval($row[4]),
                'protein_urt' => floatval($row[5]),
                'lemak_urt'   => floatval($row[6]),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        fclose($file);
    }
}
