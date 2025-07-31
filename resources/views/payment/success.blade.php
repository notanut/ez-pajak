@extends('layouts.app')
@section('title', 'EzPajak | Pembayaran Berhasil')

@section('content')
<section class="d-flex flex-column justify-content-center align-items-center text-center my-5">
    <h1 class="text-primary">Hore! Pembayaran Berhasil!</h1>
    <div class="p-4" style="max-width: 450px;">
        <img src="{{ asset('assets/payment-success/pembayaran-sukses.png') }}" alt="Pembayaran Sukses" class="img-fluid">
    </div>
    <button class="to-dashboard"><a class="link-home" href="/home">Ke Dashboard Saya</a></button>
</section>
@endsection