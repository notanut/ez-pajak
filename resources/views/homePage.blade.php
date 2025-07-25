@extends('layouts.app')

@section('content')
    <section class="py-5 px-5">
        <div class="container-fluid m-0">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 text-center text-lg-start mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-3 text-blue"><span class="fw-normal">Apa itu </span> EZPajak ?</h1>
                    <p class="lead mb-4">
                        EZPajak adalah website interaktif berbasis browser yang memandu warga Indonesia
                        menyiapkan dan mengekspor SPT Tahunan secara mudah dan aman.
                    </p>
                    <a href="#calculatorCards" class="btn btn-lg rounded-0 px-4 py-3 d-inline-flex align-items-center w-200 h-40 text-white" style="background-color:#FE8F1D">
                        Coba Sekarang
                        {{-- <i class="ms-2 bi bi-box-arrow-up-right"></i> --}}
                        <img src="images/icon_login.png" alt="Paper Plane" style="width: 25px; height: auto;" class="ms-2">
                    </a>
                    
                </div>

                <div class="col-lg-6 col-md-12 text-center">
                    <img src="images/ilustrasi_homePage1.png" alt="EZPajak Illustration" class="img-fluid">
                </div>
            </div>

            <div class="row mt-5 pt-4">
                <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                    <div class="d-flex align-items-start">
                        <img src="images/icon_smartWay.png" alt="Smart Way Icon" class="me-3" style="width: 30px; height: 30px;">
                        <div>
                            <h4 class="fw-bold text-blue">Smart Way</h4>
                            <p class="mb-0 fst-italic" style="color: #142143">Kamu bisa atur pembayaran pajak tanpa ribet. Karena yang susah, biar kami yang uruss.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="d-flex align-items-start">
                        <img src="images/icon_autoFlow.png" alt="Auto Flow Icon" class="me-3" style="width: 30px; height: 30px;">
                        <div>
                            <h4 class="fw-bold text-blue">Auto Flow</h4>
                            <p class="mb-0 fst-italic" style="color: #142143">Kami menyediakan alur perhitungan dan pembayaran otomatis dari awal sampai selesai loh!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="background-color: #EEF2F8;" id="calculatorCards">
        <div class="container py-0">
            <!-- Heading -->
            <div class="mb-0">
                <h2 class="" style="color: #151F6D">Fitur Unggulan <span class="fw-normal">Kami</span></h2>
                <p class="mb-0 fst-italic" style="color:#142143">
                    Kami menyediakan beberapa metode pembayaran pajak yang sesuai dengan regulasi saat ini. Semua proses disederhanakan, dan cocok buat kamu yang baru mulai. Jadi, yuk pilih sekarang.
                </p>
            </div>

            <!-- Cards -->
            <div class="row g-4 mt-0">
                <!-- Pegawai Tetap -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 m-0">
                        <div class="card-body text-center px-4 py-3">
                            <img src="images/home_PegawaiTetap.png" class="img-fluid mb-2" style="max-height: 120px;" alt="Pegawai Tetap">
                            <h5 class="my-3 text-blue" style="font-size: 2vw;">
                                <span class="fw-normal">Pegawai</span> Tetap
                            </h5>
                            <p class="mb-3 fst-italic" style="color: #142143; font-size: 1vw;">
                                Pilih jika kamu bekerja dengan penghasilan rutin bulanan dan memiliki <strong>kontrak kerja jangka panjang</strong>.
                            </p>
                            <a href="/calculator/pegawai" class="btn btn-warning d-inline-flex align-items-center gap-2 px-3 py-2 text-white rounded-0" style="background-color: #FE8F1D">
                                Hitung <img src="images/home_Calculator.png" alt="Calculator" style="width: 20px;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pegawai Tidak Tetap -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 m-0">
                        <div class="card-body text-center px-4 py-3">
                            <img src="images/home_PegawaitidakTetap.png" class="img-fluid mb-2" style="max-height: 120px;" alt="Pegawai Tidak Tetap">
                            <h5 class="my-3 text-blue" style="font-size: 2vw;">
                                <span class="fw-normal">Pegawai</span> tidak Tetap
                            </h5>
                            <p class="mb-3 fst-italic" style="color: #142143; font-size: 1vw;">
                                Pilih jika kamu bekerja di perusahaan sebagai pegawai tapi <strong>tanpa kontrak tetap</strong>, dan hanya dibayar jika bekerja.
                            </p>
                            <a href="/calculator/pegawaiTidakTetap" class="btn btn-warning d-inline-flex align-items-center gap-2 px-3 py-2 text-white rounded-0" style="background-color: #FE8F1D">
                                Hitung <img src="images/home_Calculator.png" alt="Calculator" style="width: 20px;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bukan Pegawai -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 m-0">
                        <div class="card-body text-center px-4 py-3">
                            <img src="images/home_BukanPegawai.png" class="img-fluid mb-2" style="max-height: 120px;" alt="Bukan Pegawai">
                            <h5 class="my-3 text-blue" style="font-size: 2vw;">
                                <span class="fw-normal">Bukan</span> Pegawai
                            </h5>
                            <p class="mb-3 fst-italic" style="color: #142143; font-size: 1vw;">
                                Pilih jika kamu memberikan jasa pribadi seperti <strong>freelance</strong> atau konsultan, tidak terikat karyawan.
                            </p>
                            <a href="/calculator/bukanPegawai" class="btn btn-warning d-inline-flex align-items-center gap-2 px-3 py-2 text-white rounded-0" style="background-color: #FE8F1D">
                                Hitung <img src="images/home_Calculator.png" alt="Calculator" style="width: 20px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="py-5 px-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Kiri: Text -->
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="images/icon_centang.png" alt="Checklist" style="width: 24px; height: 24px;" class="me-2">
                    <h5 class="mb-0 text-blue" style="font-size: 2vw;">
                        <span class="fw-normal">Easy Tax Solutions </span> for Everyone
                    </h5>
                </div>
                <p class="text-blue mb-0" style="color:#142143;">
                    Ez Pajak memudahkan kamu menghitung dan membayar PPh 21 langsung ke DJP dengan cepat, aman, dan tanpa ribet.
                    Data diproses secara lokal di perangkat kamu untuk menjaga privasi, dan informasi pribadi hanya diminta jika kamu memilih membayar lewat aplikasi.
                    Dengan fitur login opsional, kamu juga bisa mengatur pengingat agar tidak lupa bayar pajak.
                    Praktis, aman, dan dirancang khusus untuk warga Indonesia.
                </p>
            </div>

            <!-- Kanan: Ilustrasi -->
            <div class="col-lg-6 col-md-12 d-flex flex-end flex-column align-items-end">
                <h2 class="fw-bold text-blue text-end">
                    Kenapa <br> <span class="fw-normal">Pilih EzPajak?</span>
                </h2>
                <img src="images/IlustrasiHomePage2.png" alt="Kenapa Pilih EzPajak" class="img-fluid mt-3" style="max-height: 300px; object-fit: contain;">
            </div>
        </div>
    </div>
</section>




@endsection