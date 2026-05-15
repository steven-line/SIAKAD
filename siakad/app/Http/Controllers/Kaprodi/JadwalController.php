<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * 🔥 SLOT JAM
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
     * 🔥 QUERY DASAR JADWAL
     */
    private function getJadwalQuery()
    {
        $user = Auth::user();

        if (!$user || !$user->prodi) {
            abort(403, 'User tidak memiliki prodi');
        }

        return Penawaran::with('matkul')
            ->where('jurusan', $user->prodi)
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
     * 🔥 SEMUA JADWAL
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
     * 🔥 JADWAL PAGI (SESI 1)
     */
    public function pagi()
    {
        $jadwals = $this->getJadwalQuery()
            ->where('sesi', 1)
            ->get();

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals')
        );
    }

    /**
     * 🔥 JADWAL MALAM (SESI 2)
     */
    public function malam()
    {
        $jadwals = $this->getJadwalQuery()
            ->where('sesi', 2)
            ->get();

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals')
        );
    }

    /**
     * 🔥 DETAIL JADWAL
     * + MAHASISWA YANG AMBIL
     */
    public function show($recno)
    {
        $jadwal = Penawaran::with([
                'matkul',
                'registrasis'
            ])
            ->findOrFail($recno);

        return view(
            'kaprodi.kelola_jadwal.show',
            compact('jadwal')
        );
    }
}