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
    <div class="dashboard-cards d-flex flex-nowrap overflow-hidden rounded mb-5">
        <!-- Durasi Jatuh Tempo -->
        <div class="dashboard-card bg-card text-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Durasi Jatuh Tempo</span>
                <div class= "icon-card">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
            <h4>2 Bulan, 4 Hari</h4>
            <p class="fst-italic card-text text-white">Ini adalah sisa waktu yang kamu punya sebelum deadline pembayaran pajak berikutnya.</p>
            <div class="site">
                <a href="#" class="card-text text-white small text-decoration-none"><span class="fw-bold">Bayar</span> Sekarang &rsaquo;</a>
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
                <a href="#" class="card-text text-white small text-decoration-none"><span class="fw-bold">Download</span> Periode Akhir &rsaquo;</a>
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
            <h4>Rp 2.500.000,00</h4>
            <p class="fst-italic card-text text-white">Ini total pajak yang perlu dibayar untuk periode ini. Pastikan data yang kamu input sudah sesuai yaa.</p>
            <div class="d-flex justify-content-between mt-2">
                <a href="#" class="card-text text-white small text-decoration-none fw-bold">
                    Lihat
                    <i class="right-icon bi bi-eye text-white"></i>
                </a>
                <a href="#" class="card-text text-white small">Edit <i class="right-icon bi bi-pencil text-white"></i></a>
            </div>
        </div>
    </div>


    <!-- Kustom Pengingat -->
    <div class="pengingat-wrapper full-width-section p-4 rounded" style="--pengingat-bg: #f0f4ff;">
        <div class="container py-2">
            <h4 class="text-primary">Kustom <span class="fw-normal">Pengingat</span></h4>
        <p class="fst-italic">Gak mau ketinggalan bayar pajak? Atur pengingat sesuai tanggal yang kamu mau. Bebas, fleksibel, dan kamu yang tentuin.</p>

        <div class="split-pengingat">
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
            @foreach (['1 Januari', '1 February', '30 February', '29 Maret'] as $date)
                <div class="d-flex align-items-center px-4 py-2 rounded">
                    <div class="pengingat-buttons">
                    {{-- card tanggal --}}
                        <strong> {{ $date}}</strong>
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
                <h6 class="text-primary">Detail <span class="fw-normal">Pengingat</span></h6>
                <p class="fst-italic text-muted">Jangan lupa tentuin mau diingetin seberapa jauh sebelum hari H ya!</p>

                <div class="d-flex gap-2 mb-3">
                {{-- <input type="number" class="form-control" value="3"> --}}
                <select class="form-select">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <select class="form-select">
                    <option>Minggu</option>
                    <option>Hari</option>
                </select>
                <div class="keterangan-waktu"><p>sebelumnya, pukul</p></div>
                <select class="form-select">
                    <option>07:00</option>
                    <option>10:00</option>
                    <option>13:00</option>
                    <option>16:00</option>
                    <option>19:00</option>
                </select>
                </div>

                <h6 class="text-primary">Email <span class="fw-normal">Pengingat</span></h6>
                <p class="fst-italic text-muted">Kami bakal kirim pengingat lewat email ini. Pastikan udah bener biar notifikasimu ga nyasar.</p>

                <div class="input-group d-flex align-items-center gap-5">
                    <input type="email" class="fw-bold bg-element-orange text-white" value="user@gmail.com">
                    <button class="btn btn-outline-primary">
                        Edit <i class="bi bi-pencil"></i>
                    </button>
                </div>
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

  <!-- Calendar Init Script -->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    let selectedDate = null; // untuk simpan tanggal

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      selectable: true,
      dateClick: function(info) {
        selectedDate = info.dateStr;
        // opsional: tampilkan highlight atau info tanggal
        console.log("Tanggal dipilih:", selectedDate);
      }
    });

    calendar.render();

    // Saat tombol 'Tambah +' diklik
    document.getElementById('btnTambah').addEventListener('click', function () {
      if (selectedDate) {
        alert('Tanggal yang akan disimpan: ' + selectedDate);

        // TODO: bisa lanjut kirim ke server lewat form hidden / fetch / axios
        // contoh:
        // axios.post('/simpan-pengingat', { tanggal: selectedDate });

      } else {
        alert('Pilih tanggal terlebih dahulu dari kalender!');
      }
    });
  });
</script>

@endpush
