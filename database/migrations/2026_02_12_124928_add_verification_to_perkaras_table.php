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
        Schema::table('perkaras', function (Blueprint $table) {
            $table->string('file_skk')->nullable(); // Admin yang upload
            $table->enum('status_verifikasi', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('alasan_penolakan')->nullable(); // Jika staff menolak
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perkaras', function (Blueprint $table) {
            //
        });
    }
};
