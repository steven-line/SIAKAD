<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UbahPasswordKeuanganController extends Controller
{

    public function create()
    {
        return view('keuangan.ubah_password_keuangan.create');
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
            ->route('keuangan.password.create')
            ->with('success', 'Password berhasil diubah.');
    }
}