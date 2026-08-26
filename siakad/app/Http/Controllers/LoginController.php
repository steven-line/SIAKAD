<?php

namespace App\Http\Controllers;

use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        // 1. Cari username
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'username' => 'Username salah',
                ])
                ->withInput();
        }

        // 2. Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Password salah',
                ])
                ->withInput();
        }

        // 3. Cek status akun
        if ((int) $user->aktif !== 1) {
            return back()
                ->withErrors([
                    'aktif' => 'Akun tidak aktif',
                ])
                ->withInput();
        }

        // 4. Login berhasil
        Auth::login($user);

        $request->session()->regenerate();

        // Simpan pataum ke session
        if ($user->pataum) {
            $pataum = substr($user->pataum, 0, 1);
            session(['pataum' => $pataum]);
        }

        return redirect()->intended('/dashboard');
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where(
            'username',
            $validated['username']
        )->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'username' => 'Username tidak ditemukan.',
                ])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil direset. Silakan login kembali.');
    }

    public function destroy()
    {
        Auth::logout();
        session()->forget('pataum');

        return redirect('/login');
    }
}