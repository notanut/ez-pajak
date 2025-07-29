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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 15, 2);
            $table->foreignid('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->boolean('status_pembayaran')->default(false);
            $table->string('metode_pembayaran')->default('belum ada');
            $table->date('tanggal_pembayaran');
            $table->timestamps();
        });
        
        Schema::create('bukan_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->boolean('dibayar_bulanan');
            // ... dan kolom-kolom lainnya untuk berbagai skenario
            $table->decimal('total_bruto', 15,2)->nullable();
            $table->string('metode_penghitungan');
            $table->decimal('pph21_terutang',15,2)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
