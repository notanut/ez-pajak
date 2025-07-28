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
        Schema::table('transaksis', function (Blueprint $table) {
            // Menambahkan kolom 'jenis_pegawai'
            // Ini akan menyimpan string seperti 'Pegawai Tetap', 'Pegawai Tidak Tetap', atau 'Bukan Pegawai'
            $table->string('jenis_pegawai')->nullable()->after('pengguna_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Menghapus kolom 'jenis_pegawai' jika migrasi di-rollback
            $table->dropColumn('jenis_pegawai');
        });
    }
};
