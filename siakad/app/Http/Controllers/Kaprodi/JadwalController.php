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
     * 🔥 (OPSIONAL) Slot jam - dipakai kalau mau grid
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
     * 🔥 TAMPILKAN JADWAL
     */
    public function index()
    {
        // ❗ pastikan user login
        $user = Auth::user();

        if (!$user || !$user->prodi) {
            abort(403, 'User tidak memiliki prodi');
        }

        // 🔥 ambil data + relasi matkul
        $jadwals = Penawaran::with('matkul')
            ->where('jurusan', $user->prodi)
            ->orderByRaw("
                FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')
            ")
            ->orderBy('mulaipukul')
            ->get();

        // 🔥 hanya dipakai kalau pakai tampilan grid
        $jamSlots = $this->generateJamSlots();

        return view('kaprodi.kelola_jadwal.index', compact('jadwals', 'jamSlots'));
    }
}