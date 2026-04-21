<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        
    
         return view('mahasiswa.ubah_password.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = User::where('user', $user)->firstOrFail();

        $validated = $request->validate([
            'password_lama' => ['required', 'string', 'current_password'],
            'password_baru' => ['required', 'confirmed','different:old_password', Password::default()],


            ]);

        $user->update(['password' => $validated['[password_baru']]);
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
