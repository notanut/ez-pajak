@extends('layouts.app')

@section('title', 'EzPajak | Kalkulator Pajak untuk Bukan Pegawai')
@section('content')
<section class="d-block d-md-flex gap-5 justify-content-evenly container py-4">
        <div class="left">
            <h2 class="text-primary">Isi Data <span class="fw-normal">Anda Disini</span></h2>
            <p class="fst-italic">Ketahui PPh 21 terutang Anda dalam beberapa pertanyaan</p>
            @guest
                <div class="d-flex">
                    <i class="bi bi-exclamation-circle text-danger"></i>
                    <p class="fst-italic text-danger ms-2 mb-0">Kamu harus login untuk menikmati fitur pembayaran dan notifikasi yang kami sediakan. Jika belum login, kamu hanya dapat melihat nominal yang harus  dibayar saja.</p>
                </div>
            @endguest
            <div class="card mt-5">
                <h5 class="blue card-title">Informasi Pemberian Gaji</h5>
                <div class="form-wrap">
                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah Anda dibayar bulanan atau tidak?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="0" id="dibayar-ya"> Ya
                                <label for="dibayar-ya"></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="1" id="dibayar-tidak" checked> Tidak
                                <label for="dibayar-tidak"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="blue card-title">Penghasilan</h5>
                <div class="form-wrap" id="tidakBulanan">
                    <div class="form-floating input-field mb-0 mt-3">
                        <input class="form-control rp" id="floatingTerpotong" placeholder="0">
                        <label for="floatingTerpotong">Berapa total penghasilan bruto Anda?</label>
                    </div>
                    <p id="error-total_bruto" class="text-danger small my-0 fw-normal"></p>

                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah sebagian penghasilan ini digunakan untuk membayar pihak ketiga (alat, material, dll)?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                <input type="radio" name="pihak_ketiga" value="0" id="ketiga-ya"> Ya
                                <label for="ketiga-ya"></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="pihak_ketiga" value="1" id="ketiga-tidak"> Tidak
                                <label for="ketiga-tidak"></label>
                            </div>
                        </div>
                        <div class="tooltip-container">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Jika sebagian penghasilan Anda digunakan untuk membayar pihak ketiga (misalnya untuk beli material, sewa alat, atau bayar asisten), maka bagian tersebut bukan merupakan penghasilan Anda secara penuh dan dapat dikecualikan dari dasar pengenaan pajak.
                            </div>
                        </div>
                    </div>

                    <div id="yaPihak" style="display :none;" class="form-floating input-field mb-0 mt-3">
                        <input class="form-control rp" id="floatingPihakKetiga" placeholder="0">
                        <label for="floatingPihakKetiga">Berapa total biaya pihak ketiga?</label>
                    </div>
                    <p id="error-biaya_pihak_ketiga" class="text-danger small my-0 fw-normal"></p>
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
                        <div class="form-floating input-field mb-0 mt-3">
                            <input class="form-control rp" id="floatingGaji" placeholder="0">
                            <label for="floatingGaji">Berapa penghasilan bruto bulanan Anda?</label>
                        </div>
                        <p id="error-bruto_perbulan" class="text-danger small my-0 fw-normal"></p>
    
                        <div class="form-floating input-field mb-0 mt-3">
                            <input type="number" class="form-control" id="floatingInput" placeholder="2" min="1" max="12">
                            <label for="floatingInput">Berapa bulan Anda bekerja di tahun ini?</label>
                        </div>
                        <p id="error-banyak_bulan_bekerja" class="text-danger small my-0 fw-normal"></p>
                    </div>
                    <div id="tiapBulanBeda" style="display: none;">
                        <p class="label tiapBulan">Masukkan penghasilan bruto Anda di setiap bulan:</p>
                        <p id="error-bruto_jan" class="text-danger small my-0 fw-normal"></p>
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
                        <p class="label">Tarif Pajak Progresif yang Dikenakan</p>
                        <p class="res">-</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Tarif pajak <b>progresif</b> berarti semakin tinggi penghasilan kena pajak Anda, semakin tinggi persentase pajaknya. Tarif dimulai dari 5% dan naik bertahap sesuai jumlah penghasilan.
                            </div>
                        </div>
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
                        <p class="label">Penghasilan Neto</p>
                        <p class="res" id="netoTidakBulanan">Rp    0</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                <b>Penghasilan bruto </b>dikurangi <b>biaya pihak ketiga</b>
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res">-</p>
                    </div>
                    <div class="res-field">
                        <p class="label">Tarif Pajak Progresif yang Dikenakan</p>
                        <p class="res">-</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Tarif pajak <b>progresif</b> berarti semakin tinggi penghasilan kena pajak Anda, semakin tinggi persentase pajaknya. Tarif dimulai dari 5% dan naik bertahap sesuai jumlah penghasilan.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="total grand mt-3">
                    <p class="title-total">PPh 21 Terutang</p>
                    <p class="rp-total">Rp  0</p>
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
                    <button class="pay-now" id="pay-now">Bayar Sekarang</button>
                    <button class="later" id="remind-later">Ingatkan Nanti</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/pages/calculatorBukanPegawai.js')
@endpush