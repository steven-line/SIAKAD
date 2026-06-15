<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Registrasi;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * LIST MATA KULIAH
     */
    public function list_matkul()
    {
        $nimDosen = auth()->user()->dosen->nim_dosen;

        $mks = Penawaran::with('mk')
            ->where('dosen', $nimDosen)
            ->paginate(15);

        return view('dosen.input_nilai.list_matkul', compact('mks'));
    }

    /**
     * LIST MAHASISWA PER MK
     */
    public function list_mahasiswa(Mk $mk)
    {
        $mahasiswas = Registrasi::with('mahasiswa')
            ->where('kodemk', $mk->kodemk)
            ->get();

        return view('dosen.input_nilai.list_mahasiswa', [
            'mahasiswas' => $mahasiswas,
            'mk' => $mk
        ]);
    }

    /**
     * FORM INPUT NILAI
     * ⚠️ URUTAN HARUS: Mahasiswa dulu, baru MK (sesuai URL)
     */
    public function create(Mahasiswa $mahasiswa, Mk $mk)
    {
        if (!$mahasiswa || !$mk) {
            abort(404, 'Data tidak ditemukan');
        }

        return view('dosen.input_nilai.create', [
            'mahasiswa' => $mahasiswa,
            'mk' => $mk
        ]);
    }

    public function show(Mahasiswa $mahasiswa, Mk $mk)
    {
        $krs = Krs::where('nrp', $mahasiswa->nrp)
            ->where('kode', $mk->kodemk)
            ->firstOrFail();

        return view('dosen.input_nilai.show', [
            'krs' => $krs,
            'mahasiswa' => $mahasiswa,
            'mk' => $mk
        ]);
    }

    /**
     * SIMPAN NILAI KRS
     */
    public function store(Request $request, Mahasiswa $mahasiswa, Mk $mk)
    {
        if (!$mahasiswa || !$mk) {
            abort(404, 'Data tidak valid');
        }

        $validated = $request->validate([
            'kelas' => ['required'],
            'periode' => ['nullable'],
            'bu' => ['nullable'],

            'ttt1' => ['nullable'],
            'ttt2' => ['nullable'],
            'ttt3' => ['nullable'],

            'lain' => ['nullable'],

            'uts' => ['nullable'],
            'uas' => ['nullable'],

            'na' => ['nullable'],
            'sks' => ['nullable'],

            'survey' => ['nullable'],
        ]);

        Krs::updateOrCreate(
            [
                'nrp' => $mahasiswa->nrp,
                'kode' => $mk->kodemk,
                'periode' => $validated['periode'] ?? null,
            ],
            [
                'kelas' => $validated['kelas'],

                'bu' => $validated['bu'] ?? null,

                'ttt1' => $validated['ttt1'] ?? null,
                'ttt2' => $validated['ttt2'] ?? null,
                'ttt3' => $validated['ttt3'] ?? null,

                'lain' => $validated['lain'] ?? null,

                'uts' => $validated['uts'] ?? null,
                'uas' => $validated['uas'] ?? null,

                'na' => $validated['na'] ?? null,

                'sks' => $validated['sks'] ?? null,

                'survey' => $validated['survey'] ?? false,
            ]
        );

        return redirect('/dosen/input_nilai/list_matkul')
            ->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit(Krs $krs) {}
    public function update(Request $request, Krs $krs) {}
    public function destroy(Krs $krs) {}
}