<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiKrsAnakWaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $nimDosen = auth()->user()->dosen->nim_dosen;

        $mahasiswas = Mahasiswa::where('dosen_wali', $nimDosen)
            ->orderBy('nrp')
            ->paginate(15);

        return view('dosen_wali.nilai_krs_anak_wali.index', [
            'mahasiswas' => $mahasiswas,
        ]);
    }

   public function show(Mahasiswa $mahasiswa)
{
    $nimDosen = auth()->user()->dosen->nim_dosen;

    // Pastikan mahasiswa adalah anak wali dosen yang login
    if ($mahasiswa->dosen_wali !== $nimDosen) {
        abort(403);
    }

    $nilaiKrs = DB::table('registrasi')
        ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
        ->join('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
        ->leftJoin('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
        ->where('registrasi.nrp', $mahasiswa->nrp)
        ->select(
            'registrasi.regkrs',
            'penawaran.kodemk as kode',
            'mk.nama as nama_mk',
            'mk.sks as sks',
            'registrasi.status',
            'krs.ttt1',
            'krs.ttt2',
            'krs.ttt3',
            'krs.uts',
            'krs.uas',
            'krs.lain',
            'krs.na'
        )
        ->orderBy('penawaran.kodemk')
        ->get();

    return view('dosen_wali.nilai_krs_anak_wali.show', [
        'mahasiswa' => $mahasiswa,
        'nilaiKrs' => $nilaiKrs,
    ]);
}}

