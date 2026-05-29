<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitoring_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_detail_id')->constrained()->cascadeOnDelete();
            $table->string('kode_menu');
            $table->string('opsi_berat');
            $table->decimal('qty', 8, 2);
            $table->double('gram');
            $table->double('kkal');
            $table->double('karbo');
            $table->double('protein');
            $table->double('lemak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_items');
    }
};
