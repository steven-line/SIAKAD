<?php

namespace App\Http\Controllers;

use App\Models\BobotNilai;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Periode;
use App\Models\Pjmk;
use App\Models\Registrasi;
use App\Models\Semester;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * LIST MATA KULIAH YANG DIAJAR DOSEN
     */
    public function list_matkul()
{
    $user = auth()->user();

    if (!$user || !$user->dosen) {
        abort(403, 'Akun tidak memiliki data dosen.');
    }

    $nimDosen = $user->dosen->nim_dosen;

    $mks = Penawaran::with([
        'mk',
        'semester.periode'
    ])
        ->where('dosen', $nimDosen)
        ->whereIn('recno', function ($query) use ($nimDosen) {
            $query->selectRaw('MIN(recno)')
                ->from('penawaran')
                ->where('dosen', $nimDosen)
                ->groupBy('kodemk', 'semester_id');
        })
        ->orderBy('semester_id')
        ->paginate(15);

    foreach ($mks as $mk) {

        $semester = $mk->semester;

        if (!$semester) {
            $mk->bisaEditBobot = false;
            continue;
        }

        $mk->bisaEditBobot = Pjmk::where('nim_dosen', $nimDosen)
            ->where('kodemk', $mk->kodemk)
            ->where('periode_id', $semester->periode_id)
            ->where('jenis', $semester->jenis)
            ->exists();
    }

    return view('dosen.input_nilai.list_matkul', [
        'mks' => $mks,
        'nimDosen' => $nimDosen,
    ]);
}


    /**
     * LIST MAHASISWA PER MK
     *
     * Identitas:
     * MK + PERIODE + SEMESTER
     *
     * Jenis diambil dari semester.
     */
    public function list_mahasiswa(
        Mk $mk,
        Periode $periode,
        Semester $semester
    ) {
        // Pastikan semester memang milik periode yang dikirim
        if ($semester->periode_id != $periode->id) {
            abort(404);
        }

        $jenis = $semester->jenis;

        // Ambil bobot sesuai MK + periode + jenis
        $bobotnilai = BobotNilai::where('kodemk', $mk->kodemk)
            ->where('periode_id', $periode->id)
            ->where('jenis', $jenis)
            ->first();

        $nimDosen = auth()->user()->dosen->nim_dosen;

        $mahasiswas = Registrasi::with([
            'mahasiswa',
            'penawaran.mk',
            'penawaran.semester.periode',
            'krs'
        ])
            ->whereHas('penawaran', function ($q) use (
                $mk,
                $periode,
                $semester,
                $nimDosen
            ) {
                $q->where('kodemk', $mk->kodemk)
                    ->where('dosen', $nimDosen)
                    ->where('semester_id', $semester->id);
            })
            ->whereHas('mahasiswa', function ($q) {
                $q->where('status_blokir', 'DISETUJUI');
            })
            ->get();

        return view('dosen.input_nilai.list_mahasiswa', [
            'mahasiswas' => $mahasiswas,
            'mk' => $mk,
            'periode' => $periode,
            'semester' => $semester,
            'bobotnilai' => $bobotnilai,
        ]);
    }


    /**
     * FORM INPUT NILAI
     */
   public function show(
    Mahasiswa $mahasiswa,
    Penawaran $penawaran
) {
    $registrasi = Registrasi::with([
        'mahasiswa',
        'penawaran.mk',
        'penawaran.semester.periode',
        'krs'
    ])
        ->where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->firstOrFail();

    $krs = $registrasi->krs;

    return view('dosen.input_nilai.show', [
        'krs' => $krs,
        'mahasiswa' => $mahasiswa,
        'mk' => $penawaran->mk,
        'penawaran' => $penawaran,
        'registrasi' => $registrasi,
    ]);
}

    /**
     * FORM EDIT BOBOT
     */
    public function edit_bobot(
        Mk $mk,
        Periode $periode,
        Semester $semester
    ) {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            abort(403, 'Akun Anda tidak memiliki data dosen.');
        }

        // Semester harus milik periode
        if ($semester->periode_id != $periode->id) {
            abort(404);
        }

        $nimDosen = $user->dosen->nim_dosen;

        // Jenis berasal dari semester
        $jenis = $semester->jenis;

        // Cek PJMK
        $isPjmk = Pjmk::where('nim_dosen', $nimDosen)
            ->where('kodemk', $mk->kodemk)
            ->where('periode_id', $periode->id)
            ->where('jenis', $jenis)
            ->exists();

        if (!$isPjmk) {
            abort(403, 'Anda bukan PJMK untuk mata kuliah ini.');
        }

        // Bobot harus spesifik MK + periode + jenis
        $bobotnilai = BobotNilai::where('kodemk', $mk->kodemk)
            ->where('periode_id', $periode->id)
            ->where('jenis', $jenis)
            ->first();

        return view('dosen.input_nilai.edit_bobot_matkul', [
            'mk' => $mk,
            'bobotnilai' => $bobotnilai,
            'periode' => $periode,
            'semester' => $semester,
        ]);
    }


    /**
     * UPDATE BOBOT
     */
    public function update_bobot(
        Request $request,
        Mk $mk,
        Periode $periode,
        Semester $semester
    ) {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            abort(403, 'Akun Anda tidak memiliki data dosen.');
        }

        // Semester harus milik periode
        if ($semester->periode_id != $periode->id) {
            abort(404);
        }

        $nimDosen = $user->dosen->nim_dosen;

        // Jenis berasal dari semester
        $jenis = $semester->jenis;

        // Cek PJMK
        $isPjmk = Pjmk::where('nim_dosen', $nimDosen)
            ->where('kodemk', $mk->kodemk)
            ->where('periode_id', $periode->id)
            ->where('jenis', $jenis)
            ->exists();

        if (!$isPjmk) {
            abort(403, 'Anda tidak memiliki hak untuk mengubah bobot mata kuliah ini.');
        }

        $validated = $request->validate([
            'ttt1' => ['required', 'numeric', 'between:0,100'],
            'ttt2' => ['required', 'numeric', 'between:0,100'],
            'lain' => ['required', 'numeric', 'between:0,100'],
            'uts'  => ['required', 'numeric', 'between:0,100'],
            'uas'  => ['required', 'numeric', 'between:0,100'],
        ]);

        $total =
            $validated['ttt1'] +
            $validated['ttt2'] +
            $validated['lain'] +
            $validated['uts'] +
            $validated['uas'];

        if ($total != 100) {
            return back()
                ->withErrors([
                    'bobot' => "Total bobot harus 100%. Saat ini: {$total}%"
                ])
                ->withInput();
        }

        BobotNilai::updateOrCreate(
            [
                'kodemk' => $mk->kodemk,
                'periode_id' => $periode->id,
                'jenis' => $jenis,
            ],
            [
                'ttt1' => $validated['ttt1'],
                'ttt2' => $validated['ttt2'],
                'lain' => $validated['lain'],
                'uts' => $validated['uts'],
                'uas' => $validated['uas'],
            ]
        );

       return redirect()
    ->route('nilai.edit_bobot', [
        'mk' => $mk->kodemk,
        'periode' => $periode->id,
        'semester' => $semester->id,
    ])
    ->with('success', 'Bobot nilai berhasil diperbarui.');    }


    /**
     * FORM EDIT NILAI MAHASISWA
     */public function edit(
    Mahasiswa $mahasiswa,
    Penawaran $penawaran
) {
    $registrasi = Registrasi::with([
        'penawaran.semester.periode'
    ])
        ->where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->firstOrFail();

    $semester = $penawaran->semester;
    $periode = $semester->periode;
    $jenis = $semester->jenis;

    $bobotnilai = BobotNilai::where('kodemk', $penawaran->kodemk)
        ->where('periode_id', $periode->id)
        ->where('jenis', $jenis)
        ->first();

    if (!$bobotnilai) {
        return back()->with(
            'error',
            'Bobot nilai untuk mata kuliah ini belum diatur.'
        );
    }

    $periodeInputNilai = Metaperiode::first();

    $krs = Krs::firstOrCreate(
        [
            'registrasi_id' => $registrasi->regkrs
        ],
        [
            'kelas' => 'A',
            'survey' => false
        ]
    );

    return view('dosen.input_nilai.edit', [
        'krs' => $krs,
        'mahasiswa' => $mahasiswa,
        'mk' => $penawaran->mk,
        'penawaran' => $penawaran,
        'periode' => $periode,
        'semester' => $semester,
        'periodeInputNilai' => $periodeInputNilai,
    ]);
}

    /**
 * UPDATE NILAI MAHASISWA
 */
