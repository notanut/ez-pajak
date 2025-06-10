@extends('layouts.app')

@section('content')
<section class="d-block d-md-flex flex-column">

    <div class="d-flex flex-column p-3">
        <h2>Halaman Pembayaran</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>


    <div class="d-flex flex-row gap-5 p-5 pt-0">
        <div class="d-flex flex-column w-50">
            {{-- Ringkasan --}}
            <div class="d-flex flex-column border border-2 cyan-blue">
                <h3 class="p-3 m-0">Ringkasan</h3>
                <div class="ringkasan object-fit-md-contain border border-2 ms-4 me-4 mb-5 bg-white">
                    <h5 class="m-0">NPWP</h5>
                    <h5 class="m-0">Status</h5>
                    <h5 class="m-0">Jumlah</h5>
            </div>
            <div class="border border-2 border-start-0 border-end-0 p-5 mb-4 bg-white">
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
            <div class="border border-2 mt-5">
                <h3 class="m-0 p-3">Upload Dokumen</h3>
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
                <div class="d-flex flex-row gap-2 justify-content-between">
                    <div class="border border-2 p-3">
                        <h5 class="m-0">Credit Card</h5s>
                    </div>
                    <div class="border border-2 p-3">
                        <h5 class="m-0">Credit Card</h5>
                    </div>
                    <div class="border border-2 p-3">
                        <h5 class="m-0">Credit Card</h5>
                    </div>
                </div>
                <div class="border border-2 p-5 pt-0">
                    <div class="form-floating input-field">
                        <input class="form-control" id="floatingNumCard" placeholder="0">
                        <label class="fs-3 p-0" for="floatingNumCard">Number Card</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
