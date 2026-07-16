<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\Penawaran;
use Illuminate\Support\Facades\Auth;

class PenawaranMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil pataum dari session
        $pataum = session('pataum');
        $statusBlokir = Auth::user()->mahasiswa->status_blokir;
        // Jika tidak ada di session, ambil dari user (fallback)
        if (!$pataum) {
            $user = Auth::user();
            if ($user && isset($user->pataum)) {
                $pataum = substr($user->pataum, 0, 1);
            }
        }

        // Query penawaran dengan filter pataum (jika ada)
         $prodi = Auth::user()?->mahasiswa?->prodi;

        $query = Penawaran::with(['mk.kurikulum'])
            ->whereHas('mk.kurikulum', function ($q) use ($prodi) {
                $q->where('kode_prodi', $prodi);
            });
            

        $penawaran = $query->get();

        return view('mahasiswa.penawaran.index', compact('penawaran', 'statusBlokir'));
    }
}