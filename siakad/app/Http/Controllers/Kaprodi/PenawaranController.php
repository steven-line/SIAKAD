<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenawaranController extends Controller
{
    // 🔥 GENERATE SLOT 50 MENIT
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

    // 🔥 FORM INPUT
    public function create()
    {
        $matkuls = MataKuliah::orderBy('kodemk')->get();
        $dosens  = Dosen::orderBy('nama')->get();
        $jamSlots = $this->generateJamSlots();

        return view('kaprodi.penawaran.create', compact('matkuls', 'dosens', 'jamSlots'));
    }

    // 🔥 SIMPAN DATA (MANUAL JAM)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodemk' => 'required',
            'semester' => 'required',
            'periode' => 'required',
            'dosen' => 'required',
            'hari' => 'required',
            'mulaipukul' => 'required',
            'selesaipukul' => 'required',
            'jurusan' => 'required',
            'pataum' => 'required',
            'pagu' => 'nullable|numeric',
            'keterangan' => 'nullable',
        ]);

        $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
        $selesai = Carbon::createFromFormat('H:i', $request->selesaipukul);

        // ❌ VALIDASI 1: selesai harus > mulai
        if ($selesai->lessThanOrEqualTo($mulai)) {
            return back()->withErrors([
                'jam' => 'Jam selesai harus lebih dari jam mulai'
            ])->withInput();
        }

        // ❌ VALIDASI 2: harus kelipatan 50 menit
        $durasi = $mulai->diffInMinutes($selesai);

        if ($durasi % 50 !== 0) {
            return back()->withErrors([
                'jam' => 'Durasi harus kelipatan 50 menit'
            ])->withInput();
        }

        // ❌ VALIDASI 3: batas maksimal
        if ($selesai->format('H:i') > '17:10') {
            return back()->withErrors([
                'jam' => 'Melebihi batas maksimal jam 17:10'
            ])->withInput();
        }

        // ❌ VALIDASI 4: CEK BENTROK
        $bentrok = Penawaran::where('hari', $request->hari)
            ->where(function ($q) use ($mulai, $selesai) {
                $q->whereBetween('mulaipukul', [$mulai, $selesai])
                  ->orWhereBetween('selesaipukul', [$mulai, $selesai])
                  ->orWhere(function ($q2) use ($mulai, $selesai) {
                      $q2->where('mulaipukul', '<=', $mulai)
                         ->where('selesaipukul', '>=', $selesai);
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
            'kodemk' => $request->kodemk,
            'semester' => $request->semester,
            'periode' => $request->periode,
            'dosen' => $request->dosen,
            'hari' => $request->hari,
            'mulaipukul' => $request->mulaipukul,
            'selesaipukul' => $request->selesaipukul,
            'pataum' => $request->pataum,

            // 🔥 AUTO (tidak dari form)
            'jurusan' => auth()->user()->prodi ?? abort(403),

            'sesi' => $request->sesi ?? null,
            'keterangan' => $request->keterangan ?? null,
            'pagu' => $request->pagu ?? null,
        ]);

        return redirect()
            ->route('kaprodi.penawaran.create')
            ->with('success', 'Penawaran berhasil disimpan');
    }
}