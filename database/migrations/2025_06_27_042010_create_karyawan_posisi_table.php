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
        Schema::create('karyawan_posisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('manajement_karyawans')->onDelete('cascade');
            $table->foreignId('posisi_id')->constrained('manajement_posisis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_posisi');
    }
};
