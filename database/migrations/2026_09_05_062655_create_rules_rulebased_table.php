<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Aturan IF-THEN Rule-Based (Sub-bab 3.3.5 & Tabel 3.6-3.7 Proposal).
     * Kombinasi: kategori_diet x tujuan_diet x meal_plan -> maksimal 108 aturan
     * (4 kategori diet x 3 tujuan diet x 9 meal plan).
     */
    public function up(): void
    {
        Schema::create('rules_rulebased', function (Blueprint $table) {
            $table->id();

            $table->enum('kategori_diet', [
                'Diet Normal',
                'Diet Diabetes Melitus',
                'Diet Hipertensi Esensial',
                'Diet Jantung Hipertensi',
            ]);

            $table->enum('tujuan_diet', ['Menurunkan', 'Stabil', 'Menaikkan']);

            $table->foreignId('meal_plan_id')
                ->constrained('meal_plans')
                ->cascadeOnDelete();

            $table->text('rekomendasi_menu');  // deskripsi/daftar menu harian
            $table->text('anjuran');           // makanan yang dianjurkan
            $table->text('pantangan');         // makanan yang dibatasi

            $table->timestamps();

            $table->unique(
                ['kategori_diet', 'tujuan_diet', 'meal_plan_id'],
                'rules_rulebased_kombinasi_unik'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rules_rulebased');
    }
};
