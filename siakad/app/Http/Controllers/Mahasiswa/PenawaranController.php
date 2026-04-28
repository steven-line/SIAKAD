<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal; // sesuaikan dengan model Anda

class PenawaranController extends Controller
{
    public function index()
    {
        // Ambil data dari database, misal semua jadwal yang tersedia
        $jadwals = Jadwal::all(); // atau dengan kondisi tertentu

        return view('mahasiswa.penawaran.index', compact('jadwals'));
    }
}