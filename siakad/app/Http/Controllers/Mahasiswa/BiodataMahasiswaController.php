<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use Illuminate\Support\Facades\Auth;

class BiodataMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('mahasiswa')) {
            $nrp = $user->mahasiswa->nrp;
            $biodata = Biodata::where('nrp', $nrp)->first();

        }

        // Hapus with('dosenwali') karena relasi tidak ada, gunakan find biasa
<<<<<<< HEAD
    
=======
        $biodata = Biodata::where('nrp', $nrp)->first();

        if (!$biodata) {
            return back()->with('error', 'Biodata dengan NRP ' . $nrp . ' tidak ditemukan.');
        }

>>>>>>> fc1dc18f02a2c30917d177523d51d0d52d0293f7
        return view('mahasiswa.biodata.index', compact('biodata'));
    }
}