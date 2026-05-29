<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    /* FORM EMAIL */
    public function request()
    {
        return view('auth.forgot-password');
    }

    /* KIRIM EMAIL RESET */
    public function email(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __($status));
    }

    /* FORM RESET PASSWORD */
    public function reset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /* SIMPAN PASSWORD BARU */
    public function update(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diubah')
            : back()->withErrors(['email' => __($status)]);
    }
}
