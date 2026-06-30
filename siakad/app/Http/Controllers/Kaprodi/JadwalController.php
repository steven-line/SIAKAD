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
     * Query dasar jadwal
     */
    private function getJadwalQuery()
    {
        $query = Penawaran::with([
            'mk.kurikulum',
            'dosenRelasi',
            'semesterRelasi.periode',
        ]);

        $user = Auth::user();

        if ($user && $user->dosen) {

            $prodiLogin = $user->dosen->prodi;

            $query->whereHas('mk.kurikulum', function ($q) use ($prodiLogin) {
                $q->where('kode_prodi', $prodiLogin);
            });
        }

        return $query
            ->orderByRaw("
                FIELD(
                    hari,
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu'
                )
            ")
            ->orderBy('mulaipukul');
    }
    /**
     * Semua jadwal
     */
    public function index()
    {
        $jadwals = $this->getJadwalQuery()->get();

        $jamSlots = $this->generateJamSlots();

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals', 'jamSlots')
        );
    }

    /**
     * Jadwal pagi
     */
    public function pagi()
    {
        $jadwals = $this->getJadwalQuery()
            ->where('sesi', '1')
            ->get();

        $jamSlots = $this->generateJamSlots();

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals', 'jamSlots')
        );
    }

    /**
     * Jadwal malam
     */
    public function malam()
    {
        $jadwals = $this->getJadwalQuery()
            ->where('sesi', '2')
            ->get();

        $jamSlots = $this->generateJamSlots();

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals', 'jamSlots')
        );
    }

    /**
     * Detail jadwal
     */
    public function show($recno)
    {
        $query = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode',
        ]);

        $user = Auth::user();

        if ($user && $user->dosen) {

            $prodi = $user->dosen->prodi;
            $query->whereHas('mk.kurikulum', function ($q) use ($prodi) {
                $q->where('kode_prodi', $prodi);
            });
        }

        $jadwal = $query->findOrFail($recno);

        return view(
            'kaprodi.kelola_jadwal.show',
            compact('jadwal')
        );
    }
}