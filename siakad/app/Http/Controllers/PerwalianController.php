<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PerwalianController extends Controller
{
    public function index()
    {
        $user = auth()->user();

       

        $nimDosen = $user->dosen;

        $mahasiswas = Mahasiswa::with('dosenWali')
            ->where('dosen_wali', $nimDosen->nim_dosen)
            ->get();

        return view('dosen_wali.perwalian.index', ['mahasiswas' => $mahasiswas]);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        return view('dosen_wali.perwalian.show', ['mahasiswa' => $mahasiswa]);
    }

    public function validasi(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $mahasiswa->status_blokir = "DISETUJUI";
        $mahasiswa->save();

        return redirect()->route('perwalian.index')
            ->with('success', 'Mahasiswa berhasil divalidasi');
    }

    public function lock(Mahasiswa $mahasiswa)
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            return redirect()->route('perwalian.index')->with('error', 'Anda tidak terdaftar sebagai dosen.');
        }

        if ($mahasiswa->dosen_wali !== $user->dosen->nim_dosen) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $mahasiswa->status_blokir = "TERKUNCI";
        $mahasiswa->save();

        return redirect()->route('perwalian.index')
            ->with('success', 'KRS TERKUNCI');
    }

    // Method lain (create, store, edit, update, destroy) tetap seperti sebelumnya
}