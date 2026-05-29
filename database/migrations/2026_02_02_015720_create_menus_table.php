<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('kode_menu')->primary();

            $table->enum('kategori', [
                'K','PN','PHR','PHS','PST','S','BG','M','STL','SRL','STIL'
            ]);

            $table->string('nama_menu');

            $table->float('kkal_per_gram');
            $table->float('karbo_per_gram');
            $table->float('protein_per_gram');
            $table->float('lemak_per_gram');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
