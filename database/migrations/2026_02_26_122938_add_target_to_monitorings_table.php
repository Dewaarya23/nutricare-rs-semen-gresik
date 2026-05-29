<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('monitorings', function (Blueprint $table) {
            $table->double('target_kkal')->nullable();
            $table->double('target_karbo')->nullable();
            $table->double('target_protein')->nullable();
            $table->double('target_lemak')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('monitorings', function (Blueprint $table) {
            $table->dropColumn([
                'target_kkal',
                'target_karbo',
                'target_protein',
                'target_lemak',
            ]);
        });
    }
};
