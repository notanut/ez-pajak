@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column">
        <h1>Riwayat Perhitungan Kamu</h1>
        <p>Hasil perhitungan yang telah kamu input tersimpan dalam list ini. Unduh untuk disimpan menjadi arsip pribadi.</p>
        
        <!-- Tabel Riwayat Perhitungan -->
        <div class="row">
            <div class="col">
                <h5 class="fw-bold">No</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Metode Pembayaran</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Total</h5>
            </div>
            <div class="col">
                <h5 class="fw-bold">Aksi</h5>
            </div>
        </div>

        {{-- Menampilkan Riwayat Perhitungan --}}
        @foreach ($Transaksi as $index => $item)
        <div class="row">
            <div class="col">
                <p>{{ $index + 1 }}</p> <!-- Nomor Urut -->
            </div>
            <div class="col">
                <p>{{ $item->metode_pembayaran }}</p> <!-- Nama Dokumen -->
            </div>
            <div class="col">
                <p>{{ $item->total }}</p> <!-- Periode -->
            </div>
            <div class="col">
                <a href="{{ route('download', $item->id) }}" class="btn btn-primary">Unduh</a> <!-- Aksi untuk Unduh -->
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
