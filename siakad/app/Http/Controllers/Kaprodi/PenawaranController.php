<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Mk;
use App\Models\Dosen;
use App\Models\Metaperiode;
use App\Models\prodi;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Penawaran;
use App\Models\Pjmk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


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


    /**
     * FORM INPUT
     */
    public function create()
{
    $metaPeriode = Metaperiode::first();

    // Cek periode input penawaran
    if (
        !$metaPeriode && !$metaPeriode->input_penawaran_mulai &&
        !$metaPeriode->input_penawaran_selesai &&
        !now()->between($metaPeriode->input_penawaran_mulai, $metaPeriode->input_penawaran_selesai)
    ) {
        return redirect()
            ->route('penawaran.index')
            ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
    }

    $user = auth()->user();

    // Tidak lagi menampilkan MK Universitas (A)
    $akses = [];

    if ($user && $user->dosen) {

        switch ($user->dosen->prodi) {

            case 'C': // Manajemen
                $akses = ['B', 'C'];
                break;

            case 'D': // Akuntansi
                $akses = ['B', 'D'];
                break;

            case 'F': // Teknik Sipil
                $akses = ['E', 'F'];
                break;

            case 'G': // Arsitektur
                $akses = ['E', 'G'];
                break;

            case 'H': // Teknik Elektro
                $akses = ['E', 'H'];
                break;

            case 'I': // Teknik Informatika
                $akses = ['E', 'I'];
                break;

            case 'K': // Sastra Inggris
                $akses = ['J', 'K'];
                break;

            case 'L': // Pendidikan Bahasa Mandarin
                $akses = ['J', 'L'];
                break;
        }
    }

    $matkuls = Mk::where(function ($query) use ($akses) {
            foreach ($akses as $prefix) {
                $query->orWhere('kodemk', 'like', $prefix . '%');
            }
        })
        ->orderBy('nama')
        ->get();

    $dosens = Dosen::orderBy('nama')->where('prodi', $user->dosen->prodi)->get();

    $semesters = Semester::with('periode')
        ->whereHas('periode', function ($query) {
            $query->where('aktif', 1);
        })
        ->where('semester.aktif', 1)
        ->get();

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
    $user = auth()->user();
    $akses = ['A']; // default hanya MK Universitas
    
    if ($user && $user->dosen) {
        switch ($user->dosen->prodi) {
            case 'C': // Manajemen
                $akses = ['A', 'B', 'C'];
                break;

            case 'D': // Akuntansi
                $akses = ['A', 'B', 'D'];
                break;

            case 'F': // Teknik Sipil
                $akses = ['A', 'E', 'F'];
                break;

            case 'G': // Arsitektur
                $akses = ['A', 'E', 'G'];
                break;

            case 'H': // Teknik Elektro
                $akses = ['A', 'E', 'H'];
                break;

            case 'I': // Teknik Informatika
                $akses = ['A', 'E', 'I'];
                break;

            case 'K': // Sastra Inggris
                $akses = ['A', 'J', 'K'];
                break;

            case 'L': // Pendidikan Bahasa Mandarin
                $akses = ['A', 'J', 'L'];
                break;
        }
    }

    $query = Penawaran::with([
        'mk',
        'dosenRelasi',
        'semesterRelasi.periode',
    ])
    ->whereHas('mk', function ($q) use ($akses) {
        $q->where(function ($sub) use ($akses) {
            foreach ($akses as $prefix) {
                $sub->orWhere('kodemk', 'like', $prefix . '%');
            }
        });
    })

    ->whereHas('semesterRelasi', function ($q) {
    $q->where('aktif', 1)
      ->whereHas('periode', function ($p) {
          $p->where('aktif', 1);
      });
    });

    $penawarans = $query
        ->orderBy('hari')
        ->paginate(10);
    $metaPeriode = Metaperiode::first();
    $bolehInput = $metaPeriode && $metaPeriode->input_penawaran_mulai && $metaPeriode->input_penawaran_selesai && now()->between(
                        $metaPeriode->input_penawaran_mulai,
                        $metaPeriode->input_penawaran_selesai
                    );
    return view('kaprodi.penawaran.index', compact('penawarans', 'bolehInput'));
}

   public function store(Request $request)
{

    $metaPeriode = Metaperiode::first();

    if (
        !$metaPeriode && !$metaPeriode->input_penawaran_mulai && !$metaPeriode->input_penawaran_selesai
        && !now()->between($metaPeriode->input_penawaran_mulai, $metaPeriode->input_penawaran_selesai)
    ) {
        return redirect()
            ->route('penawaran.index')
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

    // Mata kuliah
    $mk = Mk::where('kodemk', $request->kodemk)->firstOrFail();

    $durasiMenit = $mk->sks * 50;

    $mulai = Carbon::createFromFormat('H:i', $request->mulaipukul);
    $selesai = $mulai->copy()->addMinutes($durasiMenit);

    // Prodi Kaprodi yang login
    $mk = Mk::with('kurikulum')->where('kodemk', $request->kodemk)->firstOrFail();

    $kodeProdi = $mk->kurikulum->kode_prodi;

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
   $akses = ['A'];
   $user = Auth::user();
    if ($user && $user->dosen) {

        switch ($user->dosen->prodi) {

            case 'C':
                $akses = ['A','B','C'];
                break;

            case 'D':
                $akses = ['A','B','D'];
                break;

            case 'F':
                $akses = ['A','E','F'];
                break;

            case 'G':
                $akses = ['A','E','G'];
                break;

            case 'H':
                $akses = ['A','E','H'];
                break;

            case 'I':
                $akses = ['A','E','I'];
                break;

            case 'K':
                $akses = ['A','J','K'];
                break;

            case 'L':
                $akses = ['A','J','L'];
                break;
        }
    }
$bentrok = Penawaran::where('semester_id', $request->semester_id)
    ->where('hari', $request->hari)
    ->whereHas('mk', function (Builder $query) use ($akses) {
        foreach ($akses as $char) {
            $query->orWhere('kodemk', 'LIKE', $char . '%');
        }
    })
    ->where(function ($query) use ($mulai, $selesai) {
        $query->whereBetween('mulaipukul', [
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
    $user = Auth::user();
    $metaPeriode = Metaperiode::first();

    if (
        !$metaPeriode &&
        !now()->between($metaPeriode->input_penawaran_mulai, $metaPeriode->input_penawaran_selesai)
    ) {
        return redirect()
            ->route('penawaran.index')
            ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
    }   

   

    $akses = ['A'];

    if ($user && $user->dosen) {

        switch ($user->dosen->prodi) {

            case 'C':
                $akses = ['A','B','C'];
                break;

            case 'D':
                $akses = ['A','B','D'];
                break;

            case 'F':
                $akses = ['A','E','F'];
                break;

            case 'G':
                $akses = ['A','E','G'];
                break;

            case 'H':
                $akses = ['A','E','H'];
                break;

            case 'I':
                $akses = ['A','E','I'];
                break;

            case 'K':
                $akses = ['A','J','K'];
                break;

            case 'L':
                $akses = ['A','J','L'];
                break;
        }
    }

    $penawaran = Penawaran::with([
        'mk.kurikulum',
        'dosenRelasi',
        'semesterRelasi.periode',
    ])->where('recno', $recno)->firstOrFail();

    if (str_starts_with($penawaran->kodemk, 'A')) {
    return redirect()
        ->route('penawaran.index')
        ->with('error', 'Penawaran umum hanya dapat dikelola oleh Admin.');
}

    $matkuls = Mk::where(function ($query) use ($akses) {
            foreach ($akses as $prefix) {
                $query->orWhere('kodemk', 'like', $prefix.'%');
            }
        })
        ->orderBy('nama')
        ->get();
        
    $dosens = Dosen::orderBy('nama')->get();

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

    if (str_starts_with($penawaran->kodemk, 'A')) {
    return redirect()
        ->route('penawaran.index')
        ->with('error', 'Penawaran umum hanya dapat dikelola oleh Admin.');
}
     $user = Auth::user();
    $metaPeriode = Metaperiode::first();

    if (
        !$metaPeriode &&
        !now()->between($metaPeriode->input_penawaran_mulai, $metaPeriode->input_penawaran_selesai)
    ) {
        return redirect()
            ->route('penawaran.index')
            ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
    }
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

        $mk = Mk::with('kurikulum')
            ->where('kodemk', $request->kodemk)
            ->firstOrFail();

        $durasiMenit = ((int) $mk->sks) * 50;

        // Ambil prodi pemilik mata kuliah
        $kodeProdi = $mk->kurikulum->kode_prodi;

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
        
    $akses = ['A'];

    if ($user && $user->dosen) {

        switch ($user->dosen->prodi) {

            case 'C':
                $akses = ['A','B','C'];
                break;

            case 'D':
                $akses = ['A','B','D'];
                break;

            case 'F':
                $akses = ['A','E','F'];
                break;

            case 'G':
                $akses = ['A','E','G'];
                break;

            case 'H':
                $akses = ['A','E','H'];
                break;

            case 'I':
                $akses = ['A','E','I'];
                break;

            case 'K':
                $akses = ['A','J','K'];
                break;

            case 'L':
                $akses = ['A','J','L'];
                break;
        }
    }
$bentrok = Penawaran::where('recno', '!=', $penawaran->recno)
    ->where('semester_id', $request->semester_id)
    ->where('hari', $request->hari)
    ->whereHas('mk', function (Builder $query) use ($akses) {
        foreach ($akses as $char) {
            $query->orWhere('kodemk', 'LIKE', $char . '%');
        }
    })
    ->where(function ($query) use ($mulai, $selesai) {
        $query->whereBetween('mulaipukul', [
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
            'jam' => 'Jadwal bentrok. Mata kuliah, dosen, atau semester sudah memiliki jadwal pada waktu tersebut.'
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

    if (str_starts_with($penawaran->kodemk, 'A')) {
        return redirect()
            ->route('penawaran.index')
            ->with('error', 'Penawaran umum hanya dapat dikelola oleh Admin.');
    }

    $metaPeriode = Metaperiode::first();

        // Cek periode input penawaran
        if (
            !$metaPeriode && !$metaPeriode->input_penawaran_mulai &&
            !$metaPeriode->input_penawaran_selesai &&
            !now()->between($metaPeriode->input_penawaran_mulai, $metaPeriode->input_penawaran_selesai)
        ) {
            return redirect()
                ->route('penawaran.index')
                ->with('error', 'Periode input penawaran belum dibuka atau sudah berakhir.');
        }

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