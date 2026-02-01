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
    Schema::create('tahapans', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel perkaras
        $table->foreignId('perkara_id')->constrained('perkaras')->onDelete('cascade');
        $table->string('nama_tahapan'); // Contoh: Mediasi, Jawaban, Replik, dll
        $table->date('tanggal_tahapan');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapans');
    }
};
