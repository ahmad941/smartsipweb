<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordlessAuthController extends Controller
{
    /**
     * Tampilkan form login/daftar khusus siswa (hanya butuh email).
     */
    public function create(): View
    {
        return view('auth.passwordless-login');
    }

    /**
     * Proses autentikasi email tanpa password (KHUSUS SISWA).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = strtolower(trim($request->input('email')));

        // Cari User berdasarkan email
        $user = User::where('email', $email)->first();

        // 🛡️ KEAMANAN TINGKAT TINGGI:
        // Jika email terdaftar sebagai Admin atau Guru, BLOKIR LOGIN TANPA PASSWORD!
        if ($user && $user->role !== 'siswa') {
            return back()->withErrors([
                'email' => 'Email ini terdaftar sebagai akun ' . ucfirst($user->role) . '. Silakan login melalui tombol "Login Guru/Admin" menggunakan password.',
            ])->onlyInput('email');
        }

        // Jika user belum ada, buat akun baru sebagai Siswa
        if (!$user) {
            $user = User::create([
                'name' => explode('@', $email)[0],
                'email' => $email,
                'role' => 'siswa',
                'password' => Hash::make(Str::random(32)),
            ]);
        }

        // Login hanya untuk akun siswa
        Auth::login($user, true);

        // Jika profil siswa belum diisi, arahkan ke setup profil riset
        if (!$user->student) {
            return redirect()->route('student.profile.setup');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
