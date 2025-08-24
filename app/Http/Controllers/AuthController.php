<?php

namespace App\Http\Controllers;

use App\Facades\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->role_id == 2) {
                return redirect('guru/dashboard');
            } elseif (Auth::user()->role_id == 3) {
                return redirect('siswa/dashboard');
            } elseif (Auth::user()->role_id == 4) {
                return redirect('kepsek/dashboard');
            }
        }
        return view('pages.auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id == 1) {
                return redirect()->intended('admin/dashboard');
            } elseif (Auth::user()->role_id == 2) {
                return redirect()->intended('guru/dashboard');
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->intended('siswa/dashboard');
            }
        }

        return back()->with('swal', [
            'icon' => 'error',
            'title' => 'Gagal',
            'text' => 'Username tidak terdaftar atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => true]);
    }

    public function edit()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
