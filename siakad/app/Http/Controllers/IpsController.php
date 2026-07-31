<?php

namespace App\Http\Controllers;

use App\Models\Ips;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class IpsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with([
            'biodata',
            'ips'
        ])->orderBy('nrp')->get();

        return view('admin.ips.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ips $ips)
    {
        return view('admin.ips.show', compact('ips'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ips $ips)
    {
        //
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Ips $ips)
    {
        $request->validate([
            'toleransi' => 'required|integer|min:0|max:2',
        ]);

        // Mahasiswa dengan hak 24 SKS tidak boleh diberi toleransi
        if ($ips->maksimal_sks >= 24 && $request->toleransi > 0) {
            return back()->withErrors([
                'toleransi' => 'Mahasiswa dengan maksimal 24 SKS tidak dapat diberikan toleransi.'
            ])->withInput();
        }

        $ips->update([
            'toleransi' => $request->toleransi,
        ]);

        return redirect()
            ->route('ips.show', $ips->nrp)
            ->with('success', 'Toleransi SKS berhasil diperbarui.');
    }

    /**
     * Konversi nilai huruf ke bobot.
     */
    private function getBobot($nilai)
    {
        return match ($nilai) {
            'A'  => 4.00,
            'AB' => 3.50,
            'B'  => 3.00,
            'BC' => 2.50,
            'C'  => 2.00,
            'D'  => 1.00,
            default => 0.00,
        };
    }

    /**
     * Generate IPS seluruh mahasiswa.
     */
    public function generateIps()
    {
        $mahasiswas = Mahasiswa::all();

        foreach ($mahasiswas as $mahasiswa) {

            $krs = Krs::with('registrasi')
                ->whereHas('registrasi', function ($q) use ($mahasiswa) {
                    $q->where('nrp', $mahasiswa->nrp);
                })
                ->get();

            $totalSks = 0;
            $totalMutu = 0;

            foreach ($krs as $item) {

                $bobot = $this->getBobot($item->na);

                $totalMutu += ($bobot * $item->sks);
                $totalSks += $item->sks;
            }

            $ips = 0;

            if ($totalSks > 0) {
                $ips = round($totalMutu / $totalSks, 3);
            }

            // Menentukan maksimal SKS berdasarkan IPS
            if ($ips >= 3.000) {
                $maksimalSks = 24;
            } else {
                $maksimalSks = 21;
            }

            Ips::updateOrCreate(
                [
                    'nrp' => $mahasiswa->nrp,
                ],
                [
                    'ips' => $ips,
                    'maksimal_sks' => $maksimalSks,
                ]
            );
        }

        return redirect()
            ->route('ips.index')
            ->with('success', 'IPS seluruh mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Ips $ips)
    {
        //
    }
}