<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('current_password') || $request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini wajib diisi untuk mengubah kata sandi.'])->withInput();
            }
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
            }
            if (!$request->filled('new_password')) {
                return back()->withErrors(['new_password' => 'Kata sandi baru wajib diisi.'])->withInput();
            }
            
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil dan pengaturan akun berhasil diperbarui.');
    }
}

