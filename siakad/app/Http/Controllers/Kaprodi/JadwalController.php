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
     * 🔥 HALAMAN JADWAL
     */
    public function index()
    {
        $user = Auth::user();

        // ❌ kalau tidak punya prodi
        if (!$user || !$user->prodi) {
            abort(403, 'User tidak memiliki prodi');
        }

        // 🔥 ambil semua jadwal
        $jadwals = Penawaran::with('matkul')
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
            ->orderBy('mulaipukul')
            ->get();

        $jamSlots = $this->generateJamSlots();

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals', 'jamSlots')
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