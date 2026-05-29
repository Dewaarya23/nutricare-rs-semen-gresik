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
        Schema::create('monitoring_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis_makan',['pagi','siang','malam']);
            $table->double('total_kkal')->default(0);
            $table->double('total_karbo')->default(0);
            $table->double('total_protein')->default(0);
            $table->double('total_lemak')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_details');
    }
};
