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
            // Menambahkan kolom alasan_penolakan (tipe text, boleh kosong)
            // Diletakkan setelah kolom is_verified
            $table->text('alasan_penolakan')->nullable()->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('perkaras', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};
