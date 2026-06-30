<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Mk;
use App\Models\Dosen;
use App\Models\prodi;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenawaranController extends Controller
{
    /**
     * SLOT JAM SESI PAGI
     */
    private function generateJamSlotsPagi()
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
     * SLOT JAM SESI MALAM
     */
    private function generateJamSlotsMalam()
    {
        $slots = [];

        $start = Carbon::createFromTime(18, 0);
        $end   = Carbon::createFromTime(22, 0);

        while ($start <= $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(50);
        }

        return $slots;
    }


    public function semesterRelasi()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function registrasis()
    {
        return $this->hasMany(Registrasi::class, 'penawaran_id', 'recno');
    }

    /**
     * FORM INPUT
     */
    public function create()
    {
        $matkuls = Mk::orderBy('nama')->get();
        $prodiLogin = auth()->user()->dosen->prodi;

        $dosens = Dosen::where('prodi', $prodiLogin)
            ->orderBy('nama')
            ->get();
        $semesters = Semester::with('periode')
            ->whereAktif(true)
            ->get();

        // PERBAIKI BAGIAN INI
        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view('kaprodi.penawaran.create', compact(
            'matkuls',
            'dosens',
            'semesters',
            'jamSlotsPagi',
            'jamSlotsMalam'
        ));
    }

    public function index()
    {
        $query = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode',
        ]);

        $user = auth()->user();

        if ($user && $user->dosen) {

            $prodiLogin = $user->dosen->prodi;

            $query->whereHas('dosenRelasi', function ($q) use ($prodiLogin) {
                $q->where('prodi', $prodiLogin);
            });
        }

        $penawarans = $query
            ->orderBy('hari')
            ->paginate(10);

        return view(
            'kaprodi.penawaran.index',
            compact('penawarans')
        );
    }

    public function show($recno)
    {
        $query = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode',
        ]);

        $user = auth()->user();

        if ($user && $user->dosen) {

            $prodiLogin = $user->dosen->prodi;

            $query->whereHas('dosenRelasi', function ($q) use ($prodiLogin) {
                $q->where('prodi', $prodiLogin);
            });
        }

        $penawaran = $query->findOrFail($recno);

        return view(
            'kaprodi.penawaran.show',
            compact('penawaran')
        );
    }

   public function store(Request $request)
{
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

    // Mata kuliah
    $mk = Mk::where('kodemk', $request->kodemk)->firstOrFail();

    $durasiMenit = $mk->sks * 50;

    $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
    $selesai = $mulai->copy()->addMinutes($durasiMenit);

    // Prodi Kaprodi yang login
    $prodiLogin = auth()->user()->dosen->prodi;

    // Validasi sesi
    if ($request->sesi == '1') {
        $batasAwal  = Carbon::createFromTime(8, 0);
        $batasAkhir = Carbon::createFromTime(17, 10);
    } else {
        $batasAwal  = Carbon::createFromTime(18, 0);
        $batasAkhir = Carbon::createFromTime(22, 0);
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

    $bentrok = Penawaran::where('hari', $request->hari)

        ->whereHas('dosenRelasi', function ($q) use ($prodiLogin) {
            $q->where('prodi', $prodiLogin);
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
            'jam' => 'Jadwal bentrok dengan penawaran lain pada prodi Anda.'
        ])->withInput();
    }

    Penawaran::create([
        'kodemk'       => $request->kodemk,
        'semester_id'  => $request->semester_id,
        'dosen'        => $request->dosen,
        'hari'         => $request->hari,
        'mulaipukul'   => $mulai->format('H:i:s'),
        'selesaipukul' => $selesai->format('H:i:s'),
        'sesi'         => $request->sesi,
        'pataum'       => $request->pataum,
        'pagu'         => $request->pagu,
        'MBKM'         => $request->has('MBKM'),
        'keterangan'   => $request->keterangan,
    ]);

    return redirect()
        ->route('penawaran.index')
        ->with('success', 'Penawaran berhasil ditambahkan.');
}

    public function edit($recno)
    {
        $query = Penawaran::with([
            'mk',
            'dosenRelasi',
            'semesterRelasi.periode',
        ]);

        $user = auth()->user();

        if ($user && $user->dosen) {

            $prodiLogin = $user->dosen->prodi;

            $query->whereHas('dosenRelasi', function ($q) use ($prodiLogin) {
                $q->where('prodi', $prodiLogin);
            });
        }

        $penawaran = $query->findOrFail($recno);

        $matkuls = Mk::orderBy('nama')->get();

        $dosens = Dosen::where('prodi', $user->dosen->prodi)
                        ->orderBy('nama')
                        ->get();

        $semesters = Semester::with('periode')
            ->where('aktif', 1)
            ->get();

        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view('kaprodi.penawaran.edit', compact(
            'penawaran',
            'matkuls',
            'dosens',
            'semesters',
            'jamSlotsPagi',
            'jamSlotsMalam'
        ));
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        $request->validate([
            'kodemk'     => 'required',
            'semester_id' => 'required|exists:semester,id',
            'dosen'      => 'required',
            'hari'       => 'required',
            'mulaipukul' => 'required',
            'pataum'     => 'required',
            'sesi'       => 'required',
            'pagu' => 'required|integer|between:1,99',
            'keterangan' => 'nullable',
        ]);

        $mk = Mk::where('kodemk', $request->kodemk)->firstOrFail();

        $durasiMenit = ((int) $mk->sks) * 50;

        $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
        $selesai = $mulai->copy()->addMinutes($durasiMenit);
    
        if ($request->sesi == '1') {
            $batasAwal = Carbon::createFromTime(8, 0);
            $batasAkhir = Carbon::createFromTime(17, 10);
        } else {
            $batasAwal = Carbon::createFromTime(18, 0);
            $batasAkhir = Carbon::createFromTime(22, 0);
        }

        if ($mulai->lt($batasAwal)) {
            return back()->withErrors([
                'jam' => 'Jam mulai tidak sesuai sesi'
            ])->withInput();
        }

        if ($selesai->gt($batasAkhir)) {
            return back()->withErrors([
                'jam' => 'Durasi mata kuliah melebihi batas sesi'
            ])->withInput();
        }

    $prodiLogin = auth()->user()->dosen->prodi;

    $bentrok = Penawaran::where('hari', $request->hari)
        ->where('recno', '!=', $penawaran->recno)
        ->whereHas('dosenRelasi', function ($q) use ($prodiLogin) {
            $q->where('prodi', $prodiLogin);
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
                'jam' => 'Jadwal bentrok dengan jadwal lain'
            ])->withInput();
        }

        $penawaran->update([
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
            ->route('penawaran.index')
            ->with('success', 'Penawaran berhasil diperbarui');
    }

    public function destroy(Penawaran $penawaran)
{
    try {
        $penawaran->delete();

        return redirect()
            ->route('penawaran.index')
            ->with('success', 'Penawaran berhasil dihapus');
    } catch (\Exception $e) {

        return back()->withErrors([
            'delete' => 'Gagal menghapus penawaran: ' . $e->getMessage()
        ]);
    }
}
}