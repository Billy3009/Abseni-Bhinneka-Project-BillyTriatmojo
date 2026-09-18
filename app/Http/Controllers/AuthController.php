<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {

            return back()->with(
                'error',
                'Username atau Password salah.'
            );
        }

        $user = Auth::user();

        // Cek status akun
        if ($user->status == 'pending') {

            Auth::logout();

            return back()->with(
                'error',
                '⏳ Akun Anda masih menunggu persetujuan Admin.'
            );
        }

        if ($user->status == 'ditolak') {

            Auth::logout();

            return back()->with(
                'error',
                '❌ Akun Anda ditolak oleh Admin.'
            );
        }

        return redirect()->route('dashboard');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'nik_nip_nis' => 'required|max:30',
            'name' => 'required|max:255',
            'username' => 'required|max:50|unique:users,username',
            'password' => 'required|confirmed|min:6',
            'jenjang' => 'nullable',
            'kelas' => 'nullable',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'nik_nip_nis' => $request->nik_nip_nis,
            'jenjang' => $request->jenjang,
            'kelas' => $request->kelas,
            'status' => 'pending',

            // Email sementara
            'email' => $request->username . '@absensi.com',

            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with(
            'success',
            'Registrasi berhasil! Silakan tunggu persetujuan Admin.'
        );
    }
}