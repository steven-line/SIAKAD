<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mk;
use App\Models\Metaperiode;
use App\Models\Penawaran;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenawaranAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $penawarans = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode'
        ])
        ->whereHas('mk', function ($q) {
            $q->where('kodemk', 'like', 'A%');
        })
        ->orderBy('hari')
        ->orderBy('mulaipukul')
        ->paginate(15);

        return view('admin.penawaran_admin.index', compact('penawarans'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $metaPeriode = Metaperiode::first();

        if (
            !$metaPeriode ||
            !$metaPeriode->input_penawaran_mulai ||
            !$metaPeriode->input_penawaran_selesai ||
            now()->lt($metaPeriode->input_penawaran_mulai) ||
            now()->gt($metaPeriode->input_penawaran_selesai)
        ) {
            return redirect()
                ->route('admin.penawaran.index')
                ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
        }

        // Hanya MK Umum
        $matkuls = Mk::where('kodemk', 'like', 'A%')
            ->orderBy('nama')
            ->get();

        $dosens = Dosen::orderBy('nama')->get();

        $semesters = Semester::with('periode')
            ->whereHas('periode', function ($q) {
                $q->where('aktif', 1);
            })
            ->where('aktif', 1)
            ->get();

        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view('admin.penawaran_admin.create', compact(
            'matkuls',
            'dosens',
            'semesters',
            'jamSlotsPagi',
            'jamSlotsMalam'
        ));
    }

public function store(Request $request)
{
    $metaPeriode = Metaperiode::first();

    if (
        !$metaPeriode ||
        now()->lt($metaPeriode->input_penawaran_mulai) ||
        now()->gt($metaPeriode->input_penawaran_selesai)
    ) {
        return redirect()
            ->route('admin.penawaran.index')
            ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
    }

    $request->validate([
        'kodemk'       => 'required|exists:mk,kodemk',
        'semester_id'  => 'required|exists:semester,id',
        'dosen'        => 'required|exists:dosen,nim_dosen',
        'hari'         => 'required',
        'mulaipukul'   => 'required',
        'pataum'       => 'required',
        'sesi'         => 'required',
        'pagu'         => 'required|integer|between:1,99',
        'keterangan'   => 'nullable',
    ]);

    // Hanya boleh MK umum
    if (!str_starts_with($request->kodemk, 'A')) {
        return back()
            ->withErrors([
                'kodemk' => 'Admin hanya boleh membuat penawaran mata kuliah umum.'
            ])
            ->withInput();
    }

    $mk = Mk::where('kodemk', $request->kodemk)->firstOrFail();

    $durasiMenit = ((int) $mk->sks) * 50;

    $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
    $selesai = $mulai->copy()->addMinutes($durasiMenit);

    if ($request->sesi == 1) {
        $batasAwal = Carbon::createFromTime(8,0);
        $batasAkhir = Carbon::createFromTime(17,10);
    } else {
        $batasAwal = Carbon::createFromTime(18,0);
        $batasAkhir = Carbon::createFromTime(22,0);
    }

    if ($mulai->lt($batasAwal)) {
        return back()->withErrors([
            'jam' => 'Jam mulai tidak sesuai sesi.'
        ])->withInput();
    }

    if ($selesai->gt($batasAkhir)) {
        return back()->withErrors([
            'jam' => 'Durasi mata kuliah melebihi batas sesi.'
        ])->withInput();
    }

    // Cek bentrok
    $bentrok = Penawaran::where('hari', $request->hari)
        ->where(function ($q) use ($request) {
            $q->where('kodemk', $request->kodemk)
              ->orWhere('dosen', $request->dosen);
        })
        ->where(function ($q) use ($mulai, $selesai) {

            $q->whereBetween('mulaipukul', [
                $mulai->format('H:i:s'),
                $selesai->format('H:i:s')
            ])

            ->orWhereBetween('selesaipukul', [
                $mulai->format('H:i:s'),
                $selesai->format('H:i:s')
            ])

            ->orWhere(function ($q2) use ($mulai, $selesai) {

                $q2->where('mulaipukul', '<=', $mulai->format('H:i:s'))
                   ->where('selesaipukul', '>=', $selesai->format('H:i:s'));

            });

        })
        ->exists();

    if ($bentrok) {
        return back()->withErrors([
            'jam' => 'Jadwal bentrok dengan mata kuliah atau dosen lain.'
        ])->withInput();
    }

    Penawaran::create([
        'kodemk'       => $request->kodemk,
        'semester_id'  => $request->semester_id,
        'dosen'        => $request->dosen,
        'hari'         => $request->hari,
        'mulaipukul'   => $mulai->format('H:i:s'),
        'selesaipukul' => $selesai->format('H:i:s'),
        'pataum'       => $request->pataum,
        'sesi'         => $request->sesi,
        'keterangan'   => $request->keterangan,
        'pagu'         => $request->pagu,
        'MBKM'         => $request->has('MBKM'),
    ]);

    return redirect()
        ->route('admin.penawaran.index')
        ->with('success', 'Penawaran umum berhasil ditambahkan.');
}

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($recno)
    {
        $penawaran = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode',
            'registrasis.mahasiswa.biodata',
        ])->findOrFail($recno);

    return view('admin.penawaran_admin.index', compact('penawarans'));    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($recno)
    {
        $metaPeriode = Metaperiode::first();

        if (
            !$metaPeriode ||
            !$metaPeriode->input_penawaran_mulai ||
            !$metaPeriode->input_penawaran_selesai ||
            now()->lt($metaPeriode->input_penawaran_mulai) ||
            now()->gt($metaPeriode->input_penawaran_selesai)
        ) {
            return redirect()
                ->route('admin.penawaran.index')
                ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
        }

        $penawaran = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode',
        ])->findOrFail($recno);

        $matkuls = Mk::where('kodemk', 'like', 'A%')
            ->orderBy('nama')
            ->get();

        $dosens = Dosen::orderBy('nama')->get();

        $semesters = Semester::with('periode')
            ->whereHas('periode', function ($q) {
                $q->where('aktif', 1);
            })
            ->where('aktif', 1)
            ->get();

        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view('admin.penawaran_admin.create', compact(
            'matkuls',
            'dosens',
            'semesters',
            'jamSlotsPagi',
            'jamSlotsMalam'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Penawaran $penawaran)
    {
        // Salin dari PenawaranController Kaprodi.
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Penawaran $penawaran)
    {
        $metaPeriode = Metaperiode::first();

        if (
            !$metaPeriode ||
            now()->lt($metaPeriode->input_penawaran_mulai) ||
            now()->gt($metaPeriode->input_penawaran_selesai)
        ) {
            return redirect()
                ->route('admin.penawaran.index')
                ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
        }

        $penawaran->delete();

        return redirect()
            ->route('admin.penawaran.index')
            ->with('success', 'Penawaran berhasil dihapus.');
    }

    /**
     * Generate jam pagi (interval 50 menit)
     */
    private function generateJamSlotsPagi()
    {
        $slots = [];

        $current = Carbon::createFromTime(8, 0);
        $batas = Carbon::createFromTime(17, 10);

        while ($current->lt($batas)) {

            $slots[] = $current->format('H:i');

            $current->addMinutes(50);
        }

        return $slots;
    }

    /**
     * Generate jam malam (interval 50 menit)
     */
    private function generateJamSlotsMalam()
    {
        $slots = [];

        $current = Carbon::createFromTime(18, 0);
        $batas = Carbon::createFromTime(22, 0);

        while ($current->lt($batas)) {

            $slots[] = $current->format('H:i');

            $current->addMinutes(50);
        }

        return $slots;
    }

}