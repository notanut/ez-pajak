@extends('layouts.app')

@section('content')
@vite('resources/css/login_register.css')
<main>
    <div class="container mt-6 mb-6">
        <div class="card shadow-sm bg-white p-0 border-0">
            <div class="card-body p-0">
                <div class="row g-0">
                     <!-- left section -->
                      <div class="col-lg-6 d-flex flex-column justify-content-between align-items-center left-section">
                        <div class="inner-left-section mt-2 mb-2">
                            <div class="content-top">
                                <div>
                                    <h2 class="fw-bold text-primary">Ez Pay Ez Pajak</h2>
                                    <p class="text-primary">Masuk ke akunmu dan nikmati cara paling gampang buat kelola kewajiban pajak</p>
                                    <img class="register-illustration" src="{{ asset('assets/login-registration/register-illustration.svg') }}" alt="Illustration">
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-evenly align-item-center gap-5">
                                <img src="{{ asset('assets/login-registration/social-media/ic_baseline-facebook.svg') }}" alt="Facebook">
                                <img src="{{ asset('assets/login-registration/social-media/mdi_instagram.svg') }}" alt="Instagram">
                                <img src="{{ asset('assets/login-registration/social-media/devicon_twitter.svg') }}" alt="X">
                                <img src="{{ asset('assets/login-registration/social-media/mdi_linkedin.svg') }}" alt="LinkedIn">
                            </div>
                        </div>
                    </div>

                    <!-- right section -->
                    <div class="col-lg-6 d-flex flex-column justify-content-between align-items-center right-section">
                        <div class="inner-right-section mt-2 mb-2">
                                <div class="d-flex gap-2 mb-3">
                                    <h2 class="fw-bold text-primary">Buat</h2>
                                    <h2 class="fw-light text-primary">Akun</h2>
                                </div>
                            <form class="form-register" action="{{ route('pengguna.store')}}" method="POST">
                                @csrf
                                <!-- form content goes here -->
                                 <div class="d-flex flex-column mb-3">
                                    <label for="nama" class="form-label fw-semibold text-primary m-0">Nama Lengkap</label>
                                    <input type="text" class="form-setting border-setting  rounded-0 shadow-none ps-0" value="{{ old('nama') }}" 
                                        name="nama" id="nama" placeholder="Daftarkan nama lengkap kamu" @error('nama') is-invalid @enderror>
                                    @error('nama')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column mb-3">
                                    <label for="email" class="form-label fw-semibold text-primary m-0">Alamat Email</label>
                                    <input type="email" class="form-setting border-setting rounded-0 shadow-none ps-0" value="{{ old('email') }}"
                                        name="email" id="email" placeholder="mail@domain.com" @error('email') is-invalid @enderror>
                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column mb-3">
                                    <label for="password" class="form-label fw-semibold text-primary m-0">Password</label>
                                    <input type="password" class="form-setting border-setting rounded-0 shadow-none ps-0" value="{{ old('password') }}"
                                        name="password" id="password" placeholder="Min. 8 karakter" @error('password') is-invalid @enderror>
                                    @error('password')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column mb-3">
                                    <label for="konfirmasiPassword" class="form-label fw-semibold text-primary m-0">Konfirmasi Password</label>
                                    <input type="password" class="form-setting border-setting rounded-0 shadow-none ps-0" value="{{ old('password_confirmation') }}"
                                        name="password_confirmation" id="password_confirmed" placeholder="Ketik ulang password" @error('konfirmasiPassword') is invalid @enderror>
                                    @error('konfirmasiPassword')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-center align-item center">
                                    <button type="submit" class="btn btn-primary fw-bold mt-3">Daftar</button>
                                </div>
                            </form>
                            <p class="text-center mt-3">Sudah punya akun? <a href="" class="text-login fw-semibold text-decoration-none">Masuk di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection