<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
            'aktif' => '1'
        ])) {
            $request->session()->regenerate();

            // Simpan pataum user ke session
            $user = Auth::user();
            if ($user && isset($user->pataum)) {
                // Ambil karakter pertama dari pataum (misal 'P (Pagi)' -> 'P')
                $pataum = substr($user->pataum, 0, 1);
                session(['pataum' => $pataum]);
            }

        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
            'aktif' => 'Akun tidak aktif',
        ])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        session()->forget('pataum'); // hapus session pataum
        return redirect('/login');
    }
}