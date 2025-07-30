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
        Schema::table('pegawai_tetaps', function (Blueprint $table) {
            // Menambahkan kolom transaksi_id sebagai foreign key
            // Menggunakan unsignedBigInteger untuk memastikan tipe data cocok dengan ID tabel 'transaksis'
            // Menambahkan nullable() karena mungkin ada kasus di mana perhitungan dibuat tanpa transaksi langsung
            // Menambahkan constrained('transaksis') untuk membuat foreign key constraint
            // Menambahkan onDelete('set null') agar jika transaksi dihapus, transaksi_id di sini menjadi null
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai_tetaps', function (Blueprint $table) {
            // Menghapus foreign key constraint terlebih dahulu
            $table->dropConstrainedForeignId('transaksi_id');
            // Menghapus kolom transaksi_id
            $table->dropColumn('transaksi_id');
        });
    }
};
