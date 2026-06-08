<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;

class PenawaranMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil data dari database, misal semua jadwal yang tersedia
        $penawaran = Penawaran::with('mk')->get(); // atau dengan kondisi tertentu

        return view('mahasiswa.penawaran.index', compact('penawaran'));
    }
}