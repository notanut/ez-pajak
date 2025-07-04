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
        Schema::create('pegawai_tetaps', function (Blueprint $table) {
            $table->id();
            $table->foreign('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->string('role')->default('Pegawai Tetap');
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->integer('tanggungan');
            $table->enum('status_perkawinan', ['Kawin','Tidak Kawin', 'Hidup Berpisah']);
            $table->date('masa_penghasilan_awal');
            $table->date('masa_penghasilan_akhir');
            $table->boolean('disetahunkan');
            $table->decimal('gaji', 15, 2);
            $table->decimal('tunjangan_pph', 15, 2)->default(0);
            $table->decimal('tunjangan_lain', 15, 2)->default(0);
            $table->decimal('honor', 15, 2)->default(0);
            $table->decimal('premi', 15, 2)->default(0);
            $table->decimal('natura', 15, 2)->default(0);
            $table->decimal('tantiem', 15, 2)->default(0);
            $table->decimal('biaya_jabatan', 15, 2);
            $table->decimal('iuran_pensiun', 15, 2)->default(0);
            $table->decimal('zakat', 15, 2)->default(0);
            $table->decimal('penghasilan_bruto', 15, 2);
            $table->decimal('pengurangan', 15, 2);
            $table->decimal('penghasilan_neto', 15, 2);
            $table->decimal('penghasilan_neto_masa_sebelumnya', 15, 2)->default(0);
            $table->decimal('penghasilan_neto_pph21', 15, 2);
            $table->decimal('ptkp', 15, 2);
            $table->decimal('pkp', 15, 2);
            $table->string('tarif_progresif');
            $table->decimal('pph21_pkp', 15, 2);
            $table->decimal('pph21_dipotong_masa_sebelum', 15, 2)->default(0);
            $table->decimal('pph21_terutang', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_tetaps');
    }
};
