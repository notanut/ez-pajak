@extends('layouts.app')

@section('title', 'Kalkulator Pajak')
@section('content')
<section class="d-block d-md-flex gap-5 justify-content-evenly">
        <div class="left">
            <h2 class="text-primary">Isi Data <span class="fw-normal">Anda Disini</span></h2>
            <p class="fst-italic">Ketahui PPh 21 terutang Anda dalam beberapa pertanyaan</p>
            <div class="card">
                <h5 class="blue card-title">Informasi Pegawai</h5>
                <div class="form-wrap">
                    <div class="form-floating input-field">
                        <input type="number" class="form-control" id="floatingInput" placeholder="2">
                        <label for="floatingInput">Berapa total tanggungan Anda?</label>
                    </div>

                    <div class="form-floating input-field">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select marriage">
                            <option disabled selected>Pilih satu</option>
                            <option value="0">Kawin</option>
                            <option value="1">Tidak Kawin</option>
                        </select>
                        <label for="floatingSelect">Apa status perkawinan Anda?</label>
                    </div>

                    <div class="form-date-wrap">
                        <p class="title-date">Masa Penghasilan</p>
                        <div class="form-date">
                            <div class="form-floating input-field">
                                <select id="startMonth" class="form-select" required>
                                    <option value="" disabled selected>Pilih bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <label for="startMonth" class="form-label fst-italic">Bulan Awal</label>
                            </div>
    
                            <div class="form-floating input-field">
                                <select id="endMonth" class="form-select" required>
                                    <option value="" disabled selected>Pilih bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <label for="endMonth" class="form-label fst-italic">Bulan Akhir</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p>Apakah Anda menjadi Subjek Pajak Dalam Negeri (SPDN) penuh selama tahun ini?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                <input type="radio" name="bin" value="0"> Ya
                                <label></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="bin" value="1"> Tidak
                                <label></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingTerpotong" placeholder="0">
                        <label for="floatingTerpotong">PPh 21 yang telah Dipotong Masa Sebelumnya</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="blue card-title">Penghasilan</h5>
                <div class="form-wrap">
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingGaji" placeholder="0">
                        <label for="floatingGaji">Total Gaji/Pensiun dalam Setahun</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingPPh" placeholder="0">
                        <label for="floatingPPh">Tunjangan PPh</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingLain" placeholder="0">
                        <label for="floatingLain">Tunjangan Lainnya, Uang Lembur, dan sebagainya</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingHonor" placeholder="0">
                        <label for="floatingHonor">Honorarium dan Imbalan Lainnya Sejenisnya</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingPremi" placeholder="0">
                        <label for="floatingPremi">Premi Asuransi yang dibayar Pemberi Kerja</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingNatura" placeholder="0">
                        <label for="floatingNatura">Natura dan Kenikmatan Lainnya</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingTantiem" placeholder="0">
                        <label for="floatingTantiem">Tantiem, Bonus, Gratifikasi, Jasa Produksi dan THR</label>
                    </div>

                    <div class="total">
                        <p class="title-total">Total Penghasilan Bruto</p>
                        <p class="rp-total">Rp450.960.000,00</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h5 class="blue card-title">Pengurangan</h5>
                <div class="form-wrap">
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingBiaya" placeholder="0">
                        <label for="floatingBiaya">Biaya Jabatan</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingTHT" placeholder="0">
                        <label for="floatingTHT">Iuran Pensiun atau Iuran THT/JHT</label>
                    </div>
                
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingZakar" placeholder="0">
                        <label for="floatingZakar">Zakat/Sumbangan Keagamaan yang Bersifat Wajib yang Dibayarkan Melalui Pemberi Kerja</label>
                    </div>
                
                    <div class="total">
                        <p class="title-total">Total Pengurangan</p>
                        <p class="rp-total">Rp450.960.000,00</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="card">
                <h5 class="orange card-title">Penghitungan</h5>
                <div class="form-wrap">
                    <div class="res-field">
                        <p class="label">Penghasilan Neto</p>
                        <p class="res">Rp    234.400.000,00</p>
                    </div>
                    <div class="res-field">
                        <p class="label">Penghasilan Neto Masa sebelumnya</p>
                        <p class="res">Rp    234.400.000,00</p>
                    </div>
                    <div class="res-field">
                        <p class="label">Penghasilan Neto untuk PPh 21 (Setahun/Disetahunkan)</p>
                        <p class="res">Rp    234.400.000,00</p>
                    </div>
                    <div class="res-field">
                        <p class="label">Penghasilan Tidak Kena Pajak (PTKP)</p>
                        <p class="res">Rp    234.400.000,00</p>
                    </div>
                    <div class="res-field">
                        <p class="label">Penghasilan Kena Pajak Setahun/Disetahunkan</p>
                        <p class="res">Rp    234.400.000,00</p>
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