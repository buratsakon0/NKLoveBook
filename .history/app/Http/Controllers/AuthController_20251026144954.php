<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'Username' => 'required|string|max:255|unique:users',
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'Email' => 'required|email|unique:users',
            'Password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'Username' => $request->Username,
            'Fname' => $request->Fname,
            'Lname' => $request->Lname,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function login(Request $request) {
    $credentials = $request->validate([
        'Username' => 'required|string',
        'Password' => 'required|string',
    ]);

    if (Auth::attempt(['Username' => $credentials['Username'], 'password' => $credentials['Password']])) {
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }

    
    return back()->withErrors([
        'login_error' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
    ])->onlyInput('Username');
}


    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
