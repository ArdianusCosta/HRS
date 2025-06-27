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
        Schema::create('karyawan_departement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('manajement_karyawans')->onDelete('cascade');
            $table->foreignId('departement_id')->constrained('manajement_departements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_departement');
    }
};
