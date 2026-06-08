<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MataKuliahController extends Controller
{
    /**
     * Menampilkan daftar mata kuliah (halaman penawaran) namun saya tidak memakai data dummy saya sudah ada data asli di tabel mk.
     */
    public function index()
    {        // Ambil data dari database, misal semua jadwal yang tersedia
        $mk = Mk::all(); // atau dengan kondisi tertentu
        return view('mahasiswa.penawaran.index', compact('mk'));
    }
}