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
            $table->float('total');
            $table->foreignid('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->boolean('status_pembayaran');
            $table->string('metode_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->unsignedBigInteger('transaksiable_id');
            $table->string('transaksiable_type');
            // Polymorphic relation
            // $table->morphs('transaksiable'); // menghasilkan: transaksiable_id, transaksiable_type

            $table->timestamps();
            $table->index(['transaksiable_id', 'transaksiable_type']);
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
