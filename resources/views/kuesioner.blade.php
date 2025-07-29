@extends('layouts.app')

@section('content')

    <section class="py-5" style="background-color: #FBFBFB;">
        <div class="container py-0">
            <!-- Heading -->
            <div class="mb-0">
                <h2 class="fw-bold text-blue">Mulai Perhitungan <span class="fw-normal"> Kamu Disini</span></h2>
                <p class="mb-0" style="color:#142143; font-style:italic">
                    Sebelum masuk ke perhitungan, kamu termasuk kategori mana nih?
                </p>
            </div>

            <!-- Cards -->
            <div class="row g-4 mt-0">
                <!-- Pegawai Tetap -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 m-0">
                        <div class="card-body text-center px-4 py-3">
                            <img src="{{asset('images/home_PegawaiTetap.png')}}" class="img-fluid mb-2" style="max-height: 120px;" alt="Pegawai Tetap">
                            <h5 class="my-3 text-blue" style="font-size: 2vw;">
                                <span class="fw-normal">Pegawai</span> Tetap
                            </h5>
                            <p class="mb-3 fst-italic" style="color: #142143; font-size: 1vw;">
                                Pilih jika kamu bekerja dengan penghasilan rutin bulanan dan memiliki <strong>kontrak kerja jangka panjang</strong>.
                            </p>
                            <a href="/calculator/pegawai" class="btn btn-warning d-inline-flex align-items-center gap-2 px-3 py-2 text-white rounded-0" style="background-color: #FE8F1D">
                                Hitung <img src="{{asset('images/home_Calculator.png')}}" alt="Calculator" style="width: 20px;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pegawai Tidak Tetap -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 m-0">
                        <div class="card-body text-center px-4 py-3">
                            <img src="{{asset('images/home_PegawaitidakTetap.png')}}" class="img-fluid mb-2" style="max-height: 120px;" alt="Pegawai Tidak Tetap">
                            <h5 class="my-3 text-blue" style="font-size: 2vw;">
                                <span class="fw-normal">Pegawai</span> tidak Tetap
                            </h5>
                            <p class="mb-3 fst-italic" style="color: #142143; font-size: 1vw;">
                                Pilih jika kamu bekerja di perusahaan sebagai pegawai tapi <strong>tanpa kontrak tetap</strong>, dan hanya dibayar jika bekerja.
                            </p>
                            <a href="/calculator/pegawaiTidakTetap" class="btn btn-warning d-inline-flex align-items-center gap-2 px-3 py-2 text-white rounded-0" style="background-color: #FE8F1D">
                                Hitung <img src="{{asset('images/home_Calculator.png')}}" alt="Calculator" style="width: 20px;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bukan Pegawai -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 m-0">
                        <div class="card-body text-center px-4 py-3">
                            <img src="{{asset('images/home_BukanPegawai.png')}}" class="img-fluid mb-2" style="max-height: 120px;" alt="Bukan Pegawai">
                            <h5 class="my-3 text-blue" style="font-size: 2vw;">
                                <span class="fw-normal">Bukan</span> Pegawai
                            </h5>
                            <p class="mb-3 fst-italic" style="color: #142143; font-size: 1vw;">
                                Pilih jika kamu memberikan jasa pribadi seperti <strong>freelance</strong> atau konsultan, tidak terikat karyawan.
                            </p>
                            <a href="/calculator/bukanPegawai" class="btn btn-warning d-inline-flex align-items-center gap-2 px-3 py-2 text-white rounded-0" style="background-color: #FE8F1D">
                                Hitung <img src="{{asset('images/home_Calculator.png')}}" alt="Calculator" style="width: 20px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
