<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * SLOT JAM
     */
    private function generateJamSlots()
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
     * QUERY DASAR JADWAL (FIXED)
     */
    private function getJadwalQuery()
    {
        $query = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi',
            'prodiRelasi'
        ]);

        /**
         * OPTIONAL FILTER:
         * hanya filter kalau user adalah DOSEN
         */
        $user = Auth::user();

        if ($user && $user->dosen) {
            $kodeProdi = $user->dosen->prodi;

            $query->where('prodi', $kodeProdi);
        }

        return $query->orderByRaw("
            FIELD(
                hari,
                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'
            )
        ")->orderBy('mulaipukul');
    }

    /**
     * SEMUA JADWAL
     */
    public function index()
    {
        $jadwals = $this->getJadwalQuery()->get();
        $jamSlots = $this->generateJamSlots();

        return view('kaprodi.kelola_jadwal.index', compact('jadwals', 'jamSlots'));
    }

    /**
     * PAGI
     */
    public function pagi()
    {
        $jadwals = $this->getJadwalQuery()
            ->where('sesi', '1')
            ->get();

        $jamSlots = $this->generateJamSlots();

        return view('kaprodi.kelola_jadwal.index', compact('jadwals', 'jamSlots'));
    }

    /**
     * MALAM
     */
    public function malam()
    {
        $jadwals = $this->getJadwalQuery()
            ->where('sesi', '2')
            ->get();

        $jamSlots = $this->generateJamSlots();

        return view('kaprodi.kelola_jadwal.index', compact('jadwals', 'jamSlots'));
    }

    /**
     * DETAIL
     */
    public function show($recno)
    {
        $jadwal = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi',
            'prodiRelasi'
        ])->findOrFail($recno);

        return view('kaprodi.kelola_jadwal.show', compact('jadwal'));
    }
}