<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;

        if (Auth::attempt([
            'email' => $login,
            'password' => $request->password,
        ])) {

            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard.admin')
                    ->with('success', 'Login admin berhasil');
            }

            return redirect()->route('dashboard.user')
                ->with('success', 'Login berhasil');
        }

        return back()->with('error', 'Username / Email atau password salah');
    }

    /* ===== LOGOUT ===== */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
