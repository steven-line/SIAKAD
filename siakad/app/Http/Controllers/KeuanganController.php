<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with('dosenwali')->paginate('10');

        return view('keuangan.mahasiswas.index', ['mahasiswas' => $mahasiswas]);
    }
    public function blokir(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update(['status_blokir' => 'BLOKIR']);

        return redirect()->route('keuangan.mahasiswa.index')->with('success', 'Mahasiswa berhasil diblokir.');
    }
    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Display the specified resource.
     */
    public function bukablokir(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update(['status_blokir' => 'BELUM_KRS']);

        return redirect()->route('keuangan.mahasiswa.index')->with('success', 'Mahasiswa berhasil dibuka blokir.');
    }
 

    /**
     * Show the form for editing the specified resource.
     */

}
