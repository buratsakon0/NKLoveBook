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

public function register(Request $request)
{
    $validated = $request->validate([
        'Username' => 'required|string|max:255|unique:users,Username',
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'Email' => 'required|email|unique:users,Email',
        'Password' => 'required|min:6|confirmed',
    ]);

    $user = new \App\Models\User();
    $user->Username = $validated['Username'];
    $user->Fname = $validated['Fname'];
    $user->Lname = $validated['Lname'];
    $user->Email = $validated['Email'];
    $user->Password = bcrypt($validated['Password']);
    $user->save();

    Auth::login($user);

    return redirect()->route('home')->with('success', 'สมัครสมาชิกสำเร็จ!');
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
