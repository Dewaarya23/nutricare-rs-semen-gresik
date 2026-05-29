<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            // karena menus primary key = kode_menu (string)
            $table->string('menu_id');
            $table->foreign('menu_id')
                ->references('kode_menu')
                ->on('menus')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->enum('waktu_makan', ['pagi', 'siang', 'malam']);
            $table->float('jumlah');
            $table->float('gram_total');
            $table->float('kkal_total');
            $table->float('karbo_total');
            $table->float('protein_total');
            $table->float('lemak_total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_logs');
    }
};
