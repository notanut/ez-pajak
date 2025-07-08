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
        Schema::create('pegawai_tidak_tetaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->string('role')->default('Pegawai Tidak Tetap');
             $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->integer('tanggungan');
            $table->enum('status_perkawinan', ['Kawin','Tidak Kawin', 'Hidup Berpisah']);
            $table->boolean('bulanan_sama');

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
            $table->decimal('bruto_agu',15,2)->nullable();
            $table->decimal('bruto_sep',15,2)->nullable();
            $table->decimal('bruto_okt',15,2)->nullable();
            $table->decimal('bruto_nov',15,2)->nullable();
            $table->decimal('bruto_des',15,2)->nullable();


            $table->decimal('total_bruto', 15,2)->nullable();
            $table->integer('lama_hari_bekerja')->nullable();
            $table->decimal('avg_bruto', 15,2)->nullable();

            // penghitungan
            $table->string('metode_penghitungan');
            $table->decimal('pph21_terutang',15,2)->nullable();

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
            $table->decimal('pajak_agu',15,2)->nullable();
            $table->decimal('pajak_sep',15,2)->nullable();
            $table->decimal('pajak_okt',15,2)->nullable();
            $table->decimal('pajak_nov',15,2)->nullable();
            $table->decimal('pajak_des',15,2)->nullable();

            // penghitungan tidak bulanan
            $table->decimal('pph21_perhari',15,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_tidak_tetaps');
    }
};
