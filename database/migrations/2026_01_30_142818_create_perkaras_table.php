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
    Schema::create('perkaras', function (Blueprint $table) {
        $table->id();
        // WAJIB ADA: Menghubungkan ke tabel jaksas
        $table->foreignId('jaksa_id')->constrained('jaksas')->onDelete('cascade');
        
        $table->string('nomor_perkara')->unique();
        $table->string('penggugat');
        $table->string('tergugat');
        $table->enum('jenis_perkara', ['Perdata', 'Tata Usaha Negara']);
        $table->date('tanggal_masuk');
        $table->enum('status_akhir', ['Proses', 'Selesai'])->default('Proses');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkaras');
    }
};
