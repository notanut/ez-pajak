@extends('layouts.app')

@section('title', 'EzPajak | Kalkulator Pajak untuk Pegawai Tetap')
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
                <h5 class="blue card-title">Informasi Pegawai</h5>
                <div class="form-wrap">
                    <div class="form-floating form-check input-field btn-group" role="group">
                            <p class="label">Apa jenis kelamin Anda?</p>
                            <div class="radio-wrap">
                                <div class="opt">
                                    {{-- Mengisi nilai radio button jika ada data pegawaiTetap --}}
                                    <input type="radio" name="sex" value="Pria" {{ isset($pegawaiTetap) && $pegawaiTetap->jenis_kelamin == 'Pria' ? 'checked' : '' }}> Pria
                                    <label></label>
                                </div>
                                <div class="opt">
                                    <input type="radio" name="sex" value="Wanita" {{ isset($pegawaiTetap) && $pegawaiTetap->jenis_kelamin == 'Wanita' ? 'checked' : '' }}> Wanita
                                    <label></label>
                                </div>
                            </div>
                    </div>
                    <p id="error-jenis_kelamin" class="text-danger small mt-1 mb-0 fw-normal"></p>
                    <div class="form-floating input-field mb-0 mt-3">
                         {{-- Mengisi nilai input jika ada data pegawaiTetap --}}
                         <input type="number" class="form-control" id="floatingInput" placeholder="2" min="0" max="3" value="{{ $pegawaiTetap->tanggungan ?? '' }}">
                        <label for="floatingInput">Berapa total tanggungan Anda?</label>
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
                            <option disabled {{ !isset($pegawaiTetap) ? 'selected' : '' }}>Pilih satu</option>
                            {{-- Mengisi nilai select jika ada data pegawaiTetap --}}
                            <option value="Kawin" {{ isset($pegawaiTetap) && $pegawaiTetap->status_perkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Tidak Kawin" {{ isset($pegawaiTetap) && $pegawaiTetap->status_perkawinan == 'Tidak Kawin' ? 'selected' : '' }}>Tidak Kawin</option>
                            <option value="Hidup Berpisah" {{ isset($pegawaiTetap) && $pegawaiTetap->status_perkawinan == 'Hidup Berpisah' ? 'selected' : '' }}>Hidup Berpisah</option>
                        </select>
                        <label for="floatingSelect">Apa status perkawinan Anda?</label>
                    </div>
                    <p id="error-status_perkawinan" class="text-danger small mt-0 mb-3 fw-normal"></p>

                    <div class="form-date-wrap mt-4">
                        <p class="title-date">Masa Penghasilan</p>
                        <div class="form-date">
                            <div class="w-100">
                                <div class="form-floating input-field w-100">
                                    {{-- Mengisi nilai input month jika ada data pegawaiTetap --}}
                                    <input type="month" id="startMonth" class="form-control" min="2025-01" max="2025-12" name="masa_awal" required value="{{ isset($pegawaiTetap) ? \Carbon\Carbon::parse($pegawaiTetap->masa_penghasilan_awal)->format('Y-m') : '' }}">
                                    <label for="startMonth" class="form-label fst-italic">Bulan Awal</label>
                                </div>
                                <p id="error-masa_awal" class="text-danger small mt-1 mb-0 fw-normal"></p>
                            </div>

                            <div class="w-100">
                                <div class="form-floating input-field w-100">
                                    {{-- Mengisi nilai input month jika ada data pegawaiTetap --}}
                                    <input name="masa_akhir" type="month" id="endMonth" class="form-control" min="2025-01" max="2025-12" required disabled value="{{ isset($pegawaiTetap) ? \Carbon\Carbon::parse($pegawaiTetap->masa_penghasilan_akhir)->format('Y-m') : '' }}">
                                    <label for="endMonth" class="form-label fst-italic">Bulan Akhir</label>
                                </div>
                                <p id="error-masa_akhir" class="text-danger small mt-1 mb-0 fw-normal"></p>
                            </div>
                        </div>
                    </div>

                    <div id="spdnForm" style="display: {{ isset($pegawaiTetap) ? 'block' : 'none' }};" class="form-floating form-check input-field btn-group" role="group">
                        <p class="label">Apakah Anda menjadi Subjek Pajak Dalam Negeri (SPDN) penuh selama tahun ini?</p>
                        <div class="radio-wrap">
                            <div class="opt">
                                {{-- Mengisi nilai radio button jika ada data pegawaiTetap --}}
                                <input type="radio" name="spdn" value="0" id="spdn-ya" {{ isset($pegawaiTetap) && $pegawaiTetap->disetahunkan == 0 ? 'checked' : '' }}> Ya
                                <label></label>
                            </div>
                            <div class="opt">
                                <input type="radio" name="spdn" value="1" id="spdn-tidak" {{ isset($pegawaiTetap) && $pegawaiTetap->disetahunkan == 1 ? 'checked' : '' }}> Tidak
                                <label></label>
                            </div>
                        </div>
                        <div class="tooltip-container spdn">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                SPDN adalah orang pribadi yang bertempat tinggal di Indonesia, orang pribadi yang berada di Indonesia lebih dari 183 hari dalam jangka waktu 12 bulan, atau orang pribadi yang dalam suatu tahun pajak berada di Indonesia dan mempunyai niat untuk bertempat tinggal di Indonesia. Jika menjadi SPDN penuh, maka akan menggunakan perhitungan <b>Setahun</b>. Jika sebaliknya, maka akan menggunakan perhitungan <b>Disetahunkan</b>
                            </div>
                        </div>
                    </div>
                    <p id="error-disetahunkan" class="text-danger small mt-1 mb-0 fw-normal"></p>
                </div>
            </div>

            <div class="card">
                <h5 class="blue card-title">Penghasilan</h5>
                <div class="form-wrap">
                    <div class="form-floating input-field mb-0">
                        {{-- Mengisi nilai input jika ada data pegawaiTetap --}}
                        <input class="form-control rp" id="floatingGaji" placeholder="0" value="{{ $pegawaiTetap->gaji ?? '' }}">
                        <label for="floatingGaji">Gaji/Pensiun Setahun</label>
                    </div>
                    <p id="error-gaji" class="text-danger small mt-1 mb-0 fw-normal"></p>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingPPh" placeholder="0" value="{{ $pegawaiTetap->tunjangan_pph ?? '' }}">
                        <label for="floatingPPh">Tunjangan PPh</label>
                        <div class="tooltip-container">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Tunjangan tambahan yang diberikan oleh pemberi kerja untuk menanggung atau mengganti beban PPh Pasal 21 yang seharusnya dibayar oleh karyawan.
                            </div>
                        </div>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingLain" placeholder="0" value="{{ $pegawaiTetap->tunjangan_lain ?? '' }}">
                        <label for="floatingLain">Tunjangan Lainnya, Uang Lembur, dan sebagainya</label>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingHonor" placeholder="0" value="{{ $pegawaiTetap->honor ?? '' }}">
                        <label for="floatingHonor">Honorarium dan Imbalan Lainnya Sejenisnya</label>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingPremi" placeholder="0" value="{{ $pegawaiTetap->premi ?? '' }}">
                        <label for="floatingPremi">Premi Asuransi yang dibayar Pemberi Kerja</label>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingNatura" placeholder="0" value="{{ $pegawaiTetap->natura ?? '' }}">
                        <label for="floatingNatura">Natura dan Kenikmatan Lainnya</label>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingTantiem" placeholder="0" value="{{ $pegawaiTetap->tantiem ?? '' }}">
                        <label for="floatingTantiem">Tantiem, Bonus, Gratifikasi, Jasa Produksi dan THR</label>
                    </div>

                    <div class="total">
                        <p class="title-total">Total Penghasilan Bruto</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="rp-total">Rp {{ number_format($pegawaiTetap->penghasilan_bruto ?? 0, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="blue card-title">Pengurangan</h5>
                <div class="form-wrap">
                    <div class="res-field">
                        <p class="label">Biaya Jabatan</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p id="biayaJabatan">Rp {{ number_format($pegawaiTetap->biaya_jabatan ?? 0, 2, ',', '.') }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Ditetapkan 5% dari penghasilan bruto, atau maksimal 500 ribu sebulan
                            </div>
                        </div>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingTHT" placeholder="0" value="{{ $pegawaiTetap->iuran_pensiun ?? '' }}">
                        <label for="floatingTHT">Iuran Pensiun atau Iuran THT/JHT</label>
                    </div>

                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingZakar" placeholder="0" value="{{ $pegawaiTetap->zakat ?? '' }}">
                        <label for="floatingZakar">Zakat/Sumbangan Keagamaan yang Bersifat Wajib yang Dibayarkan Melalui Pemberi Kerja</label>
                    </div>

                    <div class="total">
                        <p class="title-total">Total Pengurangan</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="rp-total">Rp {{ number_format($pegawaiTetap->pengurangan ?? 0, 2, ',', '.') }}</p>
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
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="res">Rp {{ number_format($pegawaiTetap->penghasilan_neto ?? 0, 2, ',', '.') }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                <b>Penghasilan bruto</b> dikurangi <b>total pengurangan</b>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingMasaSebelum" placeholder="0" value="{{ $pegawaiTetap->penghasilan_neto_masa_sebelumnya ?? '' }}">
                        <label for="floatingMasaSebelum">Penghasilan Neto Masa sebelumnya</label>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                <b>Total penghasilan neto</b>  sejak awal masa kerja tahun ini sampai bulan sebelum bulan ini
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label">Penghasilan Neto untuk PPh 21 (Setahun/Disetahunkan)</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="res">Rp {{ number_format($pegawaiTetap->penghasilan_neto_pph21 ?? 0, 2, ',', '.') }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                <b>Disetahunkan: </b> Penghasilan dijadikan setara 1 tahun penuh meskipun Anda kerja belum genap setahun
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label">Penghasilan Tidak Kena Pajak (PTKP)</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="res">Rp {{ number_format($pegawaiTetap->ptkp ?? 0, 2, ',', '.') }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Batas penghasilan yang tidak dikenai pajak, tergantung status Anda (belum menikah, sudah menikah, punya tanggungan, dll)
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label" id="pkpsetahun">Penghasilan Kena Pajak Setahun/Disetahunkan</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="res">Rp {{ number_format($pegawaiTetap->pkp ?? 0, 2, ',', '.') }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                <b>Penghasilan Neto Setahun/Disetahunkan</b> dikurangi <b>PTKP</b>
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label">Tarif Pajak Progresif yang Dikenakan</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="res">{{ $pegawaiTetap->tarif_progresif ?? '5%' }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Tarif pajak <b>progresif</b> berarti semakin tinggi penghasilan kena pajak Anda, semakin tinggi persentase pajaknya. Tarif dimulai dari 5% dan naik bertahap sesuai jumlah penghasilan.
                            </div>
                        </div>
                    </div>
                    <div class="res-field">
                        <p class="label" id="pphPkpTitle">PPh Pasal 21 atas PKP Setahun/Disetahunkan</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="res">Rp {{ number_format($pegawaiTetap->pph21_pkp ?? 0, 2, ',', '.') }}</p>
                        <div class="tooltip-container hasil">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Pajak sebelum dikurangi PPh 21 yang telah dipotong/disetor masa sebelumnya.
                            </div>
                        </div>
                    </div>
                    <div class="form-floating input-field">
                        <input class="form-control rp" id="floatingTerpotong" placeholder="0" value="{{ $pegawaiTetap->pph21_dipotong_masa_sebelum ?? '' }}">
                        <label for="floatingTerpotong">PPh 21 yang telah Dipotong Masa Pajak Sebelumnya</label>
                        <div class="tooltip-container">
                            <span class="tooltip-circle">?</span>
                            <div class="tooltip-content">
                                Jumlah PPh 21 yang sudah dipotong dan disetor oleh pemberi kerja untuk pegawai dalam bulan-bulan sebelum masa pajak saat ini.
                            </div>
                        </div>
                    </div>
                    <div class="total grand">
                        <p class="title-total">PPh 21 Terutang</p>
                        {{-- Ini akan diupdate oleh JS, tapi untuk initial load dari PHP --}}
                        <p class="rp-total">Rp {{ number_format($pegawaiTetap->pph21_terutang ?? 0, 2, ',', '.') }}</p>
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
                        <button type="button" class="pay-now" id="save-edit">Simpan Perubahan</button>
                        <button type="button" class="later" id="cancel-edit">Batalkan</button>
                    @else
                        <button type="button" class="pay-now" id="pay-now">Bayar Sekarang</button>
                        <button type="button" class="later" id="remind-later">Ingatkan Nanti</button>
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
    @vite('resources/js/pages/calculator.js')
@endpush
