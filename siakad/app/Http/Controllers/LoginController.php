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
        'password' => ['required', 'string'], // ✅ FIX DI SINI
    ]);

    if (Auth::attempt([
        'username' => $request->username,
        'password' => $request->password
    ])) {
        $request->session()->regenerate();

        if (Auth::user()->level === 1) {
            return redirect('/admin');
        }

        if (Auth::user()->level === 2) {
            return redirect('/kaprodi');
        }

        if (Auth::user()->level === 3) {
            return redirect('/mahasiswa');
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah'
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        
        return redirect('/login');
    }
}
