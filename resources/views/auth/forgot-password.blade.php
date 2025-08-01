{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('content')
@vite('resources/css/login_register.css')
<main>
    <div class="container mt-6 mb-6" style="width: 50%;">
        <div class="card shadow-sm bg-white p-0 border-0">
            <div class="card-body m-5">
                <div class="text-center">
                    <h2 class="fw-bold text-primary mb-4">Lupa Password?</h2>
                    
                    <div class="mb-4">
                        <img src="{{ asset('images/forgot_password_illustration.png') }}" 
                             alt="Forgot Password" class="img-fluid" style="max-width: 200px;">
                    </div>
                    
                    <p class="text-muted mb-4">
                        Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan 
                        tautan reset password yang memungkinkan Anda memilih yang baru.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="d-flex flex-column mb-4">
                            <label for="email" class="form-label fw-semibold text-primary p-0">Alamat Email</label>
                            <input type="email" class="form-setting border-setting rounded-0 shadow-none ps-0"
                                id="email" name="email" value="{{ old('email') }}" 
                                placeholder="mail@domain.com" required>
                            @error('email')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold mb-3">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <p class="text-center">
                        <a href="{{ route('login') }}" class="text-login fw-semibold text-decoration-none">
                            Kembali ke Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection