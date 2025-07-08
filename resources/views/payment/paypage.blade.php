@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/paypage.css') }}">
@section('content')
<main class="container py-4">
    <section class="d-block d-md-flex flex-column">

        <div class="d-flex flex-column p-3">
            <h1><span class="fw-light">Halaman</span> Pembayaran</h1>
            <p>Tinggal selangkah lagi nih. Pengisian data dibawah ini yang sudah kami rangkum rapi sesuai regulasi masa kini. Kamu tinggal pilih metode pembayaran yang paling nyaman dan cocok buat kamu yaa!</p>
        </div>


        <div class="row">
            <div class="col-12 col-md-6 d-flex flex-column gap-4">
                {{-- Ringkasan --}}
                <div class="d-flex flex-column border border-2 cyan-blue">
                    <h3 class="p-3 m-0">Ringkasan</h3>
                    <div class="ringkasan object-fit-md-contain border border-2 mx-4 mb-4 bg-white pt-2">
                        <div class="column">
                            <h5 class="m-0">NPWP</h5>
                            <h5 class="m-0 mt-2" id="outputNPWP"></h5>
                            {{-- @if ($detail instanceof \App\Models\PegawaiTetap)
                                <h5 class="m-0 mt-2">{{$detail->role}}</h5>
                            @elseif ($detail instanceof \App\Models\PegawaiTidakTetap)
                                <h5 class="m-0 mt-2">{{$detail->role}}</h5>
                            @elseif ($detail instanceof \App\Models\BukanPegawai)
                                <h5 class="m-0 mt-2">{{$detail->role}}</h5>

                            @else
                                <h5 class="m-0 mt-2">Gaada wkkw</h5>
                            @endif --}}
                        </div>
                        <div class="column">
                            <h5 class="m-0">Status</h5>
                            <h5 class="m-0 mt-2">{{$status}}</h5>
                        </div>
                        <div class="column">
                            <h5 class="m-0">Jumlah</h5>
                            <h5 class="m-0 mt-2">XXXXXXX</h5>
                        </div>
                    </div>
                    <div class="border border-2 border-start-0 border-end-0 px-5 py-4 mb-4 bg-white">
                        <div class="d-flex flex-row justify-content-between">
                            <h6>Subtotal(Rp)</h6>
                            <h6>Rp.{{$transaksi->total}}</h6>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <h6>Biaya admin</h6>
                            <h6>Rp.{{$transaksi->total / 100}}</h6>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <h4>Jumlah total (Rp)</h4>
                            <h4>Rp.{{$transaksi->total + $transaksi->total/100}}</h4>
                        </div>
                    </div>
                </div>
                <div class="border border-2 mt-3 ps-3 py-3 bg-primary">
                    <form class="m-0 d-flex flex-row align-items-center justify-content-between" action="">
                        <label for="file-upload" class="p-0 m-0 text-white fw-bold fs-3">Upload Dokumen</label>
                        <input type="file" id="file-upload" name="file">
                        <img class="upload" src="{{asset('img/material-symbols_upload.png')}}" alt="">
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex flex-column">
                {{-- form NPWP --}}
                <form id="dataNPWP" class="form-floating input-field">
                        <input type="text" class="form-control" id="NPWP" placeholder="0">
                        <label class="fs-3 p-0" for="floatingNPWP">NPWP</label>

                </form>
                {{-- Metode Pembayaran --}}
                <div class="d-flex flex-column">
                    <h3>Metode Pembayaran</h3>
                    {{-- Pilihan metode --}}
                    <div class="d-flex flex-row gap-2 justify-content-between">
                        <button class="border border-2 p-3 w-25" onclick="openMethod('Credit Card')">Credit Card</button>
                        <button class="border border-2 p-3 w-25" onclick="openMethod('Gopay')">Gopay</button>
                        <button class="border border-2 p-3 w-25" onclick="openMethod('OVO')">OVO</button>
                    </div>

                    {{-- Credit Card --}}
                    <div class="method border border-2 py-4 px-5 paybox" id="Credit Card" style="display: none">
                        <div class="form-floating input-field">
                            <input class="form-control" id="floatingNumCard" placeholder="0">
                            <label class="fs-4 p-0" for="floatingNumCard">Number Card</label>
                        </div>
                        <div class="d-flex flex-row align-items-center gap-3 mb-4">
                            <div class="form-floating input-field w-50">
                                <input class="form-control" id="floatingNumCard" placeholder="0">
                                <label class="fs-4 p-0" for="floatingNumCard">CVV</label>
                            </div>
                            <div class="w-50">
                                <label class="fs-5 p-0">Expiry date</label><br>
                                <div class="input-grup">
                                    <input class="expiry-date input-field" type="text" id="expiry-day" maxlength="2">
                                    <span>/</span>
                                    <input class="expiry-date input-field" type="text" id="expiry-month" maxlength="2">
                                    <span>/</span>
                                    <input class="expiry-date input-field" type="text" id="expiry-year" maxlength="4">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="/payment/success" class="btn btn-lg bg-orange"><h3 class="m-0">Bayar Sekarang</h3></a>
                        </div>
                    </div>

                    {{-- Gopay --}}
                    <div class="method border border-2 p-5 pt-3 paybox" id="Gopay" style="display:none">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div class="form-floating input-field">
                                <input class="form-control" id="floatingNumCard" placeholder="0">
                                <label class="fs-3 p-0" for="floatingNumCard">Gopay</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="/payment/success" class="btn btn-lg bg-orange"><h3 class="m-0">Bayar Sekarang</h3></a>
                            </div>
                        </div>
                    </div>

                    {{-- OVO --}}
                    <div class="method border border-2 p-5 pt-3 paybox" id="OVO" style="display:none">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div class="form-floating input-field">
                                <input class="form-control" id="floatingNumCard" placeholder="0">
                                <label class="fs-3 p-0" for="floatingNumCard">OVO</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="/payment/success" class="btn btn-lg bg-orange"><h3 class="m-0">Bayar Sekarang</h3></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
{{-- JS --}}
    <script src="{{ asset('js/paypage.js') }}"></script>
@endsection
