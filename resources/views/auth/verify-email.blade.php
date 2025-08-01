@extends('layouts.app')

@section('content')
@vite('resources/css/login_register.css')
<main>
    <div class="container mt-5 mb-5" style="width: 50%;">
        <div class="card shadow-sm bg-white p-0 border-0">
            <div class="card-body p-5">
                <div class="text-center">
                    <h2 class="fw-bold text-primary mb-6">Verifikasi Email Anda</h2>
                    
                    <div class="mb-4">
                        <img src="{{ asset('images/email_verification_illustration.png') }}" 
                             alt="Email Verification" class="img-fluid" style="max-width: 200px;">
                    </div>
                    
                    <p class="text-muted mb-4">
                        Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda 
                        dengan mengklik tautan yang baru saja kami kirimkan ke email Anda? 
                        Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang lain.
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4">
                            Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                        </div>
                    @endif

                    <div class="d-flex gap-3 justify-content-center">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary fw-bold flex-fill w-100">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary fw-bold flex-fill w-100">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection