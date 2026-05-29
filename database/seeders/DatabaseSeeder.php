<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
public function run(): void
{
    $this->call([
        AdminSeeder::class,
        DiseaseSeeder::class,
        MenuSeeder::class,
        MenuWeightSeeder::class,
    ]);
}
}