public function update(
    Request $request,
    Mahasiswa $mahasiswa,
    Penawaran $penawaran
) {
    $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->firstOrFail();

    $semester = $penawaran->semester;
    $periode = $semester->periode;
    $jenis = $semester->jenis;

    $bobotnilai = BobotNilai::where('kodemk', $penawaran->kodemk)
        ->where('periode_id', $periode->id)
        ->where('jenis', $jenis)
        ->firstOrFail();

    $validated = $request->validate([
        'kelas' => 'required|string|size:1|in:A,B,C',
        'bu' => 'nullable|string|size:1|in:Y,N',
        'ttt1' => 'nullable|numeric|between:0,100',
        'ttt2' => 'nullable|numeric|between:0,100',
        'lain' => 'nullable|numeric|between:0,100',
        'uts' => 'nullable|numeric|between:0,100',
        'uas' => 'nullable|numeric|between:0,100',
        'survey' => 'required|boolean',
    ]);

    $periodeInputNilai = Metaperiode::firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | Ambil KRS lama jika ada
    |--------------------------------------------------------------------------
    */
    $krsLama = Krs::where('registrasi_id', $registrasi->regkrs)
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Nilai lama
    |--------------------------------------------------------------------------
    */
    $utsLama = $krsLama?->uts;
    $uasLama = $krsLama?->uas;

    /*
    |--------------------------------------------------------------------------
    | Cek UTS
    |--------------------------------------------------------------------------
    | Kalau nilai UTS berubah, harus berada di periode input UTS.
    |--------------------------------------------------------------------------
    */
    if (
        ($validated['uts'] ?? null) != $utsLama &&
        !now()->between(
            $periodeInputNilai->input_nilai_uts_mulai,
            $periodeInputNilai->input_nilai_uts_selesai
        )
    ) {
        return back()
            ->with('error', 'Nilai UTS hanya dapat diubah pada periode input UTS.')
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | Cek UAS
    |--------------------------------------------------------------------------
    | Kalau nilai UAS berubah, harus berada di periode input UAS.
    |--------------------------------------------------------------------------
    */
    if (
        ($validated['uas'] ?? null) != $uasLama &&
        !now()->between(
            $periodeInputNilai->input_nilai_uas_mulai,
            $periodeInputNilai->input_nilai_uas_selesai
        )
    ) {
        return back()
            ->with('error', 'Nilai UAS hanya dapat diubah pada periode input UAS.')
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | Tentukan nilai yang digunakan
    |--------------------------------------------------------------------------
    | Kalau sedang di luar periode UTS/UAS dan nilainya tidak berubah,
    | gunakan nilai lama.
    |--------------------------------------------------------------------------
    */
    $uts = $validated['uts'] ?? null;
    $uas = $validated['uas'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | Hitung nilai akhir
    |--------------------------------------------------------------------------
    */
    $nilaiAkhir =
        (($validated['ttt1'] ?? 0) * $bobotnilai->ttt1 / 100) +
        (($validated['ttt2'] ?? 0) * $bobotnilai->ttt2 / 100) +
        (($validated['lain'] ?? 0) * $bobotnilai->lain / 100) +
        (($uts ?? 0) * $bobotnilai->uts / 100) +
        (($uas ?? 0) * $bobotnilai->uas / 100);

    $na = match (true) {
        $nilaiAkhir >= 80 => 'A',
        $nilaiAkhir >= 74 => 'AB',
        $nilaiAkhir >= 68 => 'B',
        $nilaiAkhir >= 62 => 'BC',
        $nilaiAkhir >= 56 => 'C',
        $nilaiAkhir >= 41 => 'D',
        default => 'E',
    };

    /*
    |--------------------------------------------------------------------------
    | CREATE atau UPDATE KRS
    |--------------------------------------------------------------------------
    */
    Krs::updateOrCreate(
        [
            'registrasi_id' => $registrasi->regkrs,
        ],
        [
            'kelas' => $validated['kelas'],
            'bu' => $validated['bu'] ?? null,
            'ttt1' => $validated['ttt1'] ?? null,
            'ttt2' => $validated['ttt2'] ?? null,
            'lain' => $validated['lain'] ?? null,
            'uts' => $uts,
            'uas' => $uas,
            'na' => $na,
            'sks' => $penawaran->mk->sks,
            'survey' => $validated['survey'],
        ]
    );

    return redirect()
        ->route('nilai.show', [
            'mahasiswa' => $mahasiswa->nrp,
            'penawaran' => $penawaran->recno,
        ])
        ->with(
            'success',
            'Nilai berhasil disimpan. Nilai akhir: ' . $na
        );
}
    public function destroy(Krs $krs)
    {
    }
}