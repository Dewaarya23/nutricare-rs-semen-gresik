<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disease_menu', function (Blueprint $table) {
            $table->id();

            $table->string('menu_id');
            $table->foreign('menu_id')
                ->references('kode_menu')
                ->on('menus')
                ->cascadeOnDelete();

            $table->foreignId('disease_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['menu_id','disease_id']); // 🔐 KUNCI
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disease_menu');
    }
};
