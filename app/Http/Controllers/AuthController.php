<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login sesuai role
    public function showLogin(string $role) {
        return view('auth.login_' . $role, compact('role'));
    }

    // Memproses data login
    public function login(Request $request, string $role) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tambahkan pengecekan role saat melakukan attempt login
        $credentials['role'] = $role;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect ke dashboard masing-masing jika sukses
            if ($role === 'admin') return redirect()->route('admin.index');
            if ($role === 'staff') return redirect()->route('staff.index');
            return redirect()->route('pasien.index');
        }

        return back()->withErrors(['email' => 'Email atau password salah untuk akun ' . $role]);
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Arahkan kembali ke halaman utama form pasien (pasien.index)
        return redirect()->route('pasien.index');
    }
}