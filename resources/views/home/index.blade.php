@extends('layouts.app')

@section('content')
@vite('resources/css/home.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<div class="dashboard container py-5">
     <!-- Title -->
     {{-- php -d variables_order=GPCS artisan serve --}}
    <div>
        <h2 class="text-primary">Dashboard <span class="fw-normal">Anda</span></h2>
        <p class="fst-italic">Selamat datang di dashboard! Di sini kamu bisa pantau semua informasi penting soal pembaaran pajak dengan lebih mudah dan praktis.</p>
    </div>

    <div class="d-flex">
        <i class="bi bi-exclamation-circle text-danger"></i>
        <p class="fst-italic text-danger ms-2">Edit section ‘Jumlah Pembayaran Pajak’ buat kamu yang belum mengisi data pembayaran pajak. Kamu akan mendapat panduan lebih lanjut tentang alur pengisian pajak.</p>
    </div>

    <!-- Card Section -->
    <div class="d-flex flex-nowrap overflow-hidden rounded mb-5 flex-column flex-lg-row">
        <!-- Durasi Jatuh Tempo -->
        <div class="dashboard-card bg-card text-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Durasi Jatuh Tempo</span>
                <div class= "icon-card">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
            <h4 id="countdown">– Bulan, – Minggu, – Hari</h4>
            <p class="fst-italic card-text text-white">Ini adalah sisa waktu yang kamu punya sebelum deadline pembayaran pajak berikutnya.</p>
            <div class="site">
                {{-- Arahkan ke halaman pembayaran jika ada transaksi belum lunas --}}
                @if($transaksiCountdown)
                    <a href="{{ route('payment.show', ['transaksi' => $transaksiCountdown->id]) }}" class="card-text text-white small text-decoration-none">
                        <span class="fw-bold">Bayar</span> Sekarang &rsaquo;
                    </a>
                @else
                    {{-- Jika tidak ada tagihan, bisa tampilkan pesan atau sembunyikan link --}}
                    <span class="card-text text-white small">Tidak ada tagihan</span>
                @endif
            </div>
        </div>

        <!-- Unduh PDF -->
        <div class="dashboard-card bg-card2 text-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Unduh PDF</span>
                <div class="icon-card">
                    <i class="bi bi-download"></i>
                </div>
            </div>
            <h4>Bukti Pembayaran</h4>
            <p class="fst-italic card-text text-white">Menampilkan history perhitungan yang telah kamu lakukan. Klik untuk download dan simpan sebagai arsip pribadi.</p>
            <div class="site">
                <a href="/history/{{$pengguna->id}}" class="card-text text-white small text-decoration-none"><span class="fw-bold">Download</span> Periode Akhir &rsaquo;</a>
            </div>
        </div>

        <!-- Jumlah Pembayaran Pajak -->
        <div class="dashboard-card bg-card3 text-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Jumlah Pembayaran Pajak</span>
                <div class="icon-card">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
            {{-- Untuk menampilkan data 'total' dari tabel transaksi. Menggunakan variabel baru: $jumlahPembayaranPajak --}}
            <h4>Rp {{ number_format($jumlahPembayaranPajak ?? 0, 2, ',', '.') }} </h4>
            <p class="fst-italic card-text text-white">Ini total pajak yang perlu dibayar untuk periode ini. Pastikan data yang kamu input sudah sesuai yaa.</p>
            <div class="d-flex justify-content-between mt-2">
                {{-- Tombol Edit dinamis berdasarkan jenis pegawai terakhir --}}
                @php
                    $editRoute = '#'; // Default jika tidak ada jenis pegawai atau transaksi
                    if (isset($jenisPegawaiTerakhir) && $jenisPegawaiTerakhir && isset($latestTransactionId) && $latestTransactionId) {
                        switch ($jenisPegawaiTerakhir) { // <-- TYPO FIXED HERE
                            case 'Pegawai Tetap':
                                $editRoute = route('pegawai-tetap.edit', ['transaksi' => $latestTransactionId]);
                                break;
                            case 'Pegawai Tidak Tetap':
                                $editRoute = route('pegawai-tidak-tetap.edit', ['transaksi' => $latestTransactionId]);
                                break;
                            case 'Bukan Pegawai':
                                $editRoute = route('bukan-pegawai.edit', ['transaksi' => $latestTransactionId]);
                                break;
                        }
                    }
                @endphp
                <a href="{{ $editRoute }}" class="card-text text-white small">Edit <i class="right-icon bi bi-pencil text-white"></i></a>
            </div>
        </div>
    </div>


    <!-- Kustom Pengingat -->
    <div class="pengingat-wrapper full-width-section p-4 rounded" style="--pengingat-bg: #f0f4ff;">
        <div class="container py-2">
            <h4 class="text-primary">Kustom <span class="fw-normal">Pengingat</span></h4>
        <p class="fst-italic">Gak mau ketinggalan bayar pajak? Atur pengingat sesuai tanggal yang kamu mau. Bebas, fleksibel, dan kamu yang tentuin.</p>

        <div class="d-flex flex-column flex-lg-row justify-content-between">
             <div class="keterangan-pengingat">
                <h6 class="mt-4 fw-bold text-primary">Pengingat <span class="fw-normal">Kamu</span></h6>
                <p class="fst-italic">Ini daftar tanggal penting yang udah kamu set. Kami akan bantu ingetin di tanggal itu yaa.</p>
            </div>
            <!-- Action Buttons -->
            <div class="button-pengingat mt-4 d-flex gap-2">
                <button class="btn btn-outline-primary">
                    Bisukan <i class="bi bi-bell-slash"></i>
                </button>
                <button class="btn btn-outline-danger">
                    Hapus <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>

        <!-- Buttons -->
        <div class="d-flex flex-wrap gap-3 mt-3">
            @foreach ($notif as $date)
                <div class="d-flex align-items-center px-4 py-2 rounded">
                    <div class="pengingat-buttons">
                    {{-- card tanggal --}}
                        <strong> {{ $date->scheduled_at }}</strong>
                    </div>
                    <div class="check-wrapper">
                        {{-- card select --}}
                        <input type="checkbox">
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>

    <!-- Tambah Kalender -->
    <div class="addreminder-wrapper py-5">
        <h5 class="text-primary">Tambah <span class="fw-normal">Pengingat</span></h5>
        <p class="fst-italic text-muted">Kamu tinggal pilih tanggal dari kalender dan klik button tambah.</p>
        <div class="row g-4">
            <div class="col-md-6">
                {{-- Kalender bang --}}
                <div id="calendar" style="max-width: 900px; margin: 40px auto;"></div>

                <button id="btnTambah" class="btn btn-outline-success mt-2">
                    Tambah <i class="bi bi-plus"></i>
                </button>
            </div>
            <div class="col-md-6">
                <div class="reminder-detail">
                <form action="{{route('jadwal.notifikasi', $pengguna)}}" method="POST">
                    @csrf
                    <h6 class="text-primary">Detail <span class="fw-normal">Pengingat</span></h6>
                    <p class="fst-italic text-muted">Jangan lupa tentuin mau diingetin seberapa jauh sebelum hari H ya!</p>

                    <div class="d-flex gap-2 mb-3 flex-column flex-md-row">
                    {{-- <input type="number" class="form-control" value="3"> --}}
                    <select class="form-select" name="jumlah" required>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    @error('jumlah')
                        <div class="text-danger mt-1" style="font-size: 0.9rem;">
                            {{ $message }}
                        </div>
                    @enderror
                    <select class="form-select" name="satuan" required>
                        <option value="Minggu">Minggu</option>
                        <option value="Hari">Hari</option>
                    </select>
                    @error('satuan')
                        <div class="text-danger mt-1" style="font-size: 0.9rem;">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="d-flex justify-content-center align-items-center">
                        <p>sebelumnya, pukul</p></div>
                        <select class="form-select" name="waktu" required>
                            <option value="07.00">07:00</option>
                            <option value="10.00">10:00</option>
                            <option value="13.00">13:00</option>
                            <option value="16.00">16:00</option>
                            <option value="19.00">19:00</option>
                        </select>
                    </div>
                    @error('waktu')
                        <div class="text-danger mt-1" style="font-size: 0.9rem;">
                            {{ $message }}
                        </div>
                    @enderror
                    <h6 class="text-primary">Email <span class="fw-normal">Pengingat</span></h6>
                    <p class="fst-italic text-muted">Kami bakal kirim pengingat lewat email ini. Pastikan udah bener biar notifikasimu ga nyasar.</p>

                    <div class="input-group d-flex align-items-center gap-5">
                        <input type="email" class="fw-bold bg-element-orange text-white" name="email" value="{{$pengguna->email}}" readonly>
                        {{-- <button class="btn btn-outline-primary">
                            Edit <i class="bi bi-pencil"></i>
                        </button> --}}
                        <button type="submit" class="btn btn-outline-primary">Jadwalkan Notifikasi</button>
                    </div>
                </form>

            </div>
            </div>
        </div>
    </div>
</div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
@endsection

@push('scripts')
    <!-- FullCalendar CDN CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    @vite('resources/js/pages/home.js')
@endpush
