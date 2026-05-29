<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('diet_logs', function (Blueprint $table) {
        $table->dateTime('tanggal_mulai')->change();
        $table->dateTime('tanggal_selesai')->nullable()->change();
    });
}

public function down()
{
    Schema::table('diet_logs', function (Blueprint $table) {
        $table->date('tanggal_mulai')->change();
        $table->date('tanggal_selesai')->nullable()->change();
    });
}
};
