<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UbahPasswordKaprodiController extends Controller
{

    public function create()
    {
        return view('kaprodi.ubah_password_kaprodi.create');
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
            ->route('kaprodi.password.create')
            ->with('success', 'Password berhasil diubah.');
    }
}