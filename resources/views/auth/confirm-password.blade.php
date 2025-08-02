@extends('layouts.app')

@section('content')
@vite('resources/css/login_register.css')
<main>
    <div class="container mt-6 mb-6">
        <div class="card shadow-sm bg-white p-0 border-0">
            <div class="card-body p-4">
                <div class="text-center">
                    <h2 class="fw-bold text-primary mb-4">Konfirmasi Password</h2>
                    <p class="text-muted mb-4">
                        Ini adalah area aman aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-primary">Password</label>
                            <input type="password" class="form-control form-setting border-setting rounded-0 shadow-none"
                                id="password" name="password" required autocomplete="current-password" 
                                placeholder="Masukkan password Anda">
                            @error('password')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary fw-bold">
                                Konfirmasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection