@extends('layouts.app')

@section('title', 'EzPajak | Kalkulator Pajak untuk Pegawai Tidak Tetap')
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
                            <p class="label">Apa jenis kelamin Anda?</p>
                            <div class="radio-wrap">
                                <div class="opt">
                                    {{-- Mengisi nilai radio button jika ada data pegawaiTidakTetap --}}
                                    <input type="radio" name="sex" value="Pria" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->jenis_kelamin == 'Pria' ? 'checked' : '' }}> Pria
                                    <label></label>
                                </div>
                                <div class="opt">
                                    <input type="radio" name="sex" value="Wanita" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->jenis_kelamin == 'Wanita' ? 'checked' : '' }}> Wanita
                                    <label></label>
                                </div>
                            </div>
                    </div>
                    <p id="error-jenis_kelamin" class="text-danger small mt-1 mb-0 fw-normal"></p>
                    <div class="form-floating input-field mb-0 mt-3">
                        {{-- Mengisi nilai input jika ada data pegawaiTidakTetap --}}
                        <input type="number" class="form-control" id="jmlTanggungan" placeholder="2" min="0" max="3" value="{{ $pegawaiTidakTetap->tanggungan ?? '' }}">
                        <label for="jmlTanggungan">Berapa total tanggungan Anda?</label>
                        <div class="tooltip-container">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Yang bisa jadi tanggungan adalah keluarga sedarah (contoh: orang tua dan anak kandung), keluarga semenda (contoh: mertua dan anak tiri), dan anak angkat—dengan syarat mereka tidak punya penghasilan dan seluruh biaya hidupnya ditanggung oleh wajib pajak. Maksimal tanggungan yang diakui cuma 3 orang, dihitung dari kondisi awal tahun.
                            </div>
                        </div>
                    </div>
                    <p id="error-tanggungan" class="text-danger small my-0 fw-normal"></p>

                    <div class="form-floating input-field mb-0 mt-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select marriage">
                            <option disabled {{ !isset($pegawaiTidakTetap) ? 'selected' : '' }}>Pilih satu</option>
                            {{-- Mengisi nilai select jika ada data pegawaiTidakTetap --}}
                            <option value="Kawin" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->status_perkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Tidak Kawin" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->status_perkawinan == 'Tidak Kawin' ? 'selected' : '' }}>Tidak Kawin</option>
                            <option value="Hidup Berpisah" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->status_perkawinan == 'Hidup Berpisah' ? 'selected' : '' }}>Hidup Berpisah</option>
                        </select>
                        <label for="floatingSelect">Apa status perkawinan Anda?</label>
                    </div>
                    <p id="error-status_perkawinan" class="text-danger small mt-0 mb-3 fw-normal"></p>
                    <div class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah Anda dibayar bulanan atau tidak?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                {{-- Mengisi nilai radio button jika ada data pegawaiTidakTetap --}}
                                <input type="radio" name="dibayar_bulanan" value="0" id="dibayar-ya" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 0 ? 'checked' : '' }}> Ya
                                <label for="dibayar-ya"></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="dibayar_bulanan" value="1" id="dibayar-tidak" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 1 ? 'checked' : '' }}> Tidak
                                <label for="dibayar-tidak"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="blue card-title">Penghasilan</h5>
                <div class="form-wrap" id="tidakBulanan" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 0 ? 'block' : 'none' }};">
                    <div class="form-floating input-field mb-0 mt-3">
                        <input class="form-control rp" id="brutoProyek" placeholder="0" value="{{ $pegawaiTidakTetap->total_bruto ?? '' }}">
                        <label for="brutoProyek">Berapa penghasilan bruto Anda di proyek/pekerjaan ini?</label>
                    </div>
                    <p id="error-total_bruto" class="text-danger small mt-0 mb-3 fw-normal"></p>

                    <div class="form-floating input-field mb-0 mt-3">
                        <input type="number" class="form-control" id="lamaKerja" placeholder="2" min="0" value="{{ $pegawaiTidakTetap->lama_hari_bekerja ?? '' }}">
                        <label for="lamaKerja">Berapa hari lamanya pekerjaan dilakukan?</label>
                    </div>
                    <p id="error-lama_hari_bekerja" class="text-danger small mt-0 mb-3 fw-normal"></p>
                    <div class="total">
                        <p class="title-total">Rata-rata Penghasilan Bruto Sehari</p>
                        <p class="rp-total" id="avBruto">Rp {{ number_format($pegawaiTidakTetap->avg_bruto ?? 0, 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="form-wrap" id="bulanan" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 1 ? 'block' : 'none' }};">
                    <div class="form-floating form-check input-field btn-group" role="group">
                            <p class="label">Apakah penghasilan setiap bulan Anda sama?</p>
                            <div class="radio-wrap">
                                <div class="opt">
                                    {{-- Mengisi nilai radio button jika ada data pegawaiTidakTetap --}}
                                    <input type="radio" name="bulananSamaGa" value="0" id="sama" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->bulanan_sama == 0 ? 'checked' : '' }}> Ya
                                    <label></label>
                                </div>
                                <div class="opt">
                                    <input type="radio" name="bulananSamaGa" value="1" id="tidakSama" {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->bulanan_sama == 1 ? 'checked' : '' }}> Tidak
                                    <label></label>
                                </div>
                            </div>
                    </div>
                    <div id="tiapBulanSama" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->bulanan_sama == 0 ? 'block' : 'none' }};">
                        <div class="form-floating input-field mb-0 mt-3">
                            <input class="form-control rp" id="brutoBulanan" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_perbulan ?? '' }}">
                            <label for="brutoBulanan">Berapa penghasilan bruto bulanan Anda?</label>
                        </div>
                        <p id="error-bruto_perbulan" class="text-danger small my-0 fw-normal"></p>

                        <div class="form-floating input-field mb-0 mt-3">
                            <input type="number" class="form-control" id="jmlBulan" placeholder="2" min="0" value="{{ $pegawaiTidakTetap->banyak_bulan_bekerja ?? '' }}">
                            <label for="jmlBulan">Berapa bulan Anda bekerja di tahun ini?</label>
                        </div>
                        <p id="error-banyak_bulan_bekerja" class="text-danger small my-0 fw-normal"></p>
                    </div>
                    <div id="tiapBulanBeda" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->bulanan_sama == 1 ? 'block' : 'none' }};">
                        <p class="label tiapBulan">Masukkan penghasilan bruto Anda di setiap bulan:</p>
                        <p id="error-bruto_jan" class="text-danger small my-0 fw-normal"></p>
                        <div class="form-floating input-field mon">
                            <input class="form-control rp" id="Januari" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_jan ?? '' }}">
                            <label for="Januari">Januari</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Februari" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_feb ?? '' }}">
                            <label for="Februari">Februari</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Maret" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_mar ?? '' }}">
                            <label for="Maret">Maret</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="April" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_apr ?? '' }}">
                            <label for="April">April</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Mei" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_mei ?? '' }}">
                            <label for="Mei">Mei</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Juni" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_jun ?? '' }}">
                            <label for="Juni">Juni</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Juli" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_jul ?? '' }}">
                            <label for="Juli">Juli</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Agustus" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_agu ?? '' }}">
                            <label for="Agustus">Agustus</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="September" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_sep ?? '' }}">
                            <label for="September">September</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Oktober" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_okt ?? '' }}">
                            <label for="Oktober">Oktober</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="November" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_nov ?? '' }}">
                            <label for="November">November</label>
                        </div>
                        <div class="form-floating input-field">
                            <input class="form-control rp" id="Desember" placeholder="0" value="{{ $pegawaiTidakTetap->bruto_des ?? '' }}">
                            <label for="Desember">Desember</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="card">
                <h5 class="orange card-title">Penghitungan</h5>
                <div class="form-wrap" id="bulanan-sama-wrap" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 1 && $pegawaiTidakTetap->bulanan_sama == 0 ? 'block' : 'none' }};">
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res" id="metodeHitungSama">{{ $pegawaiTidakTetap->metode_penghitungan ?? '-' }}</p>
                    </div>
                    <div class="res-field">
                        <p class="label">PPh 21 per bulan</p>
                        <p class="res" id="pphRataSama">Rp {{ number_format($pegawaiTidakTetap->pph21_perbulan ?? 0, 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="form-wrap" id="bulanan-beda-wrap" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 1 && $pegawaiTidakTetap->bulanan_sama == 1 ? 'block' : 'none' }};">
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res" id="metodeHitungBeda">{{ $pegawaiTidakTetap->metode_penghitungan ?? '-' }}</p>
                    </div>
                    <p class="label tiapBulan">PPh 21 Anda di Bulan..</p>
                    {{-- PPh 21 per bulan (jika ada) --}}
                    @if(isset($pegawaiTidakTetap))
                        @foreach(['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $month)
                            @if($pegawaiTidakTetap->{"pajak_{$month}"} !== null)
                                <div class="res-field">
                                    <p class="label">{{ ucfirst($month) }}</p>
                                    <p class="res">Rp {{ number_format($pegawaiTidakTetap->{"pajak_{$month}"}, 2, ',', '.') }}</p>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="form-wrap" id="tidak-bulanan-wrap" style="display: {{ isset($pegawaiTidakTetap) && $pegawaiTidakTetap->dibayar_bulanan == 0 ? 'block' : 'none' }};">
                    <div class="res-field">
                        <p class="label">Metode Penghitungan</p>
                        <p class="res" id="metodeHitungTidakBulan">{{ $pegawaiTidakTetap->metode_penghitungan ?? '-' }}</p>
                    </div>
                    <div class="res-field">
                        <p class="label">PPh 21 per hari</p>
                        <p class="res" id="pphRataHari">Rp {{ number_format($pegawaiTidakTetap->pph21_perhari ?? 0, 2, ',', '.') }}</p>
                    </div>
                </div>
                <div class="total grand mt-3">
                    <p class="title-total">PPh 21 Terutang</p>
                    <p class="rp-total" id="rp-total">Rp {{ number_format($pegawaiTidakTetap->pph21_terutang ?? 0, 2, ',', '.') }}</p>
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
                    {{-- Mengubah tombol berdasarkan mode edit --}}
                    @if(isset($transaksi))
                        <button class="pay-now" id="save-edit">Simpan Perubahan</button>
                        <button class="later" id="cancel-edit">Batalkan</button>
                    @else
                        <button class="pay-now" id="pay-now">Bayar Sekarang</button>
                        <button class="later" id="remind-later">Ingatkan Nanti</button>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Mengirimkan data transaksi dan pegawaiTetap ke JavaScript --}}
    <script>
        // PENTING: Pastikan data yang dikirim ke JS adalah angka mentah, bukan string berformat
        window.pegawaiTetapData = @json($pegawaiTetap ?? null);
        window.transaksiData = @json($transaksi ?? null);
    </script>
    @vite('resources/js/pages/calculatorPegawaiTidakTetap.js')
@endpush
