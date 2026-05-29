<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->float('bb')->comment('Berat Badan (kg)');
            $table->float('tb')->comment('Tinggi Badan (cm)');
            $table->float('imt');
            $table->float('bbi');
            $table->float('abv');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
