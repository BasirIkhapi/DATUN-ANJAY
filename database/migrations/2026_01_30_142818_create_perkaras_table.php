<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perkaras', function (Blueprint $table) {
            $table->id();

            // 1. Relasi ke Master Data Jaksa (Tugas Admin: Menunjuk JPN)
            $table->foreignId('jaksa_id')->constrained('jaksas')->onDelete('cascade');

            // 2. Identitas Perkara (Tugas Admin: Registrasi Awal)
            $table->string('nomor_perkara')->unique();
            $table->string('penggugat');
            $table->string('tergugat');
            $table->enum('jenis_perkara', ['Perdata', 'Tata Usaha Negara']);
            $table->date('tanggal_masuk');

            // 3. Operasional & Dokumen (Tugas Staff: Update & Upload)
            $table->boolean('is_verified')->default(false); // Validasi oleh Staff
            $table->string('file_skk')->nullable(); // Upload Surat Kuasa Khusus

            // 4. Status Final (Pengawasan Admin)
            $table->enum('status_akhir', ['Proses', 'Selesai'])->default('Proses');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perkaras');
    }
};
