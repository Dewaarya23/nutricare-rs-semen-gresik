<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('tekanan_darah_sistolik')->nullable()->after('activity_factor');
            $table->float('glukosa_darah')->nullable()->after('tekanan_darah_sistolik');
            $table->float('kolesterol')->nullable()->after('glukosa_darah');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tekanan_darah_sistolik', 'glukosa_darah', 'kolesterol']);
        });
    }
};
