<?php

namespace App\Http\Controllers\Biodata;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Pastikan user memiliki properti 'nrp'
        if (!property_exists($user, 'nrp') || empty($user->nrp)) {
            return back()->with('error', 'User tidak memiliki NRP yang valid.');
        }

        $nrp = $user->nrp;

        // Cari biodata berdasarkan NRP
        $biodata = Biodata::find($nrp);

        if (!$biodata) {
            return back()->with('error', 'Biodata tidak ditemukan untuk user ini.');
        }

        return view('mahasiswa.biodata.index', compact('biodata'));
    }
}