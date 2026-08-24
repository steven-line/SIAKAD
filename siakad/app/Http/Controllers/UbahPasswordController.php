<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UbahPasswordController extends Controller
{

    public function create()
    {
        return view('dosen.ubah_password_dosen.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password_lama' => [
                'required',
                'string',
            ],

            'password_baru' => [
                'required',
                'string',
                'confirmed',
                'different:password_lama',
                Password::default(),
            ],
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()
                ->withErrors([
                    'password_lama' => 'Password lama tidak sesuai.',
                ])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password_baru']),
        ]);

        return redirect()
            ->route('dosen.password.create')
            ->with('success', 'Password berhasil diubah.');
    }
}