@extends('layouts.app')

@section('title', 'EzPajak | Kalkulator Pajak untuk Pegawai Tidak Tetap')
@section('content')
<section class="d-block d-md-flex gap-5 justify-content-evenly container py-4">
        <div class="left">
            <h2 class="text-primary">Isi Data <span class="fw-normal">Anda Disini</span></h2>
            <p class="fst-italic">Ketahui PPh 21 terutang Anda dalam beberapa pertanyaan</p>
            <div class="card">
                <h5 class="blue card-title">Informasi Pemberian Gaji</h5>
                <div class="form-wrap">
                    <div class="form-floating form-check input-field btn-group" role="group">
                            <p class="label">Apa jenis kelamin Anda?</p>
                            <div class="radio-wrap">
                                <div class="opt">
                                    <input type="radio" name="sex" value="0"> Pria
                                    <label></label>
                                </div>
                                <div class="opt">
                                    <input type="radio" name="sex" value="1"> Wanita
                                    <label></label>
                                </div>
                            </div>
                    </div>
                    <div class="form-floating input-field">
                        <input type="number" class="form-control" id="jmlTanggungan" placeholder="2" min="0" max="3">
                        <label for="jmlTanggungan">Berapa total tanggungan Anda?</label>
                        <div class="tooltip-container">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Yang bisa jadi tanggungan adalah keluarga sedarah (contoh: orang tua dan anak kandung), keluarga semenda (contoh: mertua dan anak tiri), dan anak angkat—dengan syarat mereka tidak punya penghasilan dan seluruh biaya hidupnya ditanggung oleh wajib pajak. Maksimal tanggungan yang diakui cuma 3 orang, dihitung dari kondisi awal tahun.
                            </div>
                        </div>
                    </div>

                    <div class="form-floating input-field">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select marriage">
                            <option disabled selected>Pilih satu</option>
                            <option value="0">Kawin</option>
                            <option value="1">Tidak Kawin</option>
                            <option value="2">Hidup Berpisah</option>
                        </select>
                        <label for="floatingSelect">Apa status perkawinan Anda?</label>
                    </div>
                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah Anda dibayar bulanan atau tidak?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="ya" id="dibayar-ya"> Ya
                                <label for="dibayar-ya"></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="tidak" id="dibayar-tidak" checked> Tidak
                                <label for="dibayar-tidak"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="blue card-title">Penghasilan</h5>
                <div class="form-wrap" id="tidakBulanan">
                    <div class="form-floating input-field">
                        <input class="form-control rp" id="brutoProyek" placeholder="0">
                        <label for="brutoProyek">Berapa penghasilan bruto Anda di proyek/pekerjaan ini?</label>
                    </div>

                    <div class="form-floating input-field">
                        <input type="number" class="form-control" id="lamaKerja" placeholder="2" min="0">
                        <label for="lamaKerja">Berapa hari lamanya pekerjaan dilakukan?</label>
                    </div>
                    <div class="total">
                        <p class="title-total">Rata-rata Penghasilan Bruto Sehari</p>
                        <p class="rp-total" id="avBruto">Rp 0</p>
                    </div>
                </div>
                <div class="form-wrap" id="bulanan" style="display: none;">
                    <div class="form-floating form-check input-field btn-group" role="group">
                            <p class="label">Apakah penghasilan setiap bulan Anda sama?</p>
                            <div class="radio-wrap">
                                <div class="opt">
                                    <input type="radio" name="bulananSamaGa" value="0" id="sama"> Ya
                                    <label></label>
                                </div>
                                <div class="opt">
                                    <input type="radio" name="bulananSamaGa" value="1" id="tidakSama"> Tidak
                                    <label></label>
                                </div>
                            </div>
                    </div>
                    <div id="tiapBulanSama" style="display: none;">
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="brutoBulanan" placeholder="0">
                            <label for="brutoBulanan">Berapa penghasilan bruto bulanan Anda?</label>
                        </div>
    
                        <div class="form-floating input-field">
                            <input type="number" class="form-control" id="jmlBulan" placeholder="2" min="0">
                            <label for="jmlBulan">Berapa bulan Anda bekerja di tahun ini?</label>
                        </div>
                    </div>
                    <div id="tiapBulanBeda" style="display: none;">
                        <p class="label tiapBulan">Masukkan penghasilan bruto Anda di setiap bulan:</p>
                        <div class="form-floating input-field mon">
                            <input class="form-control rp" id="Januari" placeholder="0">
                            <label for="Januari">Januari</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Februari" placeholder="0">
                            <label for="Februari">Februari</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Maret" placeholder="0">
                            <label for="Maret">Maret</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="April" placeholder="0">
                            <label for="April">April</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Mei" placeholder="0">
                            <label for="Mei">Mei</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Juni" placeholder="0">
                            <label for="Juni">Juni</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Juli" placeholder="0">
                            <label for="Juli">Juli</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Agustus" placeholder="0">
                            <label for="Agustus">Agustus</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="September" placeholder="0">
                            <label for="September">September</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Oktober" placeholder="0">
                            <label for="Oktober">Oktober</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="November" placeholder="0">
                            <label for="November">November</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Desember" placeholder="0">
                            <label for="Desember">Desember</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="card">
                <h5 class="orange card-title">Penghitungan</h5>
                <div class="form-wrap" id="bulanan-sama-wrap" style="display: none;">
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res" id="metodeHitungSama">-</p>
                    </div>
                    <div class="res-field">
                        <p class="label">PPh 21 per bulan</p>
                        <p class="res" id="pphRataSama">Rp 0</p>
                    </div>
                </div>
                <div class="form-wrap" id="bulanan-beda-wrap" style="display: none;">
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res" id="metodeHitungBeda">-</p>
                    </div>
                    <p class="label tiapBulan">PPh 21 Anda di Bulan..</p>
                </div>
                <div class="form-wrap" id="tidak-bulanan-wrap">
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res" id="metodeHitungTidakBulan">-</p>
                    </div>
                    <div class="res-field">
                        <p class="label">PPh 21 per hari</p>
                        <p class="res" id="pphRataHari">Rp 0</p>
                    </div>
                </div>
                <div class="total grand mt-3">
                    <p class="title-total">PPh 21 Terutang</p>
                    <p class="rp-total" id="rp-total">Rp  0</p>
                </div>
            </div>

            <div class="card">
                <h5 class="orange card-title">Pembayaran</h5>
                <div class="form-wrap">
                    <p class="djp-par">
                        Menurut DJP, batas waktu penyampaian SPT adalah paling lama 3 bulan setelah akhir Tahun Pajak
                    </p>
                    <div class="date-due">
                        <div class="start">
                            <p class="date-title">Akhir Tahun Pajak</p>
                            <p class="date-ex" id="akhir-tahun">31 Des 2025</p>
                            <p class="batas-sub">batas waktu pembayaran: </p>
                            <p class="batas-date" id="batas-start">2 Bulan 1 Minggu 3 Hari</p>
                        </div>
                        <div class="end">
                            <p class="date-title">Jatuh Tempo Terakhir</p>
                            <p class="date-ex" id="jatuh-tempo">31 Mar 2026</p>
                            <p class="batas-sub">batas waktu pembayaran: </p>
                            <p class="batas-date" id="batas-end">2 Bulan 1 Minggu 3 Hari</p>
                        </div>
                    </div>
                </div>
                <div class="btn-bayar-wrap">
                    <button class="pay-now">Bayar Sekarang</button>
                    <button class="later">Ingatkan Nanti</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/pages/calculatorPegawaiTidakTetap.js')
@endpush