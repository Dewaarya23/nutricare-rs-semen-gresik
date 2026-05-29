<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(database_path('seeders/menu.csv'), 'r');

        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {

            if (count($row) < 7) {
                continue;
            }

            if (empty($row[0]) || empty($row[2]) || empty($row[3])) {
                continue;
            }

            $kode = trim($row[0]);

            preg_match('/^[A-Z]+/i', $kode, $match);
            $kategori = strtoupper($match[0] ?? '');

            $gramDasar = floatval($row[2]);

            if ($gramDasar == 0) {
                continue;
            }

            DB::table('menus')->insert([
                'kode_menu' => $kode,
                'kategori'  => $kategori,
                'nama_menu' => trim($row[1]),

                'kkal_per_gram'    => floatval($row[3]) / $gramDasar,
                'karbo_per_gram'   => floatval($row[4]),
                'protein_per_gram' => floatval($row[5]),
                'lemak_per_gram'   => floatval($row[6]),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}
