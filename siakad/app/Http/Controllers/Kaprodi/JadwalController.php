<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    // ✅ tampil tabel jadwal
    public function index()
    {
        $jadwals = Jadwal::orderBy('hari')->orderBy('sesi')->get();
        return view('kaprodi.kelola_jadwal.index', compact('jadwals'));
    }

    // ✅ tampil form input
    public function create(Request $request)
    {
        return view('kaprodi.kelola_jadwal.buatJadwal', [
            'hari' => $request->hari,
            'sesi' => $request->sesi,
        ]);
    }

    // ✅ simpan ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodemk' => 'required|string|max:50',
            'nama_mk' => 'required|string|max:255',
            'hari' => 'required|string',
            'sesi' => 'required|in:1,2,3',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $sesi = (int) $validated['sesi'];

        // ❌ cegah slot dobel
        $cek = Jadwal::where('hari', $validated['hari'])
            ->where('sesi', $sesi)
            ->first();

        if ($cek) {
            return back()
                ->withErrors(['error' => 'Slot jadwal sudah terisi!'])
                ->withInput();
        }

        Jadwal::create([
            'kodemk' => $validated['kodemk'],
            'nama_mk' => $validated['nama_mk'],
            'hari' => $validated['hari'],
            'sesi' => $sesi,
            'sks' => $validated['sks'],

            'jam_mulai' => match($sesi) {
                1 => '08:00:00',
                2 => '11:00:00',
                3 => '14:00:00',
                default => null,
            },

            'jam_selesai' => match($sesi) {
                1 => '11:00:00',
                2 => '14:00:00',
                3 => '16:30:00',
                default => null,
            },
        ]);

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    // ✅ tampil form edit
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('kaprodi.kelola_jadwal.editJadwal', compact('jadwal'));
    }

    // ✅ update data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kodemk' => 'required|string|max:50',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $sesi = (int) $jadwal->sesi;

        $jadwal->update([
            'kodemk' => $validated['kodemk'],
            'nama_mk' => $validated['nama_mk'],
            'sks' => $validated['sks'],

            'jam_mulai' => match($sesi) {
                1 => '08:00:00',
                2 => '11:00:00',
                3 => '14:00:00',
                default => null,
            },

            'jam_selesai' => match($sesi) {
                1 => '11:00:00',
                2 => '14:00:00',
                3 => '16:30:00',
                default => null,
            },
        ]);

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    // ✅ hapus data
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect('/kaprodi/kelola_jadwal')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}