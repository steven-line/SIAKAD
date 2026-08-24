<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $periodes = Periode::paginate(10);

        return view('admin.periode.index', [
            'periodes' => $periodes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.periode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'tahun_mulai' => [
            'required',
            'integer',
            'min:2000',
            'max:2100',
        ],

        'tanggal_mulai' => [
            'required',
            Rule::date()->format('Y-m-d'),
        ],

        'tanggal_selesai' => [
            'required',
            Rule::date()->format('Y-m-d'),
            'after:tanggal_mulai',
        ],
    ]);

    // ==========================================================
    // TAHUN AJARAN
    // Tahun selesai otomatis = tahun mulai + 1
    // Contoh: 2026 -> 2027
    // Hasil: 2026/2027
    // ==========================================================

    $tahunMulai = (int) $request->tahun_mulai;
    $tahunSelesai = $tahunMulai + 1;

    $tahunAjaran = $tahunMulai . '/' . $tahunSelesai;


    // ==========================================================
    // SIMPAN PERIODE
    // ==========================================================

    $periode = Periode::create([
        'tahun_ajaran' => $tahunAjaran,
        'aktif' => false,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
    ]);


    // ==========================================================
    // BUAT SEMESTER OTOMATIS
    // ==========================================================

    $dataSemester = [];

    // Semester Ganjil
    foreach ([1, 3, 5, 7] as $smt) {

        $dataSemester[] = [
            'periode_id' => $periode->id,
            'nama' => (string) $smt,
            'jenis' => 'Ganjil',
            'aktif' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Semester Genap
    foreach ([2, 4, 6, 8] as $smt) {

        $dataSemester[] = [
            'periode_id' => $periode->id,
            'nama' => (string) $smt,
            'jenis' => 'Genap',
            'aktif' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


    // Simpan seluruh semester
    Semester::insert($dataSemester);


    // ==========================================================
    // KEMBALI KE INDEX
    // ==========================================================

    return redirect()
        ->route('periode.index')
        ->with('success', 'Periode berhasil dibuat.');
}

    /**
     * Display the specified resource.
     */
    public function show(Periode $periode)
    {
        return view('admin.periode.show', ['periode' => $periode]);
    }

    /**
     * Show the form for editing the specified resource.
     */
 

    /**
     * Remove the specified resource from storage.
     */
    public function aktifkanSemester(Periode $periode, $jenis)
    {
        $jenis = ucfirst(strtolower($jenis));

        if (!in_array($jenis, ['Ganjil', 'Genap'])) {
            abort(404);
        }

        DB::transaction(function () use ($periode, $jenis) {

            // 🔴 1. Nonaktifkan semua semester di periode ini
            $periode->semesters()->update([
                'aktif' => false
            ]);

            // 🟢 2. Aktifkan semester yang dipilih
            $periode->semesters()
                ->where('jenis', $jenis)
                ->update([
                    'aktif' => true
                ]);

            // 🔥 3. RESET STATUS MAHASISWA
            Mahasiswa::query()->update([
                'status_blokir' => 'BELUM_KRS'
            ]);
        });

        return back()->with('success', "Semester {$jenis} aktif & status mahasiswa direset");
    }

    public function periodeAktif(Periode $periode) {
        $periodelama = Periode::where('aktif', 1)->first();
        if ($periodelama) {
            $periodelama->semesters()->update(['aktif' => false]);
        }
        
        Periode::query()->update([
            'aktif' => false
        ]);

        // 2. Aktifkan periode yang dipilih
        $periode->update([
            'aktif' => true
        ]);
       
        return redirect()->route('periode.index')->with('success', 'Periode diaktifkan');
    
    }
 
    public function destroy(Periode $periode)
    {
        $periode->delete();

        return redirect()
            ->route('periode.index')
            ->with('success', 'Periode berhasil dihapus.');
    }
    
}
