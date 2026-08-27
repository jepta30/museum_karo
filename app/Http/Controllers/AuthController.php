<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $user->last_login_at = now();
            $user->save();
            
            \App\Models\LogAktivitas::create([
                'user_id' => $user->id,
                'nama_pengguna' => $user->name,
                'aksi' => 'Login ke dalam sistem',
                'status' => 'Berhasil'
            ]);

            return redirect()->intended('/dashboard');
        }

        \App\Models\LogAktivitas::create([
            'nama_pengguna' => $request->email,
            'aksi' => 'Percobaan login gagal',
            'status' => 'Gagal'
        ]);

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
