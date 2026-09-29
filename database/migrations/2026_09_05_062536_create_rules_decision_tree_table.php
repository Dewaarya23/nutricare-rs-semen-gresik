<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rules_decision_tree', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('rule_group'); // grup baris = 1 cabang pohon
            $table->unsignedInteger('urutan')->default(0); // urutan evaluasi/tampil

            $table->enum('parameter', [
                'glukosa_darah',
                'tekanan_darah_sistolik',
                'kolesterol',
                'usia',
            ]);

            $table->enum('operator', ['<=', '>']);
            $table->float('threshold');

            $table->enum('kategori_diet', [
                'Diet Normal',
                'Diet Diabetes Melitus',
                'Diet Hipertensi Esensial',
                'Diet Jantung Hipertensi',
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rules_decision_tree');
    }
};
