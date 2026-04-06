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
            'password' => ['required', 'string', Password::default()]
        ]);       
        
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->withErrors([
            'username' => 'The Provided Credentials do not match our records'
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
