<?php

namespace App\Http\Controllers;

use App\Models\Metaperiode;
use App\Models\Periode;
use Illuminate\Http\Request;

class MetaperiodeController extends Controller
{
    public function index()
    {
        $periode = Periode::with(['semesters' => function ($q) {
    $q->where('aktif', 1);
}])->where('aktif', 1)->first();
        $metaperiode = Metaperiode::first(); // ambil data kalau ada

        return view('admin.metaperiode.index', compact('metaperiode', 'periode'));
    }

    public function update(Request $request)
    {
        // ✅ VALIDASI
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode,id',

            'krs_mulai' => 'required|date',
            'krs_selesai' => 'required|date|after:krs_mulai',

            'batal_tambah_mulai' => 'date',
            'batal_tambah_selesai' => 'date|after:batal_tambah_mulai',

            'input_nilai_mulai' => 'date',
            'input_nilai_selesai' => 'date|after:input_nilai_mulai',

            'pengumuman_nilai_final_mulai' => 'date',
            'pengumuman_nilai_final_selesai' => 'date|after:khs_mulai',
        ]);

        // ✅ UPDATE ATAU CREATE
        Metaperiode::updateOrCreate(
            ['periode_id' => $validated['periode_id']], // kunci utama
            $validated
        );

        return back()->with('success', 'Data berhasil disimpan');
    }
}