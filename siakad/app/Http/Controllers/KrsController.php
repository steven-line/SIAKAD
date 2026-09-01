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
 */
public function edit(
    Mahasiswa $mahasiswa,
    Penawaran $penawaran
) {
    $registrasi = Registrasi::with([
        'penawaran.mk',
        'penawaran.semester.periode'
    ])
        ->where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->firstOrFail();

    $semester = $penawaran->semester;
    $periode = $semester->periode;

    /*
     * ==========================================================
     * BOBOT NILAI
     * ==========================================================
     */
    $bobotnilai = BobotNilai::where('kodemk', $penawaran->kodemk)
        ->where('periode_id', $periode->id)
        ->where('jenis', $semester->jenis)
        ->first();

    if (!$bobotnilai) {
        return back()->with(
            'error',
            'Bobot nilai untuk mata kuliah ini belum diatur.'
        );
    }

    /*
     * ==========================================================
     * META PERIODE
     * ==========================================================
     */
    $periodeInputNilai = Metaperiode::where(
        'periode_id',
        $periode->id
    )->first();

    /*
     * ==========================================================
     * KRS
     * ==========================================================
     */
    $krs = Krs::firstOrCreate(
        [
            'registrasi_id' => $registrasi->regkrs
        ],
        [
            'kelas' => 'A',
            'survey' => false
        ]
    );

    /*
     * ==========================================================
     * CEK MK KHUSUS
     * ==========================================================
     */
    $isKhusus = strtolower(
        trim((string) $penawaran->mk->jenis)
    ) === 'khusus';

    /*
     * ==========================================================
     * CEK TOGGLE MK KHUSUS
     * ==========================================================
     *
     * Toggle hanya berlaku untuk MK khusus.
     *
     * MK normal:
     * tidak menggunakan toggle ini.
     */
    $mkKhususAktif = [];

    if ($periodeInputNilai) {
        $mkKhususAktif = $periodeInputNilai->mk_khusus ?? [];

        if (!is_array($mkKhususAktif)) {
            $mkKhususAktif = [];
        }
    }

    $kodeMk = trim((string) $penawaran->kodemk);

    $mkKhususDiizinkan = $isKhusus
        && in_array(
            $kodeMk,
            $mkKhususAktif,
            true
        );

    /*
     * ==========================================================
     * IZIN INPUT UTS
     * ==========================================================
     *
     * MK KHUSUS:
     *   mengikuti toggle.
     *
     * MK NORMAL:
     *   mengikuti periode UTS.
     */
    if ($isKhusus) {

        $bolehInputUts = $mkKhususDiizinkan;

    } else {

        $bolehInputUts =
            $periodeInputNilai &&
            $periodeInputNilai->input_nilai_uts_mulai &&
            $periodeInputNilai->input_nilai_uts_selesai &&
            now()->between(
                $periodeInputNilai->input_nilai_uts_mulai,
                $periodeInputNilai->input_nilai_uts_selesai
            );
    }

    /*
     * ==========================================================
     * IZIN INPUT UAS
     * ==========================================================
     *
     * MK KHUSUS:
     *   mengikuti toggle.
     *
     * MK NORMAL:
     *   mengikuti periode UAS.
     */
    if ($isKhusus) {

        $bolehInputUas = $mkKhususDiizinkan;

    } else {

        $bolehInputUas =
            $periodeInputNilai &&
            $periodeInputNilai->input_nilai_uas_mulai &&
            $periodeInputNilai->input_nilai_uas_selesai &&
            now()->between(
                $periodeInputNilai->input_nilai_uas_mulai,
                $periodeInputNilai->input_nilai_uas_selesai
            );
    }

    return view('dosen.input_nilai.edit', [
        'krs' => $krs,
        'mahasiswa' => $mahasiswa,
        'mk' => $penawaran->mk,
        'penawaran' => $penawaran,
        'periode' => $periode,
        'semester' => $semester,
        'periodeInputNilai' => $periodeInputNilai,

        /*
         * Variabel baru untuk Blade.
         */
        'isKhusus' => $isKhusus,
        'mkKhususDiizinkan' => $mkKhususDiizinkan,
        'bolehInputUts' => $bolehInputUts,
        'bolehInputUas' => $bolehInputUas,
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
    /*
     * ==========================================================
     * REGISTRASI
     * ==========================================================
     */
    $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->firstOrFail();

    /*
     * ==========================================================
     * PERIODE / SEMESTER / MK
     * ==========================================================
     */
    $semester = $penawaran->semester;
    $periode = $semester->periode;
    $jenisSemester = $semester->jenis;
    $mk = $penawaran->mk;

    /*
     * ==========================================================
     * BOBOT NILAI
     * ==========================================================
     */
    $bobotnilai = BobotNilai::where('kodemk', $penawaran->kodemk)
        ->where('periode_id', $periode->id)
        ->where('jenis', $jenisSemester)
        ->firstOrFail();

    /*
     * ==========================================================
     * VALIDASI
     * ==========================================================
     */
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

    /*
     * ==========================================================
     * META PERIODE
     * ==========================================================
     */
    $periodeInputNilai = Metaperiode::where(
        'periode_id',
        $periode->id
    )->first();

    if (!$periodeInputNilai) {
        return back()
            ->with(
                'error',
                'Pengaturan periode input nilai belum tersedia.'
            )
            ->withInput();
    }

    /*
     * ==========================================================
     * KRS LAMA
     * ==========================================================
     */
    $krsLama = Krs::where(
        'registrasi_id',
        $registrasi->regkrs
    )->first();

    $utsLama = $krsLama?->uts;
    $uasLama = $krsLama?->uas;

    /*
     * ==========================================================
     * CEK MK KHUSUS
     * ==========================================================
     */
    $jenisMk = strtolower(
        trim((string) $mk->jenis)
    );

    $isKhusus = $jenisMk === 'khusus';

    /*
     * Ambil daftar MK khusus yang toggle-nya ON.
     */
    $mkKhususAktif = $periodeInputNilai->mk_khusus ?? [];

    if (!is_array($mkKhususAktif)) {
        $mkKhususAktif = [];
    }

    $kodeMk = trim((string) $mk->kodemk);

    $mkKhususDiizinkan = $isKhusus
        && in_array(
            $kodeMk,
            $mkKhususAktif,
            true
        );

    /*
     * ==========================================================
     * CEK UTS
     * ==========================================================
     *
     * MK KHUSUS:
     *   hanya boleh jika toggle ON.
     *
     * MK NORMAL:
     *   hanya boleh ketika periode UTS aktif.
     */
    $utsBerubah = ($validated['uts'] ?? null) != $utsLama;

    if ($utsBerubah) {

        if ($isKhusus) {

            /*
             * MK khusus tidak memakai periode UTS umum.
             */
            if (!$mkKhususDiizinkan) {
                return back()
                    ->with(
                        'error',
                        'Nilai UTS mata kuliah khusus belum diaktifkan oleh Admin.'
                    )
                    ->withInput();
            }

        } else {

            /*
             * MK normal menggunakan periode UTS.
             */
            $utsMulai = $periodeInputNilai->input_nilai_uts_mulai;
            $utsSelesai = $periodeInputNilai->input_nilai_uts_selesai;

            if (
                !$utsMulai ||
                !$utsSelesai ||
                !now()->between($utsMulai, $utsSelesai)
            ) {
                return back()
                    ->with(
                        'error',
                        'Nilai UTS mata kuliah normal hanya dapat diinput pada periode input UTS.'
                    )
                    ->withInput();
            }
        }
    }

    /*
     * ==========================================================
     * CEK UAS
     * ==========================================================
     *
     * MK KHUSUS:
     *   hanya boleh jika toggle ON.
     *
     * MK NORMAL:
     *   hanya boleh ketika periode UAS aktif.
     */
    $uasBerubah = ($validated['uas'] ?? null) != $uasLama;

    if ($uasBerubah) {

        if ($isKhusus) {

            /*
             * MK khusus tidak memakai periode UAS umum.
             */
            if (!$mkKhususDiizinkan) {
                return back()
                    ->with(
                        'error',
                        'Nilai UAS mata kuliah khusus belum diaktifkan oleh Admin.'
                    )
                    ->withInput();
            }

        } else {

            /*
             * MK normal menggunakan periode UAS.
             */
            $uasMulai = $periodeInputNilai->input_nilai_uas_mulai;
            $uasSelesai = $periodeInputNilai->input_nilai_uas_selesai;

            if (
                !$uasMulai ||
                !$uasSelesai ||
                !now()->between($uasMulai, $uasSelesai)
            ) {
                return back()
                    ->with(
                        'error',
                        'Nilai UAS mata kuliah normal hanya dapat diinput pada periode input UAS.'
                    )
                    ->withInput();
            }
        }
    }

    /*
     * ==========================================================
     * NILAI
     * ==========================================================
     */
    $uts = $validated['uts'] ?? null;
    $uas = $validated['uas'] ?? null;

    /*
     * ==========================================================
     * HITUNG NILAI AKHIR
     * ==========================================================
     */
    $nilaiAkhir =
        (($validated['ttt1'] ?? 0) * $bobotnilai->ttt1 / 100) +
        (($validated['ttt2'] ?? 0) * $bobotnilai->ttt2 / 100) +
        (($validated['lain'] ?? 0) * $bobotnilai->lain / 100) +
        (($uts ?? 0) * $bobotnilai->uts / 100) +
        (($uas ?? 0) * $bobotnilai->uas / 100);

    /*
     * ==========================================================
     * KONVERSI NILAI
     * ==========================================================
     */
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
     * ==========================================================
     * SIMPAN KRS
     * ==========================================================
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

            'sks' => $mk->sks,

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