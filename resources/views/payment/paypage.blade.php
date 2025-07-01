@extends('layouts.app')

@section('content')
<section class="d-block d-md-flex flex-column">

    <div class="d-flex flex-column p-3">
        <h1><span class="fw-light">Halaman</span> Pembayaran</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>


    <div class="d-flex flex-row gap-4 p-5 pt-0">
        <div class="d-flex flex-column w-50 gap-4">
            {{-- Ringkasan --}}
            <div class="d-flex flex-column border border-2 cyan-blue">
                <h3 class="p-3 m-0">Ringkasan</h3>
                <div class="ringkasan object-fit-md-contain border border-2 mx-4 mb-4 bg-white pt-2">
                    <h5 class="m-0">NPWP</h5>
                    <h5 class="m-0">Status</h5>
                    <h5 class="m-0">Jumlah</h5>
                </div>
                <div class="border border-2 border-start-0 border-end-0 px-5 py-4 mb-4 bg-white">
                    <div class="d-flex flex-row justify-content-between">
                        <h6>Subtotal(Rp)</h6>
                        <h6>Rp.XXXXX</h6>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <h6>Biaya admin</h6>
                        <h6>Rp.XXXXX</h6>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <h4>Jumlah total (Rp)</h4>
                        <h4>Rp.XXXXXX</h4>
                    </div>
                </div>
            </div>
            <div class="border border-2 mt-4 ps-3 py-3 bg-primary">
                <form class="m-0 d-flex flex-row align-items-center justify-content-between" action="">
                    <label for="file-upload" class="p-0 m-0 text-white fw-bold fs-3">Upload Dokumen</label>
                    <input type="file" id="file-upload" name="file">
                </form>
            </div>
        </div>
        <div class="d-flex flex-column w-50">
            {{-- form NPWP --}}
            <div class="form-floating input-field">
                    <input class="form-control" id="floatingNPWP" placeholder="0">
                    <label class="fs-3 p-0" for="floatingNPWP">NPWP</label>
            </div>
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
                <div class="method border border-2 pt-4 pb-5 px-5" id="Credit Card">
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingNumCard" placeholder="0">
                        <label class="fs-3 p-0" for="floatingNumCard">Number Card</label>
                    </div>
                    <div class="d-flex flex-row align-items-center gap-3">
                        <div class="form-floating input-field w-50">
                            <input class="form-control" id="floatingNumCard" placeholder="0">
                            <label class="fs-3 p-0" for="floatingNumCard">CVV</label>
                        </div>
                        <div class="w-50 ">
                            <label class="p-0">Expiry date:</label><br>
                            <input type="date" id="date" name="date">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-lg bg-orange"><h3 class="m-0">Bayar Sekarang</h3></div>
                    </div>


                </div>

                {{-- Gopay --}}
                <div class="method border border-2 p-5 pt-3" id="Gopay" style="display:none">
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingNumCard" placeholder="0">
                        <label class="fs-3 p-0" for="floatingNumCard">Gopay</label>
                    </div>
                </div>

                {{-- OVO --}}
                <div class="method border border-2 p-5 pt-3" id="OVO" style="display:none">
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingNumCard" placeholder="0">
                        <label class="fs-3 p-0" for="floatingNumCard">OVO</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
