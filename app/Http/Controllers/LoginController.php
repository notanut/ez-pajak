<?php

namespace App\Http\Controllers;

// use App\Models\User;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // --- UNTUK DEBUGGING ---

        // $user = User::where('email', $credentials['email'])->first();
        // if ($user) {
        //     dd(Hash::check($credentials['password'], $user->password));
        // } else {
        //     dd('User dengan email tersebut tidak ditemukan.');
        // }
        // --- AKHIR LANGKAH DEBUGGING ---

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang diberikan tidak cocok.',
        ])->onlyInput('email');
    }

    public function exit() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('exit');
    }

    // use AuthenticatesUsers;

    // /**
    //  * Where to redirect users after login.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = '/home';
}
