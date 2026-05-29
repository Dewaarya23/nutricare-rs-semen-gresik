<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('defisit', ['Menurunkan','Stabil','Menaikkan'])
                  ->default('Stabil')
                  ->after('tinggi_badan');

            $table->float('activity_factor')
                  ->default(1.3)
                  ->after('defisit');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['defisit','activity_factor']);
        });
    }
};
