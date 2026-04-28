<?php

namespace App\Http\Controllers\Kaprodi;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PenawaranController extends Controller
{
    public function create()
    {
        return view('kaprodi.penawaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required',
            'nama_mk' => 'required',
            'sks' => 'required|integer',
            'hari' => 'required',
            'jam_mulai' => 'required',
        ]);

        // 🔥 HITUNG JAM SELESAI OTOMATIS (50 menit x SKS)
        $durasi = $request->sks * 50;

        $jam_mulai = \Carbon\Carbon::parse($request->jam_mulai);
        $jam_selesai = $jam_mulai->copy()->addMinutes($durasi);

        Penawaran::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'kelas' => $request->kelas,
            'dosen' => $request->dosen,
            'semester' => $request->semester,
            'hari' => $request->hari,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
        ]);

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Penawaran berhasil disimpan');
    }
}