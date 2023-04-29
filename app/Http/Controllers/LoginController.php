<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth')->only('logout');
    }

    public function getLoginPage()
    {
        return view('components/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
//        if (Auth::attempt($credentials, true)) {
//            Auth::login(Auth::user(), true);
//            return redirect()->intended('me');
//        }
        if ( Auth::guard('web')->attempt($credentials, true) ) {
            return Auth::user();
        }

        return redirect('login')->withErrors(['credentials' => 'Invalid credentials']);
    }

    public function me()
    {
        $user = Auth::guard('web')->user();

        if ($user) {
            return json_encode($user);
        } else {
            return 'Not logged in';
        }

    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('login');
    }
}
