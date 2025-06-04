@extends('layouts.app')

@section('title', 'EzPajak | Kalkulator Pajak untuk Pegawai Tidak Tetap')
@section('content')
<section class="d-block d-md-flex gap-5 justify-content-evenly">
        <div class="left">
            <h2 class="text-primary">Isi Data <span class="fw-normal">Anda Disini</span></h2>
            <p class="fst-italic">Ketahui PPh 21 terutang Anda dalam beberapa pertanyaan</p>
            <div class="card">
                <h5 class="blue card-title">Informasi Pemberian Gaji</h5>
                <div class="form-wrap">
                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah Anda dibayar bulanan atau tidak?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="ya" id="dibayar-ya"> Ya
                                <label for="dibayar-ya"></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="tidak" id="dibayar-tidak"> Tidak
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
                        <input class="form-control rp" id="floatingGaji" placeholder="0">
                        <label for="floatingGaji">Berapa penghasilan bruto Anda (per hari/per proyek)?</label>
                    </div>

                    <div class="form-floating input-field">
                        <input type="number" class="form-control" id="floatingInput" placeholder="2" min="0">
                        <label for="floatingInput">Berapa hari pekerjaan dilakukan?</label>
                    </div>

                </div>
                <div class="form-wrap" id="bulanan" style="display: none;">
                    <div class="form-floating form-check input-field btn-group" role="group">
                            <p class="label">Apakah penghasilan setiap bulan Anda sama?</p>
                            <div class="radio-wrap">
                                <div class="opt">
                                    <input type="radio" name="bin" value="0" id="sama"> Ya
                                    <label></label>
                                </div>
                                <div class="opt">
                                    <input type="radio" name="bin" value="1" id="tidakSama"> Tidak
                                    <label></label>
                                </div>
                            </div>
                    </div>
                    <div id="tiapBulanSama" style="display: none;">
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="floatingGaji" placeholder="0">
                            <label for="floatingGaji">Berapa penghasilan bruto bulanan Anda?</label>
                        </div>
    
                        <div class="form-floating input-field">
                            <input type="number" class="form-control" id="floatingInput" placeholder="2" min="0">
                            <label for="floatingInput">Berapa bulan Anda bekerja di tahun ini?</label>
                        </div>
                    </div>
                    <div id="tiapBulanBeda" style="display: none;">
                        <p class="label tiapBulan">Masukkan penghasilan bruto Anda di setiap bulan:</p>
                        <div class="form-floating input-field mon">
                            <input class="form-control rp" id="Januari " placeholder="0">
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
                <div class="total">
                    <p class="title-total">Total Penghasilan Bruto</p>
                    <p class="rp-total">Rp450.960.000,00</p>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="card">
                <h5 class="orange card-title">Penghitungan</h5>
                <div class="form-wrap">
                    <div class="res-field">
                        <p class="label">Dasar Pengenaan dan Pemotongan Pajak (DPP) </p>
                        <p class="res">Rp    234.400.000,00</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                DPP adalah dasar untuk hitung pajak. Biasanya sebesar penghasilan bruto, atau 50% dari bruto jika penghasilan per hari > Rp2,5 juta
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res"> TER / 50% x Ps.17</p>
                    </div>
                    <div class="total grand">
                        <p class="title-total">PPh 21 Terutang</p>
                        <p class="rp-total">Rp  14.595.000,00</p>
                    </div>
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
                            <p class="date-ex">31 Des 2025</p>
                            <p class="batas-sub">batas waktu pembayaran: </p>
                            <p class="batas-date">2 Bulan 1 Minggu 3 Hari</p>
                        </div>
                        <div class="end">
                            <p class="date-title">Jatuh Tempo Terakhir</p>
                            <p class="date-ex">31 Mar 2026</p>
                            <p class="batas-sub">batas waktu pembayaran: </p>
                            <p class="batas-date">2 Bulan 1 Minggu 3 Hari</p>
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