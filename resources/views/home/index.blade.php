@extends('layouts.app')

@section('content')
@vite('resources/css/home.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<div class="dashboard container py-5">
     <!-- Title -->
     {{-- php -d variables_order=GPCS artisan serve --}}
    <div>
        <h2 class="text-primary">Dashboard <span class="fw-normal">Anda</span></h2>
        <p class="fst-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
            <p class="fst-italic card-text text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            <div class="site">
                <a href="#" class="card-text text-white small text-decoration-none"><span class="fw-bold">Lihat</span> Sementara &rsaquo;</a>
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
            <p class="fst-italic card-text text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            <div class="site">
                <a href="#" class="card-text text-white small text-decoration-none"><span class="fw-bold">Lihat</span> Sementara &rsaquo;</a>
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
            <p class="fst-italic card-text text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
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
        <p class="fst-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

        <div class="split-pengingat">
             <div class="keterangan-pengingat">
                <h6 class="mt-4 fw-bold text-primary">Pengingat <span class="fw-normal">Anda</span></h6>
                <p class="fst-italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
        {{-- <div class="d-flex flex-wrap gap-3 mt-3 pengingat-buttons">
            @foreach(['1 Januari', '1 Februari', '30 February', '29 Maret'] as $tanggal)
                <div class="d-flex align-items-center justify-content-between px-4 py-2 rounded pengingat-item">
                    <div class="date-wrapper">
                        <strong>{{ $tanggal }}</strong>
                    </div>
                    <div class="check-wrapper">
                        <input type="checkbox" />
                    </div>
                </div>
            @endforeach
        </div> --}}
        </div>
    </div>

    <!-- Tambah Kalender -->
    <div class="addreminder-wrapper py-5">
        <h5 class="text-primary">Tambah <span class="fw-normal">Pengingat</span></h5>
        <p class="fst-italic text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <div class="row g-4">
            <div class="col-md-6">
                {{-- saya ingin meletakan calendar disini --}}
                {{-- <div class="calendar bg-white p-3 rounded shadow-sm">
                <!-- Kalender dummy -->
                <table class="table table-borderless text-center">
                <thead>
                    <tr>
                    <th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy rows -->
                    <tr><td>28</td><td>29</td><td>30</td><td>31</td><td>1</td><td>2</td><td>3</td></tr>
                    <tr><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td></tr>
                    <tr><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td></tr>
                    <tr><td>18</td><td>19</td><td>20</td><td class="text-white bg-primary rounded-circle">22</td><td>23</td><td>24</td><td>25</td></tr>
                </tbody>
                </table>
            </div> --}}

                <button class="btn btn-outline-success mt-5">
                    Tambah <i class="bi bi-plus"></i>
                </button>
            </div>
            <div class="col-md-6">
                <div class="reminder-detail">
                <h6 class="text-primary">Detail <span class="fw-normal">Pengingat</span></h6>
                <p class="fst-italic text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                <div class="d-flex gap-2 mb-3">
                {{-- <input type="number" class="form-control" value="3"> --}}
                <select class="form-select">
                    <option>3</option>
                </select>
                <select class="form-select">
                    <option>Minggu</option>
                    <option>Hari</option>
                </select>
                <div class="keterangan-waktu"><p>sebelumnya, pukul</p></div>
                {{-- <select class="form-select w-50">
                    <option>sebelumnya, pukul</option>
                </select> --}}
                <select class="form-select">
                    <option>10:00</option>
                </select>
                </div>

                <h6 class="text-primary">Tambah <span class="fw-normal">Pengingat</span></h6>
                <p class="fst-italic text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt</p>

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
{{-- @push('scripts')
    @vite('resources/js/pages/home.js') --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
@endsection
