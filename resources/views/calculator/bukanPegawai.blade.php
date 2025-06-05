@extends('layouts.app')

@section('title', 'EzPajak | Kalkulator Pajak untuk Bukan Pegawai')
@section('content')
<section class="d-block d-md-flex gap-5 justify-content-evenly">
        <div class="left">
            <h2 class="text-primary">Isi Data <span class="fw-normal">Anda Disini</span></h2>
            <p class="fst-italic">Ketahui PPh 21 terutang Anda dalam beberapa pertanyaan</p>
            <div class="card">
                <h5 class="blue card-title">Informasi Penghasilan</h5>
                <div class="form-wrap">
                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingTerpotong" placeholder="0">
                        <label for="floatingTerpotong">Berapa total penghasilan bruto Anda?</label>
                    </div>

                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah sebagian penghasilan ini digunakan untuk membayar pihak ketiga (alat, material, dll)?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                <input type="radio" name="pihak_ketiga" value="ya" id="ketiga-ya"> Ya
                                <label for="ketiga-ya"></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="pihak_ketiga" value="tidak" id="ketiga-tidak"> Tidak
                                <label for="ketiga-tidak"></label>
                            </div>
                        </div>
                    </div>

                    <div id="yaPihak" style="display :none;" class="form-floating input-field">
                        <input class="form-control rp" id="floatingTerpotong" placeholder="0">
                        <label for="floatingTerpotong">Berapa total biaya pihak ketiga?</label>
                    </div>
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
                                DPP adalah 50% dari penghasilan bruto Anda. Ini yang dikenakan pajak.
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label">Tarif Pajak Progresif yang Dikenakan</p>
                        <p class="res">5%</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Tarif pajak <b>progresif</b> berarti semakin tinggi penghasilan kena pajak Anda, semakin tinggi persentase pajaknya. Tarif dimulai dari 5% dan naik bertahap sesuai jumlah penghasilan.
                            </div>
                        </div>
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
    @vite('resources/js/pages/calculatorBukanPegawai.js')
@endpush