@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column">
        <h1>Riwayat Perhitungan Kamu</h1>
        <p>Hasil perhitungan yang telah kamu input tersimpan dalam list ini. Unduh untuk disimpan menjadi arsip pribadi.</p>
        <div class="row">
            <div class="col">
                <h5 class="fw-bold">No</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Nama Dokumen</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Periode</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Aksi</h5>
            </div>
        </div>

        {{-- @foreach ( as )
        <div class="row">
            <div class="col">
                <h5 class="fw-bold">No</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Nama Dokumen</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Periode</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Aksi</h5>
            </div>
        </div>
        @endforeach --}}
    </div>
</div>
@endsection
