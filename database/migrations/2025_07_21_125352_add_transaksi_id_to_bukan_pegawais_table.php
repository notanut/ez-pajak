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
        Schema::table('bukan_pegawais', function (Blueprint $table) {
            // Menambahkan kolom transaksi_id sebagai foreign key
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukan_pegawais', function (Blueprint $table) {
            // Menghapus foreign key constraint terlebih dahulu
            $table->dropConstrainedForeignId('transaksi_id');
            // Menghapus kolom transaksi_id
            $table->dropColumn('transaksi_id');
        });
    }
};
