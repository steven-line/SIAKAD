<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Mk;
use App\Models\Dosen;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenawaranController extends Controller
{
    /**
     * 🔥 SLOT JAM SESI 1 (PAGI)
     * 08:00 - 17:10
     */
    private function generateJamSlotsPagi()
    {
        $slots = [];

        $start = Carbon::createFromTime(8, 0);
        $end   = Carbon::createFromTime(17, 10);

        while ($start <= $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(50);
        }

        return $slots;
    }

    /**
     * 🔥 SLOT JAM SESI 2 (MALAM)
     * 18:00 - 22:00
     */
    private function generateJamSlotsMalam()
    {
        $slots = [];

        $start = Carbon::createFromTime(18, 0);
        $end   = Carbon::createFromTime(22, 0);

        while ($start <= $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(50);
        }

        return $slots;
    }

    /**
     * 🔥 FORM INPUT
     */
    public function create()
    {
        // 🔥 ambil matkul dari tabel mk
        $matkuls = Mk::orderBy('kodemk')->get();

        // 🔥 ambil dosen
        $dosens = Dosen::orderBy('nama')->get();

        // 🔥 slot jam pagi & malam
        $jamSlotsPagi  = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view(
            'kaprodi.penawaran.create',
            compact(
                'matkuls',
                'dosens',
                'jamSlotsPagi',
                'jamSlotsMalam'
            )
        );
    }

    /**
     * 🔥 SIMPAN DATA
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodemk'       => 'required',
            'semester'     => 'required',
            'periode'      => 'required',
            'dosen'        => 'required',
            'hari'         => 'required',
            'mulaipukul'   => 'required',
            'selesaipukul' => 'required',
            'pataum'       => 'required',
            'sesi'         => 'required',
            'pagu'         => 'nullable|numeric',
            'keterangan'   => 'nullable',
        ]);

        $mulai   = Carbon::createFromFormat('H:i', $request->mulaipukul);
        $selesai = Carbon::createFromFormat('H:i', $request->selesaipukul);

        /**
         * 🔥 BATAS JAM BERDASARKAN SESI
         */
        if ($request->sesi == '1') {

            $batasAwal  = '08:00';
            $batasAkhir = '17:10';

        } else {

            $batasAwal  = '18:00';
            $batasAkhir = '22:00';
        }

        // ❌ VALIDASI 1
        if ($selesai->lessThanOrEqualTo($mulai)) {
            return back()->withErrors([
                'jam' => 'Jam selesai harus lebih dari jam mulai'
            ])->withInput();
        }

        // ❌ VALIDASI 2
        $durasi = $mulai->diffInMinutes($selesai);

        if ($durasi % 50 !== 0) {
            return back()->withErrors([
                'jam' => 'Durasi harus kelipatan 50 menit'
            ])->withInput();
        }

        // ❌ VALIDASI 3 - CEK BATAS SESI
        if (
            $mulai->format('H:i') < $batasAwal ||
            $selesai->format('H:i') > $batasAkhir
        ) {
            return back()->withErrors([
                'jam' => 'Jam tidak sesuai dengan sesi yang dipilih'
            ])->withInput();
        }

        // ❌ VALIDASI 4 - CEK BENTROK
        $bentrok = Penawaran::where('hari', $request->hari)
            // 🛠️ PERBAIKAN 1: Ambil prodi lewat relasi dosen
            ->where('jurusan', auth()->user()->dosen->prodi)
            ->where(function ($q) use ($mulai, $selesai) {

                $q->whereBetween('mulaipukul', [
                        $mulai->format('H:i:s'),
                        $selesai->format('H:i:s')
                    ])

                  ->orWhereBetween('selesaipukul', [
                        $mulai->format('H:i:s'),
                        $selesai->format('H:i:s')
                    ])

                  ->orWhere(function ($q2) use ($mulai, $selesai) {

                      $q2->where(
                            'mulaipukul',
                            '<=',
                            $mulai->format('H:i:s')
                        )
                        ->where(
                            'selesaipukul',
                            '>=',
                            $selesai->format('H:i:s')
                        );
                  });
            })
            ->exists();

        if ($bentrok) {
            return back()->withErrors([
                'jam' => 'Jadwal bentrok dengan jadwal lain'
            ])->withInput();
        }

        // 🔥 SIMPAN
        Penawaran::create([
            'kodemk'       => $request->kodemk,
            'semester'     => $request->semester,
            'periode'      => $request->periode,
            'dosen'        => $request->dosen,
            'hari'         => $request->hari,
            'mulaipukul'   => $mulai->format('H:i:s'),
            'selesaipukul' => $selesai->format('H:i:s'),
            'pataum'       => $request->pataum,

            // 🛠️ PERBAIKAN 2: Ambil prodi lewat relasi dosen agar tidak NULL
            'jurusan'      => auth()->user()->dosen->prodi,

            'sesi'         => $request->sesi,
            'keterangan'   => $request->keterangan,
            'pagu'         => $request->pagu,
        ]);

        return redirect()
            ->route('kaprodi.penawaran.create')
            ->with('success', 'Penawaran berhasil disimpan');
    }
}