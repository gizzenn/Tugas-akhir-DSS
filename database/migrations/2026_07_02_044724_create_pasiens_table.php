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
        Schema::create('pasiens', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pasien');
        $table->bigInteger('pendapatan'); // Input Kriteria 1
        $table->bigInteger('biaya_pengobatan'); // Input Kriteria 2
        $table->double('skor_prioritas')->nullable(); // Output Fuzzy Tsukamoto
        $table->enum('status_bantuan', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
