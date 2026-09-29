<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diet_logs', function (Blueprint $table) {
            $table->enum('kategori_diet', [
                'Diet Normal',
                'Diet Diabetes Melitus',
                'Diet Hipertensi Esensial',
                'Diet Jantung Hipertensi',
            ])->nullable()->after('tujuan_diet');

            $table->foreignId('meal_plan_id')
                ->nullable()
                ->after('target_kkal')
                ->constrained('meal_plans')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('diet_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('meal_plan_id');
            $table->dropColumn('kategori_diet');
        });
    }
};
