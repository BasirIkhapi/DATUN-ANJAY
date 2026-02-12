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
        // Menggunakan nama jamak 'tahapan_perkaras' agar standar Laravel
        Schema::create('tahapan_perkaras', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel perkaras
            $table->foreignId('perkara_id')->constrained('perkaras')->onDelete('cascade');

            // Poin 3: Nama Tahapan (Mediasi, Replik, dll)
            $table->string('nama_tahapan');

            // Poin 3: Tanggal pelaksanaan sidang/tahapan
            $table->date('tanggal_tahapan');

            // Poin 3: Ringkasan hasil sidang
            $table->text('keterangan')->nullable();

            // POIN 2: Kolom untuk menyimpan file PDF hasil putusan/penetapan
            $table->string('file_tahapan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapan_perkaras');
    }
};
