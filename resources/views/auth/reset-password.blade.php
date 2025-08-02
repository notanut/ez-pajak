{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.app')

@section('content')
@vite('resources/css/login_register.css')
<main>
    <div class="container mt-6 mb-6" style="width: 50%;">
        <div class="d-flex flex-column justify-content-center align-items-center card shadow-sm bg-white p-0 border-0">
            <div class="card-body p-4" style="width:85%;">
                <div class="d-flex flex-column text-center">
                    <h2 class="fw-bold text-primary mb-4">Reset Password</h2>
                    
                    <div class="mb-4">
                        <img src="{{ asset('images/reset_password_illustration.png') }}" 
                             alt="Reset Password" class="img-fluid" style="max-width: 200px;">
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="d-flex flex-column mb-3">
                            <label for="email" class="form-label fw-semibold text-primary">Alamat Email</label>
                            <input type="email" class="form-setting border-setting rounded-0 shadow-none ps-0"
                                id="email" name="email" value="{{ old('email', $request->email) }}" required>
                            @error('email')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex flex-column mb-3">
                            <label for="password" class="form-label fw-semibold text-primary">Password Baru</label>
                            <input type="password" class="form-setting border-setting rounded-0 shadow-none ps-0"
                                id="password" name="password" placeholder="Masukkan password baru" required>
                            @error('password')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex flex-column mb-5">
                            <label for="password_confirmation" class="form-label fw-semibold text-primary">Konfirmasi Password</label>
                            <input type="password" class="form-setting border-setting rounded-0 shadow-none ps-0"
                                id="password_confirmation" name="password_confirmation" 
                                placeholder="Konfirmasi password baru" required>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection