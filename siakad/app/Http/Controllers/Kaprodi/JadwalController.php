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
     * 🔥 QUERY DASAR JADWAL (Sudah Diperbaiki via Relasi Dosen)
     */
    private function getJadwalQuery()
    {
        $user = Auth::user();

        // 1. Pastikan user login dan memiliki data profil di tabel dosen
        if (!$user || !$user->dosen) {
            abort(403, 'User tidak teridentifikasi sebagai Dosen/Kaprodi.');
        }

        // 2. Ambil kode prodi langsung dari kolom 'prodi' di tabel dosen
        $prodiKaprodi = $user->dosen->prodi; 

        if (!$prodiKaprodi) {
            abort(403, 'Dosen ini tidak memiliki Program Studi (Homebase).');
        }

        // 3. Filter jadwal penawaran berdasarkan prodi si dosen
        return Penawaran::with('matkul')
            ->where('jurusan', $prodiKaprodi)
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
            
        $jamSlots = $this->generateJamSlots(); // Ditambahkan agar view tidak error

        return view(
            'kaprodi.kelola_jadwal.index',
            compact('jadwals', 'jamSlots')
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
            
        $jamSlots = $this->generateJamSlots(); // Ditambahkan agar view tidak error

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