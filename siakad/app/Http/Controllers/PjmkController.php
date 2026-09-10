<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Periode;
use App\Models\Pjmk;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PjmkController extends Controller
{
    /**
     * ==========================================================
     * KODE PRODI KURIKULUM UMUM
     * ==========================================================
     *
     * Kurikulum umum digunakan untuk MK seperti:
     * - Tugas Akhir
     * - Magang
     * - KKN
     *
     * Berdasarkan data kurikulum:
     * kode_prodi = UM1
     */
    private const KODE_PRODI_UMUM = 'UM1';


    /**
     * ==========================================================
     * LIST MATA KULIAH YANG DAPAT DIATUR PJMK
     * ==========================================================
     *
     * ADMIN
     * - MK Umum
     * - MK Fakultas
     *
     * KAPRODI
     * - MK Prodi dari prodinya
     * - MK Khusus dari prodinya
     * - MK dari Kurikulum Umum (UM1)
     */
    public function index()
    {
        $user = auth()->user();


        /*
         * ======================================================
         * ADMIN
         * ======================================================
         */

        if ($user->can('pjmk.manage') && !$user->dosen) {

            $penawarans = Penawaran::leftJoin(
                    'semester',
                    'penawaran.semester_id',
                    '=',
                    'semester.id'
                )
                ->leftJoin(
                    'periode',
                    'semester.periode_id',
                    '=',
                    'periode.id'
                )
                ->whereHas('mk', function (Builder $query) {

                    /*
                     * Admin hanya dapat mengatur:
                     *
                     * MK Umum
                     * MK Fakultas
                     */
                    $query->whereIn('jenis_mk', [
                        'mk_umum',
                        'mk_fakultas',
                    ]);

                })
                ->select(
                    'semester.jenis',
                    'periode.tahun_ajaran',
                    'penawaran.kodemk',
                    'periode.id as periode_id'
                )
               
                ->with('mk')
                ->distinct()
                ->paginate(10);


            return view(
                'kaprodi.pjmk.list_matkul',
                [
                    'penawarans' => $penawarans
                ]
            );
        }


        /*
         * ======================================================
         * KAPRODI
         * ======================================================
         */

        if ($user->dosen) {

            $prodiLogin = $user->dosen->prodi;


            /*
             * Kaprodi wajib memiliki prodi.
             */
            if (!$prodiLogin) {
                abort(403);
            }


            $penawarans = Penawaran::leftJoin(
                    'semester',
                    'penawaran.semester_id',
                    '=',
                    'semester.id'
                )
                ->leftJoin(
                    'periode',
                    'semester.periode_id',
                    '=',
                    'periode.id'
                )

                ->whereHas('mk', function (Builder $query) {

                    $query->whereIn('jenis_mk', [
                        'mk_prodi',
                        'mk_khusus',
                    ]);

                })

                ->whereHas('mk.kurikulum', function (Builder $query) use ($prodiLogin) {

                    $query->where(function (Builder $q) use ($prodiLogin) {

                        $q->where(
                            'kode_prodi',
                            $prodiLogin
                        )

                        ->orWhere(
                            'kode_prodi',
                            self::KODE_PRODI_UMUM
                        );

                    });

                })

                ->select(
                    'semester.jenis',
                    'periode.tahun_ajaran',
                    'penawaran.kodemk',
                    'periode.id as periode_id'
                )
                ->with('mk')
                ->distinct()
                ->paginate(10);


            return view(
                'kaprodi.pjmk.list_matkul',
                [
                    'penawarans' => $penawarans
                ]
            );
        }


        /*
         * ======================================================
         * TIDAK MEMILIKI AKSES
         * ======================================================
         */

        abort(403);
    }


    /**
     * ==========================================================
     * LIST DOSEN UNTUK MATA KULIAH
     * ==========================================================
     */
    public function list_dosen_matkul(
        Periode $periode,
        Semester $semester,
        Mk $mk
    ) {

        $user = auth()->user();


        /*
         * ======================================================
         * ADMIN
         * ======================================================
         *
         * Admin hanya:
         * - MK Umum
         * - MK Fakultas
         */
        if ($user->can('pjmk.manage') && !$user->dosen) {

            if (!in_array($mk->jenis_mk, [
                'mk_umum',
                'mk_fakultas',
            ])) {

                abort(403);
            }
        }


        /*
         * ======================================================
         * KAPRODI
         * ======================================================
         *
         * Kaprodi:
         * - MK Prodi dari prodinya
         * - MK Khusus dari prodinya
         * - MK Kurikulum Umum UM1
         */
        elseif ($user->dosen) {

            if (!in_array($mk->jenis_mk, [
                'mk_prodi',
                'mk_khusus',
            ])) {

                abort(403);
            }


            $prodiLogin = $user->dosen->prodi;


            if (!$prodiLogin) {
                abort(403);
            }


            $mkProdi = optional(
                $mk->kurikulum
            )->kode_prodi;


            /*
             * MK boleh diakses jika:
             *
             * 1. Kurikulumnya milik prodi Kaprodi
             *
             * ATAU
             *
             * 2. Kurikulumnya adalah kurikulum umum UM1
             */
            if (
                $mkProdi !== $prodiLogin &&
                $mkProdi !== self::KODE_PRODI_UMUM
            ) {

                abort(403);
            }
        }


        /*
         * ======================================================
         * USER TIDAK MEMILIKI AKSES
         * ======================================================
         */
        else {

            abort(403);
        }


        /*
         * ======================================================
         * LIST DOSEN
         * ======================================================
         */

        $dosens = Dosen::whereHas(
                'penawaran.semester',
                function (Builder $query) use (
                    $periode,
                    $semester
                ) {

                    $query->where(
                        'jenis',
                        $semester->jenis
                    );

                    $query->where(
                        'periode_id',
                        $periode->id
                    );
                }
            )
            ->whereHas(
                'penawaran',
                function (Builder $query) use ($mk) {

                    $query->where(
                        'kodemk',
                        $mk->kodemk
                    );
                }
            )
            ->paginate(10);


        /*
         * ======================================================
         * PJMK SAAT INI
         * ======================================================
         */

        $currentPjmk = Pjmk::where(
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


        return view(
            'kaprodi.pjmk.list_dosen_matkul',
            [
                'dosens' => $dosens,
                'periode' => $periode,
                'semester' => $semester,
                'mk' => $mk,
                'currentPjmk' => $currentPjmk
            ]
        );
    }


    /**
     * ==========================================================
     * SET PJMK
     * ==========================================================
     */
    public function setPjmk(Request $request)
    {
        $user = auth()->user();


        /*
         * ======================================================
         * VALIDASI REQUEST
         * ======================================================
         */

        $validated = $request->validate([
            'nim_dosen' => [
                'required',
                'exists:dosen,nim_dosen',
            ],

            'kodemk' => [
                'required',
                'exists:mk,kodemk',
            ],

            'periode_id' => [
                'required',
                'exists:periode,id',
            ],

            'jenis' => [
                'required',
                'in:Ganjil,Genap',
            ],
        ]);


        /*
         * ======================================================
         * AMBIL MK
         * ======================================================
         */

        $mk = Mk::with('kurikulum')
            ->where(
                'kodemk',
                $validated['kodemk']
            )
            ->firstOrFail();


        /*
         * ======================================================
         * ADMIN
         * ======================================================
         *
         * Admin:
         * - MK Umum
         * - MK Fakultas
         */

        if ($user->can('pjmk.manage') && !$user->dosen) {

            if (!in_array($mk->jenis_mk, [
                'mk_umum',
                'mk_fakultas',
            ])) {

                abort(403);
            }
        }


        /*
         * ======================================================
         * KAPRODI
         * ======================================================
         *
         * Kaprodi:
         * - MK Prodi dari prodinya
         * - MK Khusus dari prodinya
         * - MK Kurikulum Umum UM1
         */

        elseif ($user->dosen) {

            if (!in_array($mk->jenis_mk, [
                'mk_prodi',
                'mk_khusus',
            ])) {

                abort(403);
            }


            $prodiLogin = $user->dosen->prodi;


            if (!$prodiLogin) {
                abort(403);
            }


            $kodeProdiMk = optional(
                $mk->kurikulum
            )->kode_prodi;


            /*
             * MK harus:
             *
             * 1. Milik prodi Kaprodi
             *
             * ATAU
             *
             * 2. Berasal dari kurikulum umum UM1
             */
            if (
                $kodeProdiMk !== $prodiLogin &&
                $kodeProdiMk !== self::KODE_PRODI_UMUM
            ) {

                abort(403);
            }
        }


        /*
         * ======================================================
         * USER TIDAK MEMILIKI AKSES
         * ======================================================
         */

        else {

            abort(403);
        }


        /*
         * ======================================================
         * SIMPAN PJMK
         * ======================================================
         */

        Pjmk::updateOrCreate(
            [
                'kodemk' => $validated['kodemk'],

                'periode_id' => $validated['periode_id'],

                'jenis' => $validated['jenis'],
            ],
            [
                'nim_dosen' => $validated['nim_dosen'],
            ]
        );


        return redirect()
            ->back()
            ->with(
                'success',
                'PJMK untuk mata kuliah ini berhasil disimpan!'
            );
    }
}
