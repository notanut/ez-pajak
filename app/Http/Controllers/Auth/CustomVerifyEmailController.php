<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class CustomVerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(config('app.home', '/dashboard').'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Ambil URL dari session, jika tidak ada, gunakan default '/dashboard'
        $redirectUrl = session('url.intended', config('app.home', '/dashboard'));

        // Hapus session agar tidak digunakan lagi di waktu lain
        session()->forget('url.intended');

        // Redirect ke URL tujuan dengan notifikasi
        return redirect()->to($redirectUrl)->with('verified', true);
    }
}