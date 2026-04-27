<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UbahPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
    
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function create() {
        return view('mahasiswa.ubah_password.create');
    }
    public function store(Request $request) {
        $user = Auth::user()->username;
        $user = User::findOrFail($user);

        $validated = $request->validate([
            'password_lama' => ['required', 'string', 'current_password'],
            'password_baru' => ['required', 'confirmed','different:old_password', Password::default()],


            ]);

        $user->update(['password' => $validated['password_baru']]);

    }
    public function update(Request $request, User $user)
    {
  
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
