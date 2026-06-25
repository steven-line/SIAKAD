<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Mk;
use App\Models\Dosen;
use App\Models\prodi;
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
        $matkuls = Mk::orderBy('kodemk')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $prodis = prodi::orderBy('kode_prodi')->get();

        /**
         * FIX UTAMA:
         * HAPUS ->with('periode') karena relasi sudah tidak ada
         */
        $semesters = Semester::orderByDesc('aktif')->get();

        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view(
            'kaprodi.penawaran.create',
            compact(
                'matkuls',
                'dosens',
                'prodis',
                'semesters',
                'jamSlotsPagi',
                'jamSlotsMalam'
            )
        );
    }

    public function index()
    {
        $penawarans = Penawaran::paginate(15);
        return view('kaprodi.penawaran.index', ['penawarans' => $penawarans]);
    }

    public function show($recno)
    {
        $penawaran = Penawaran::with([
            'mk',
            'dosenRelasi',
            'prodiRelasi'
        ])->findOrFail($recno);

        return view('kaprodi.penawaran.show', compact('penawaran'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'kodemk'     => 'required',
            'semester_id' => 'required|exists:semester,id',
            'dosen'      => 'required',
            'hari'       => 'required',
            'mulaipukul' => 'required',
            'prodi' => 'required|exists:prodi,kode_prodi',
            'pataum'     => 'required',
            'sesi'       => 'required',
            'pagu' => 'required|integer|between:1,99',
            'keterangan' => 'nullable',
        ]);
        

        $mk = Mk::where('kodemk', $request->kodemk)->firstOrFail();

        $durasiMenit = ((int) $mk->sks) * 50;

        $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
        $selesai = $mulai->copy()->addMinutes($durasiMenit);

        $kodeprodi = $request->input('prodi');        
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

        $bentrok = Penawaran::where('hari', $request->hari)
            ->where('prodi', $kodeprodi)
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

        Penawaran::create([
            'kodemk'       => $request->kodemk,
            'semester_id'  => $request->semester_id,
            'dosen'        => $request->dosen,
            'hari'         => $request->hari,
            'mulaipukul'   => $mulai->format('H:i:s'),
            'selesaipukul' => $selesai->format('H:i:s'),
            'pataum'       => $request->pataum,
            'prodi'        =>  $kodeprodi,            
            'sesi'         => $request->sesi,
            'keterangan'   => $request->keterangan,
            'pagu'         => $request->pagu,
            'MBKM'         => $request->has('MBKM'),
        ]);

        return redirect()
            ->route('penawaran.index')
            ->with('success', 'Penawaran berhasil ditambahkan');
    }

    public function edit(Penawaran $penawaran)
    {
        $matkuls = Mk::orderBy('kodemk')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $prodis = prodi::orderBy('kode_prodi')->get();

        /**
         * FIX UTAMA:
         * HAPUS ->with('periode')
         */
        $semesters = Semester::orderByDesc('aktif')->get();

        $jamSlotsPagi = $this->generateJamSlotsPagi();
        $jamSlotsMalam = $this->generateJamSlotsMalam();

        return view(
            'kaprodi.penawaran.edit',
            compact(
                'penawaran',
                'matkuls',
                'dosens',
                'prodis',
                'semesters',
                'jamSlotsPagi',
                'jamSlotsMalam'
            )
        );
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        $request->validate([
            'kodemk'     => 'required',
            'semester_id' => 'required|exists:semester,id',
            'dosen'      => 'required',
            'hari'       => 'required',
            'mulaipukul' => 'required',
            'prodi' => 'required|exists:prodi,kode_prodi',
            'pataum'     => 'required',
            'sesi'       => 'required',
            'pagu' => 'required|integer|between:1,99',
            'keterangan' => 'nullable',
        ]);

        $mk = Mk::where('kodemk', $request->kodemk)->firstOrFail();

        $durasiMenit = ((int) $mk->sks) * 50;

        $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
        $selesai = $mulai->copy()->addMinutes($durasiMenit);

        $kodeprodi = $request->input('prodi');        
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

        $bentrok = Penawaran::where('hari', $request->hari)
            ->where('prodi', $kodeprodi)
            ->where('recno', '!=', $penawaran->recno)
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
            'prodi'      => $kodeprodi,
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