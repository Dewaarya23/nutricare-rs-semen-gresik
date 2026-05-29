<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telp')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('tinggi_badan')->nullable();
            $table->enum('ada_riwayat', ['ya', 'tidak'])->nullable();
            $table->string('riwayat_penyakit')->nullable();

            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('nomor_anggota')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
