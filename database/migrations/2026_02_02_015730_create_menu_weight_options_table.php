<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_weight_options', function (Blueprint $table) {
            $table->id();

            $table->string('kode_menu');
            $table->string('opsi_berat');

            $table->float('gram');

            $table->float('kkal_urt')->default(0);
            $table->float('karbo_urt')->default(0);
            $table->float('protein_urt')->default(0);
            $table->float('lemak_urt')->default(0);

            $table->timestamps();

            $table->foreign('kode_menu')
                  ->references('kode_menu')
                  ->on('menus')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_weight_options');
    }
};
