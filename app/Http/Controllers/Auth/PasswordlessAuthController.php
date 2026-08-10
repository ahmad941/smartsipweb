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
     * Proses autentikasi email tanpa password.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = $request->input('email');

        // Cari atau buat User siswa baru secara otomatis
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => explode('@', $email)[0],
                'email' => $email,
                'role' => 'siswa',
                'password' => Hash::make(Str::random(32)), // Random hash password untuk keamanan DB
            ]);
        }

        // Login dengan remember = true (menyimpan token di Cookie browser secara permanen)
        Auth::login($user, true);

        // Jika profil siswa belum diisi, arahkan ke setup profil riset
        if ($user->role === 'siswa' && !$user->student) {
            return redirect()->route('student.profile.setup');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
