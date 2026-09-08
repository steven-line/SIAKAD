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
    /*
     * ==========================================================
     * REGISTRASI
     * ==========================================================
     */
    $registrasi = Registrasi::with([
        'penawaran.mk',
        'penawaran.semester.periode'
    ])
        ->where('nrp', $mahasiswa->nrp)
        ->where('penawaran_id', $penawaran->recno)
        ->firstOrFail();

    /*
     * ==========================================================
     * SEMESTER
     * ==========================================================
     */
    $semester = $penawaran->semester;

    if (!$semester) {
        return back()->with(
            'error',
            'Semester tidak ditemukan.'
        );
    }

    /*
     * ==========================================================
     * PERIODE
     * ==========================================================
     */
    $periode = $semester->periode;

    if (!$periode) {
        return back()->with(
            'error',
            'Periode tidak ditemukan.'
        );
    }

    /*
     * ==========================================================
     * MATA KULIAH
     * ==========================================================
     */
    $mk = $penawaran->mk;

    if (!$mk) {
        return back()->with(
            'error',
            'Mata kuliah tidak ditemukan.'
        );
    }

    /*
     * ==========================================================
     * BOBOT NILAI
     * ==========================================================
     */
    $bobotnilai = BobotNilai::where(
        'kodemk',
        $mk->kodemk
    )
        ->where(
            'periode_id',
            $periode->id
        )
        ->where(
            'jenis',
            $semester->jenis
        )
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
     * CEK PERIODE INPUT MK
     * ==========================================================
     *
     * PERHATIKAN:
     *
     * Yang digunakan adalah:
     *
     *     periode_input
     *
     * Nilainya hanya:
     *
     *     normal
     *     khusus
     *
     * BUKAN jenis_mk.
     */
    $periodeInput = strtolower(
        trim((string) $mk->periode_input)
    );

    $isKhusus = $periodeInput === 'khusus';
    $isNormal = $periodeInput === 'normal';

    /*
     * ==========================================================
     * VALIDASI PERIODE INPUT
     * ==========================================================
     */
    if (!$isKhusus && !$isNormal) {
        return back()->with(
            'error',
            'Periode input nilai mata kuliah tidak valid.'
        );
    }

    /*
     * ==========================================================
     * AMBIL MK KHUSUS YANG DIAKTIFKAN ADMIN
     * ==========================================================
     */
    $mkKhususAktif = [];

    if ($periodeInputNilai) {

        $mkKhususAktif =
            $periodeInputNilai->mk_khusus ?? [];

        /*
         * Jika mk_khusus disimpan sebagai JSON string,
         * ubah menjadi array.
         *
         * Contoh:
         *
         * ["AA26A703","AA26A704"]
         */
        if (is_string($mkKhususAktif)) {

            $decoded = json_decode(
                $mkKhususAktif,
                true
            );

            $mkKhususAktif = is_array($decoded)
                ? $decoded
                : [];
        }

        /*
         * Pastikan tetap array.
         */
        if (!is_array($mkKhususAktif)) {
            $mkKhususAktif = [];
        }
    }

    /*
     * ==========================================================
     * NORMALISASI MK KHUSUS
     * ==========================================================
     */
    $mkKhususAktif = collect($mkKhususAktif)
        ->map(function ($item) {

            /*
             * Format:
             *
             * "AA26A703"
             */
            if (is_scalar($item)) {
                return strtoupper(
                    trim((string) $item)
                );
            }

            /*
             * Format:
             *
             * [
             *     'kodemk' => 'AA26A703'
             * ]
             */
            if (is_array($item)) {

                return strtoupper(
                    trim((string) (
                        $item['kodemk']
                        ?? $item['kode']
                        ?? $item['id']
                        ?? ''
                    ))
                );
            }

            return null;
        })
        ->filter()
        ->values()
        ->toArray();

    /*
     * ==========================================================
     * KODE MK
     * ==========================================================
     */
    $kodeMk = strtoupper(
        trim((string) $mk->kodemk)
    );

    /*
     * ==========================================================
     * CEK TOGGLE MK KHUSUS
     * ==========================================================
     *
     * MK khusus:
     *     harus ada di daftar mk_khusus.
     *
     * MK normal:
     *     tidak menggunakan toggle ini.
     */
    $mkKhususDiizinkan =
        $isKhusus &&
        in_array(
            $kodeMk,
            $mkKhususAktif,
            true
        );

    /*
     * ==========================================================
     * IZIN INPUT UTS
     * ==========================================================
     */
    if ($isKhusus) {

        /*
         * MK khusus:
         * cukup diaktifkan Admin.
         *
         * Tidak peduli periode UTS umum.
         */
        $bolehInputUts = $mkKhususDiizinkan;

    } else {

        /*
         * MK normal:
         * mengikuti periode UTS.
         */
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
     */
    if ($isKhusus) {

        /*
         * MK khusus:
         * cukup diaktifkan Admin.
         */
        $bolehInputUas = $mkKhususDiizinkan;

    } else {

        /*
         * MK normal:
         * mengikuti periode UAS.
         */
        $bolehInputUas =
            $periodeInputNilai &&
            $periodeInputNilai->input_nilai_uas_mulai &&
            $periodeInputNilai->input_nilai_uas_selesai &&
            now()->between(
                $periodeInputNilai->input_nilai_uas_mulai,
                $periodeInputNilai->input_nilai_uas_selesai
            );
    }

    /*
     * ==========================================================
     * RETURN VIEW
     * ==========================================================
     */
    return view('dosen.input_nilai.edit', [
        'krs' => $krs,
        'mahasiswa' => $mahasiswa,
        'mk' => $mk,
        'penawaran' => $penawaran,
        'periode' => $periode,
        'semester' => $semester,
        'periodeInputNilai' => $periodeInputNilai,

        /*
         * Informasi MK khusus
         */
        'isKhusus' => $isKhusus,
        'mkKhususDiizinkan' => $mkKhususDiizinkan,

        /*
         * Hak input nilai
         */
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
     * SEMESTER
     * ==========================================================
     */
    $semester = $penawaran->semester;

    if (!$semester) {
        return back()
            ->with('error', 'Semester tidak ditemukan.')
            ->withInput();
    }

    /*
     * ==========================================================
     * PERIODE
     * ==========================================================
     */
    $periode = $semester->periode;

    if (!$periode) {
        return back()
            ->with('error', 'Periode tidak ditemukan.')
            ->withInput();
    }

    /*
     * ==========================================================
     * MATA KULIAH
     * ==========================================================
     */
    $mk = $penawaran->mk;

    if (!$mk) {
        return back()
            ->with('error', 'Mata kuliah tidak ditemukan.')
            ->withInput();
    }

    $jenisSemester = $semester->jenis;

    /*
     * ==========================================================
     * BOBOT NILAI
     * ==========================================================
     */
    $bobotnilai = BobotNilai::where('kodemk', $mk->kodemk)
        ->where('periode_id', $periode->id)
        ->where('jenis', $jenisSemester)
        ->first();

    if (!$bobotnilai) {
        return back()
            ->with(
                'error',
                'Bobot nilai untuk mata kuliah ini belum diatur.'
            )
            ->withInput();
    }

    /*
     * ==========================================================
     * VALIDASI
     * ==========================================================
     */
    $validated = $request->validate([
        'kelas' => [
            'required',
            'string',
            'size:1',
            'in:A,B,C'
        ],

        'bu' => [
            'nullable',
            'string',
            'size:1',
            'in:Y,N'
        ],

        'ttt1' => [
            'nullable',
            'numeric',
            'between:0,100'
        ],

        'ttt2' => [
            'nullable',
            'numeric',
            'between:0,100'
        ],

        'lain' => [
            'nullable',
            'numeric',
            'between:0,100'
        ],

        'uts' => [
            'nullable',
            'numeric',
            'between:0,100'
        ],

        'uas' => [
            'nullable',
            'numeric',
            'between:0,100'
        ],

        'survey' => [
            'required',
            'boolean'
        ],
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
     * CEK PERIODE INPUT MATA KULIAH
     * ==========================================================
     *
     * PERHATIKAN:
     *
     * Yang menentukan apakah MK menggunakan periode khusus
     * adalah kolom:
     *
     *     periode_input
     *
     * BUKAN:
     *
     *     jenis_mk
     *
     * Nilai periode_input hanya:
     *
     *     normal
     *     khusus
     */
    $periodeInput = strtolower(
        trim((string) $mk->periode_input)
    );

    $isKhusus = $periodeInput === 'khusus';
    $isNormal = $periodeInput === 'normal';

    /*
     * ==========================================================
     * VALIDASI NILAI PERIODE_INPUT
     * ==========================================================
     */
    if (!$isKhusus && !$isNormal) {
        return back()
            ->with(
                'error',
                'Periode input nilai mata kuliah tidak valid.'
            )
            ->withInput();
    }

    /*
     * ==========================================================
     * AMBIL MK KHUSUS YANG DIAKTIFKAN ADMIN
     * ==========================================================
     *
     * Contoh isi:
     *
     * ["AA26A703","AA26A704"]
     *
     * atau:
     *
     * [
     *     ["kodemk" => "AA26A703"],
     *     ["kodemk" => "AA26A704"]
     * ]
     */
    $mkKhususAktif = $periodeInputNilai->mk_khusus;

    /*
     * Kalau data berupa JSON string
     */
    if (is_string($mkKhususAktif)) {

        $decoded = json_decode(
            $mkKhususAktif,
            true
        );

        $mkKhususAktif = is_array($decoded)
            ? $decoded
            : [];
    }

    /*
     * Kalau null / format lain
     */
    if (!is_array($mkKhususAktif)) {
        $mkKhususAktif = [];
    }

    /*
     * ==========================================================
     * NORMALISASI DAFTAR MK KHUSUS
     * ==========================================================
     */
    $mkKhususAktif = collect($mkKhususAktif)
        ->map(function ($item) {

            /*
             * Contoh:
             *
             * "AA26A703"
             */
            if (is_scalar($item)) {
                return strtoupper(
                    trim((string) $item)
                );
            }

            /*
             * Contoh:
             *
             * [
             *     "kodemk" => "AA26A703"
             * ]
             */
            if (is_array($item)) {

                return strtoupper(
                    trim((string) (
                        $item['kodemk']
                        ?? $item['kode']
                        ?? $item['id']
                        ?? ''
                    ))
                );
            }

            return null;
        })
        ->filter()
        ->values()
        ->toArray();

    /*
     * ==========================================================
     * KODE MK YANG SEDANG DIINPUT
     * ==========================================================
     */
    $kodeMk = strtoupper(
        trim((string) $mk->kodemk)
    );

    /*
     * ==========================================================
     * CEK APAKAH MK KHUSUS DIAKTIFKAN ADMIN
     * ==========================================================
     *
     * Hanya berlaku jika:
     *
     *     periode_input = khusus
     *
     */
    $mkKhususDiizinkan =
        $isKhusus &&
        in_array(
            $kodeMk,
            $mkKhususAktif,
            true
        );

    /*
     * ==========================================================
     * CEK UTS
     * ==========================================================
     */
    $utsBaru = $validated['uts'] ?? null;

    $utsBerubah = $utsBaru != $utsLama;

    if ($utsBerubah) {

        /*
         * ======================================================
         * MK KHUSUS
         * ======================================================
         *
         * Tidak menggunakan periode UTS umum.
         *
         * Cukup MK diaktifkan Admin.
         */
        if ($isKhusus) {

            if (!$mkKhususDiizinkan) {

                return back()
                    ->with(
                        'error',
                        "MK khusus {$kodeMk} belum diaktifkan Admin untuk input nilai."
                    )
                    ->withInput();
            }

        /*
         * ======================================================
         * MK NORMAL
         * ======================================================
         *
         * Mengikuti periode input nilai UTS.
         */
        } else {

            $utsMulai =
                $periodeInputNilai->input_nilai_uts_mulai;

            $utsSelesai =
                $periodeInputNilai->input_nilai_uts_selesai;

            if (
                !$utsMulai ||
                !$utsSelesai ||
                !now()->between(
                    $utsMulai,
                    $utsSelesai
                )
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
     */
    $uasBaru = $validated['uas'] ?? null;

    $uasBerubah = $uasBaru != $uasLama;

    if ($uasBerubah) {

        /*
         * ======================================================
         * MK KHUSUS
         * ======================================================
         */
        if ($isKhusus) {

            if (!$mkKhususDiizinkan) {

                return back()
                    ->with(
                        'error',
                        "MK khusus {$kodeMk} belum diaktifkan Admin untuk input nilai."
                    )
                    ->withInput();
            }

        /*
         * ======================================================
         * MK NORMAL
         * ======================================================
         */
        } else {

            $uasMulai =
                $periodeInputNilai->input_nilai_uas_mulai;

            $uasSelesai =
                $periodeInputNilai->input_nilai_uas_selesai;

            if (
                !$uasMulai ||
                !$uasSelesai ||
                !now()->between(
                    $uasMulai,
                    $uasSelesai
                )
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
    $uts = $utsBaru;
    $uas = $uasBaru;

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

    /*
     * ==========================================================
     * SELESAI
     * ==========================================================
     */
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