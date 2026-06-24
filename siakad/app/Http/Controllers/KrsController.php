<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Semester;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * LIST MATA KULIAH
     */
    public function list_matkul()
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            abort(403, 'Akun tidak memiliki data dosen.');
        }

        $nimDosen = $user->dosen->nim_dosen;

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
        $mahasiswas = Registrasi::with([
            'mahasiswa',
            'penawaran.semester.periode',
            'krs' // penting untuk cek nilai
        ])
        ->whereHas('penawaran', function ($q) use ($mk) {
            $q->where('kodemk', $mk->kodemk);
        })
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
        $registrasi = Registrasi::with('penawaran.semester.periode')
            ->where('nrp', $mahasiswa->nrp)
            ->whereHas('penawaran', function ($q) use ($mk) {
                $q->where('kodemk', $mk->kodemk);
            })
            ->firstOrFail();

        $semester = $registrasi->penawaran->semester;

        return view('dosen.input_nilai.create', [
            'mahasiswa' => $mahasiswa,
            'mk' => $mk,
            'semester' => $semester,
        ]);
    }

    public function show(Mahasiswa $mahasiswa, Mk $mk)
    {
        $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
            ->whereHas('penawaran', function ($q) use ($mk) {
                $q->where('kodemk', $mk->kodemk);
            })
            ->firstOrFail();

    $krs = Krs::with([
        'registrasi.mahasiswa',
        'registrasi.penawaran.semester.periode'
    ])
    ->where('registrasi_id', $registrasi->regkrs)
    ->where('kode', $mk->kodemk)
    ->first();

        return view('dosen.input_nilai.show', [
            'krs' => $krs,
            'mahasiswa' => $mahasiswa,
            'mk' => $mk,
            'registrasi' => $registrasi,
        ]);
    }
    /**
     * SIMPAN NILAI KRS
     */
   
public function store(Request $request, Mahasiswa $mahasiswa, Mk $mk)
{
    $validated = $request->validate([
        // Kelas
        'kelas' => [
            'required',
            'string',
            'size:1',
            'in:A,B,C',
        ],

        // BU
        'bu' => [
            'nullable',
            'string',
            'size:1',
            'in:Y,N',
        ],

        // Nilai Tugas
        'ttt1' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'ttt2' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'ttt3' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        // Nilai Lain
        'lain' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        // UTS
        'uts' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        // UAS
        'uas' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        // Nilai Huruf
        'na' => [
            'nullable',
            'string',
            'max:2',
            'in:A,A-,B+,B,B-,C+,C,C-,D,E',
        ],

        // Survey
        'survey' => [
            'required',
            'boolean',
        ],
    ]);

    $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
        ->whereHas('penawaran', function ($q) use ($mk) {
            $q->where('kodemk', $mk->kodemk);
        })
        ->firstOrFail();

    Krs::updateOrCreate(
    [
        'registrasi_id' => $registrasi->regkrs,
        'kode' => $mk->kodemk,
    ],
    [        'kelas' => $validated['kelas'],
        'bu' => $validated['bu'],
        'ttt1' => $validated['ttt1'],
        'ttt2' => $validated['ttt2'],
        'ttt3' => $validated['ttt3'],
        'lain' => $validated['lain'],
        'uts' => $validated['uts'],
        'uas' => $validated['uas'],
        'na' => $validated['na'],
        'sks' => $mk->sks,
        'survey' => $validated['survey'],
    ]
    );

    return redirect()
        ->route('nilai.index')
        ->with('success', 'Nilai berhasil disimpan.');

    }

    public function edit(Mahasiswa $mahasiswa, Mk $mk)
    {
        $registrasi = Registrasi::with('penawaran.semester.periode')
            ->where('nrp', $mahasiswa->nrp)
            ->whereHas('penawaran', function ($q) use ($mk) {
                $q->where('kodemk', $mk->kodemk);
            })
            ->firstOrFail();

        $krs = Krs::where('registrasi_id', $registrasi->regkrs)
            ->where('kode', $mk->kodemk)
            ->firstOrFail();

        $semester = $registrasi->penawaran->semester;

        return view('dosen.input_nilai.edit', [
            'krs' => $krs,
            'mahasiswa' => $mahasiswa,
            'mk' => $mk,
            'semester' => $semester,
        ]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa, Mk $mk)
{
    $validated = $request->validate([
        'kelas' => [
            'required',
            'string',
            'size:1',
            'in:A,B,C',
        ],

        'bu' => [
            'nullable',
            'string',
            'size:1',
            'in:Y,N',
        ],

        'ttt1' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'ttt2' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'ttt3' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'lain' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'uts' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'uas' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'na' => [
            'nullable',
            'string',
            'max:2',
            'in:A,A-,B+,B,B-,C+,C,C-,D,E',
        ],

        'survey' => [
            'required',
            'boolean',
        ],
    ]);

    $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
        ->whereHas('penawaran', function ($q) use ($mk) {
            $q->where('kodemk', $mk->kodemk);
        })
        ->firstOrFail();

    $krs = Krs::where('registrasi_id', $registrasi->regkrs)
        ->where('kode', $mk->kodemk)
        ->firstOrFail();

    $krs->update([
        'kelas' => $validated['kelas'],
        'bu' => $validated['bu'],

        'ttt1' => $validated['ttt1'],
        'ttt2' => $validated['ttt2'],
        'ttt3' => $validated['ttt3'],

        'lain' => $validated['lain'],

        'uts' => $validated['uts'],
        'uas' => $validated['uas'],

        'na' => $validated['na'],

        'sks' => $mk->sks,

        'survey' => $validated['survey'],
    ]);

    return redirect()
        ->route('nilai.show', [
            'mahasiswa' => $mahasiswa->nrp,
            'mk' => $mk->kodemk,
        ])
        ->with('success', 'Nilai berhasil diperbarui.');
}
    public function destroy(Krs $krs) {}
}