<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Mk;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenawaranController extends Controller
{
    /**
     * SLOT JAM SESI PAGI
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
     * SLOT JAM SESI MALAM
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
     * FORM INPUT
     */
    public function create()
    {
        $matkuls = Mk::orderBy('kodemk')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $jurusans = Jurusan::orderBy('kode_jurusan')->get();

        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view(
            'kaprodi.penawaran.create',
            compact(
                'matkuls',
                'dosens',
                'jurusans',
                'jamSlotsPagi',
                'jamSlotsMalam'
            )
        );
    }

    /**
     * SIMPAN DATA
     */
    public function store(Request $request)
    {
        $request->validate([
            'kodemk'     => 'required',
            'semester'   => 'required',
            'periode'    => 'required',
            'dosen'      => 'required',
            'hari'       => 'required',
            'mulaipukul' => 'required',
            'pataum'     => 'required',
            'sesi'       => 'required',
            'pagu'       => 'nullable|numeric',
            'keterangan' => 'nullable',
        ]);

        /**
         * Ambil MK
         */
        $mk = Mk::where('kodemk', $request->kodemk)
            ->firstOrFail();

        /**
         * Hitung durasi berdasarkan SKS
         * 1 SKS = 50 menit
         */
        $durasiMenit = ((int) $mk->sks) * 50;

        /**
         * Jam mulai & selesai otomatis
         */
        $mulai = Carbon::createFromFormat(
            'H:i',
            $request->mulaipukul
        );

        $selesai = $mulai->copy()
            ->addMinutes($durasiMenit);

        /**
         * Jurusan dari dosen yang login
         */
        $kodeJurusan = auth()->user()->dosen->prodi;

        /**
         * Batas sesi
         */
        if ($request->sesi == '1') {

            $batasAwal = Carbon::createFromTime(8, 0);
            $batasAkhir = Carbon::createFromTime(17, 10);

        } else {

            $batasAwal = Carbon::createFromTime(18, 0);
            $batasAkhir = Carbon::createFromTime(22, 0);

        }

        /**
         * Validasi jam mulai
         */
        if ($mulai->lt($batasAwal)) {

            return back()
                ->withErrors([
                    'jam' => 'Jam mulai tidak sesuai sesi'
                ])
                ->withInput();
        }

        /**
         * Validasi jam selesai
         */
        if ($selesai->gt($batasAkhir)) {

            return back()
                ->withErrors([
                    'jam' => 'Durasi mata kuliah melebihi batas sesi'
                ])
                ->withInput();
        }

        /**
         * Cek bentrok jadwal
         */
        $bentrok = Penawaran::where('hari', $request->hari)
            ->where('jurusan', $kodeJurusan)
            ->where(function ($q) use ($mulai, $selesai) {

                $q->whereBetween(
                    'mulaipukul',
                    [
                        $mulai->format('H:i:s'),
                        $selesai->format('H:i:s')
                    ]
                )

                ->orWhereBetween(
                    'selesaipukul',
                    [
                        $mulai->format('H:i:s'),
                        $selesai->format('H:i:s')
                    ]
                )

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

            return back()
                ->withErrors([
                    'jam' => 'Jadwal bentrok dengan jadwal lain'
                ])
                ->withInput();
        }

        /**
         * Simpan
         */
        Penawaran::create([
            'kodemk'       => $request->kodemk,
            'semester'     => $request->semester,
            'periode'      => $request->periode,
            'dosen'        => $request->dosen,
            'hari'         => $request->hari,
            'mulaipukul'   => $mulai->format('H:i:s'),
            'selesaipukul' => $selesai->format('H:i:s'),
            'pataum'       => $request->pataum,
            'jurusan'      => $kodeJurusan,
            'sesi'         => $request->sesi,
            'keterangan'   => $request->keterangan,
            'pagu'         => $request->pagu,
            'MBKM'         => $request->has('MBKM'),
        ]);

        return redirect()
            ->route('kaprodi.penawaran.create')
            ->with(
                'success',
                'Penawaran berhasil disimpan'
            );
    }
}