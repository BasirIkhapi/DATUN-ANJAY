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
        // Sesuaikan dengan nama di phpMyAdmin kamu: tahapan_perkaras
        Schema::table('tahapan_perkaras', function (Blueprint $table) {
            if (!Schema::hasColumn('tahapan_perkaras', 'tanggal')) {
                $table->date('tanggal')->after('nama_tahapan')->nullable();
            }
        });

        // Tabel perkara biasanya perkaras
        Schema::table('perkaras', function (Blueprint $table) {
            if (!Schema::hasColumn('perkaras', 'file_putusan')) {
                $table->string('file_putusan')->after('file_skk')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
