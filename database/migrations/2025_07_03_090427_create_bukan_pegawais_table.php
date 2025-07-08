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
        Schema::create('bukan_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->string('role')->default('Bukan Pegawai');
            $table->boolean('dibayar_bulanan');
            $table->boolean('bulanan_sama')->nullable;

            // kalau dibayar bulanan, tiap bulannya tetap
            $table->decimal('bruto_perbulan', 15, 2)->nullable();
            $table->integer('banyak_bulan_bekerja')->nullable();

            // dibayar bulanan, tiap bulannya beda
            $table->decimal('bruto_jan',15,2)->nullable();
            $table->decimal('bruto_feb',15,2)->nullable();
            $table->decimal('bruto_mar',15,2)->nullable();
            $table->decimal('bruto_apr',15,2)->nullable();
            $table->decimal('bruto_mei',15,2)->nullable();
            $table->decimal('bruto_jun',15,2)->nullable();
            $table->decimal('bruto_jul',15,2)->nullable();
            $table->decimal('bruto_agut',15,2)->nullable();
            $table->decimal('bruto_sept',15,2)->nullable();
            $table->decimal('bruto_okt',15,2)->nullable();
            $table->decimal('bruto_nov',15,2)->nullable();
            $table->decimal('bruto_des',15,2)->nullable();

            // tidak dibayar bulanan
            $table->decimal('total_bruto', 15,2)->nullable();
            $table->boolean('pihak_ketiga')->nullable();
            $table->decimal('biaya_pihak_ketiga', 15, 2)->nullable();

            // penghitungan
            $table->string('metode_penghitungan');
            $table->decimal('pph21_terutang',15,2)->nullable();
            
            // penghitungan dibayar bulanan + tetap & tidak bulanan
            $table->string('tarif')->default('-');
            
            // penghitungan dibayar bulanan + tetap
            $table->decimal('pph21_perbulan',15,2)->nullable();

            // penghitungan dibayar bulanan + tidak tetap
            $table->decimal('pajak_jan',15,2)->nullable();
            $table->decimal('pajak_feb',15,2)->nullable();
            $table->decimal('pajak_mar',15,2)->nullable();
            $table->decimal('pajak_apr',15,2)->nullable();
            $table->decimal('pajak_mei',15,2)->nullable();
            $table->decimal('pajak_jun',15,2)->nullable();
            $table->decimal('pajak_jul',15,2)->nullable();
            $table->decimal('pajak_agt',15,2)->nullable();
            $table->decimal('pajak_sept',15,2)->nullable();
            $table->decimal('pajak_okt',15,2)->nullable();
            $table->decimal('pajak_nov',15,2)->nullable();
            $table->decimal('pajak_des',15,2)->nullable();

            // penghitungan tidak bulanan
            $table->decimal('penghasilan_neto',15,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukan_pegawais');
    }
};
