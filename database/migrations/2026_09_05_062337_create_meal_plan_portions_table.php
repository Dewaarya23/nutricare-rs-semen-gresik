<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plan_portions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meal_plan_id')
                ->constrained('meal_plans')
                ->cascadeOnDelete();

            $table->enum('kategori_menu', [
                'K','PN','PHR','PHS','PST','S','BG','M','STL','SRL','STIL'
            ]);

            $table->string('nama_jenis');   // label tampilan, contoh: "Karbohidrat"
            $table->float('penukar');       // contoh: 3.5
            $table->float('kalori');        // contoh: 612.5

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plan_portions');
    }
};
