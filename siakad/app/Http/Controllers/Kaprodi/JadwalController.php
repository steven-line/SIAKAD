<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('kaprodi.kelola_jadwal.index', compact('jadwals'));
    }

    public function create(Request $request)
    {
        return view('kaprodi.kelola_jadwal.buatJadwal', [
            'hari' => $request->hari,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodemk' => 'required|string|max:50',
            'nama_mk' => 'required|string|max:255',
            'hari' => 'required|string',
            'sks' => 'required|integer|min:1|max:6',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        $sks = (int) $validated['sks'];

        $jamMulai = Carbon::createFromFormat('H:i', $validated['jam_mulai']);
        $jamSelesai = $jamMulai->copy()->addMinutes($sks * 50);

        // 🔥 BATAS JAM KULIAH
        $batasAwal = Carbon::createFromFormat('H:i', '08:00');
        $batasAkhir = Carbon::createFromFormat('H:i', '17:00');

        if ($jamMulai->lt($batasAwal) || $jamSelesai->gt($batasAkhir)) {
            return back()->withErrors([
                'jam' => 'Jam harus antara 08:00 - 17:00'
            ])->withInput();
        }

        // 🔥 CEK BENTROK (VERSI BENAR)
        $bentrok = Jadwal::where('hari', $validated['hari'])
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($bentrok) {
            return back()->withErrors([
                'jam' => 'Jadwal bentrok!'
            ])->withInput();
        }

        Jadwal::create([
            'kodemk' => $validated['kodemk'],
            'nama_mk' => $validated['nama_mk'],
            'hari' => $validated['hari'],
            'sks' => $sks,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('kaprodi.kelola_jadwal.editJadwal', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kodemk' => 'required|string|max:50',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        $jamMulai = Carbon::createFromFormat('H:i', $validated['jam_mulai']);
        $jamSelesai = $jamMulai->copy()->addMinutes($validated['sks'] * 50);

        // 🔥 CEK BENTROK (EXCEPT DIRI SENDIRI)
        $bentrok = Jadwal::where('hari', $jadwal->hari)
            ->where('id', '!=', $id)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($bentrok) {
            return back()->withErrors([
                'jam' => 'Jadwal bentrok saat update!'
            ])->withInput();
        }

        $jadwal->update([
            'kodemk' => $validated['kodemk'],
            'nama_mk' => $validated['nama_mk'],
            'sks' => $validated['sks'],
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}