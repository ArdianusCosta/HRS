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
        Schema::create('manajement_karyawans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_id')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin',['Laki-laki','Perempuan']);
            $table->text('alamat')->nullable();
            $table->date('tanggal_masuk');
            $table->string('foto_karyawan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajement_karyawans');
    }
};
