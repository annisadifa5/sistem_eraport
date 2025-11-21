<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)
                    ->where('status', 'aktif')
                    ->first();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan / tidak aktif');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        Auth::login($user);

        // === Redirect sesuai role ===
        if ($user->role == 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->role == 'guru') {
            if ($user->is_walikelas == 1) {
                return redirect()->route('dashboard.wali');
            } else {
                return redirect()->route('dashboard.guru');
            }
        }

        // Jangan pakai dd($user) lagi di sini!
        return redirect('/login')->with('error', 'Role tidak dikenali');
    }




    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
