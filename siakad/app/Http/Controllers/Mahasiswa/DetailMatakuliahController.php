<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Periode;
use App\Models\Mahasiswa;
use App\Models\Metaperiode;
use App\Models\Krs;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailMataKuliahController extends Controller
{
    public function show(Penawaran $penawaran)
    {
        // ============================================================
        // 1. DAPATKAN PATAUM USER & SEMESTER AKTIF
  
    $registrasis = Registrasi::where('penawaran_id', $penawaran->recno)->get();
      $sudahAmbil = Registrasi::where('nrp', Auth::user()->mahasiswa->nrp)
    ->where('penawaran_id', $penawaran->recno)
    ->exists();
    
    $metaperiode = Metaperiode::first();
    if ($metaperiode) {
         $periodeKrs = now()->between($metaperiode->krs_mulai, $metaperiode->krs_selesai);
    
    } else {
        $periodeKrs = null;
    }
   
    $statusBlokir = Auth::user()->mahasiswa->status_blokir;

    // ============================================================
    // CEK PRASYARAT MATA KULIAH
    // ============================================================

    $penawaran->boleh_diambil = true;
    $penawaran->pesan_prasyarat = '';

    $mk = $penawaran->mk;
    
    
    if ($mk) {

        $prasyarat = [];

        for ($i = 1; $i <= 10; $i++) {

            $kode = trim((string) $mk->{'prasyarat' . $i});

            if (
                $kode !== '' &&
                $kode !== '-' &&
                strtoupper($kode) !== 'NULL'
            ) {
                $prasyarat[] = $kode;
            }
        }

        // Tidak ada prasyarat
        if (count($prasyarat) == 0) {

            $penawaran->boleh_diambil = true;
            $penawaran->pesan_prasyarat = '';

        } else {

            // Ada prasyarat, cek satu per satu
            
            foreach ($prasyarat as $kodeMk) {
                
                $registrasi = Registrasi::where('nrp', Auth::user()->mahasiswa->nrp)
                    ->whereHas('penawaran', function ($q) use ($kodeMk) {
                        $q->where('kodemk', $kodeMk);
                    })
                    ->first();
                
                if (!$registrasi) {

                    $penawaran->boleh_diambil = false;
                    $penawaran->pesan_prasyarat =
                        'Anda belum mengambil mata kuliah prasyarat ' . $kodeMk. '.';

                    break;
                }

                $lulus = Krs::where('registrasi_id', $registrasi->regkrs)
                    ->whereIn('na', ['A', 'AB', 'B', 'BC', 'C'])
                    ->exists();

                if (!$lulus) {

                    $penawaran->boleh_diambil = false;
                    $penawaran->pesan_prasyarat =
                        'Anda belum lulus mata kuliah prasyarat ' . $kodeMk . '.';

                    break;
                }
            }
        }
    }
  
    return view('mahasiswa.penawaran.show', compact('registrasis', 'penawaran', 'sudahAmbil', 'statusBlokir','periodeKrs'))->with('jadwalBentrok', false);
    }

    public function daftar(Penawaran $penawaran)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;  

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $ipsMahasiswa = $mahasiswa->ips;

        $limitSks = ($ipsMahasiswa?->maksimal_sks ?? 19)
                + ($ipsMahasiswa?->toleransi ?? 0);

        $periodeKrs = Metaperiode::first();

        if (!$periodeKrs) { // FIX
            return back()->with('error', 'Periode KRS belum disetting.');
        }

        if (now()->lt($periodeKrs->krs_mulai) || now()->gt($periodeKrs->krs_selesai)) {
            return back()->with('error', 'Pendaftaran gagal! Anda berada di luar periode KRS.');
        }

        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci.');
        }

        // ===============================
        // CEK SUDAH AMBIL
        // ===============================
        $sudah = Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->exists();

        if ($sudah) {
            return back()->with('error', 'Sudah mengambil mata kuliah ini.');
        }

        // ============================================================
        // CEK BENTROK JADWAL
        // ============================================================

        $periodeAktif = Periode::where('aktif', 1)->first();
        $jenisSemester = $periodeAktif?->semesters()->where('aktif', 1)->value('jenis');

        $jadwalBentrok = DB::table('registrasi')
            ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->join('semester', 'penawaran.semester_id', '=', 'semester.id')
            ->join('periode', 'semester.periode_id', '=', 'periode.id')
            ->where('registrasi.nrp', $mahasiswa->nrp)
            ->where('periode.aktif', 1)
            ->where('semester.jenis', $jenisSemester)
            ->where('penawaran.hari', $penawaran->hari)
            ->where(function ($q) use ($penawaran) {
                $q->whereBetween('penawaran.mulaipukul', [
                        $penawaran->mulaipukul,
                        $penawaran->selesaipukul
                    ])
                ->orWhereBetween('penawaran.selesaipukul', [
                        $penawaran->mulaipukul,
                        $penawaran->selesaipukul
                    ])
                ->orWhere(function ($q2) use ($penawaran) {
                        $q2->where('penawaran.mulaipukul', '<=', $penawaran->mulaipukul)
                        ->where('penawaran.selesaipukul', '>=', $penawaran->selesaipukul);
                    });
            })
            ->exists();

        if ($jadwalBentrok) {
            return back()->with('error', 'Pendaftaran gagal! Jadwal mata kuliah bentrok dengan yang sudah diambil.');
        }

        // ===============================
        // CEK PRASYARAT
        // ===============================
        $mk = $penawaran->mk;

        if (!$mk) { // FIX
            return back()->with('error', 'Data mata kuliah tidak ditemukan.');
        }

        $prasyarat = [];

        for ($i = 1; $i <= 10; $i++) {
            $kode = trim((string) ($mk->{'prasyarat'.$i} ?? ''));

            if ($kode === '' || $kode === '-' || strtoupper($kode) === 'NULL') {
                continue;
            }

            $prasyarat[] = $kode;
        }

        foreach ($prasyarat as $kodeMk) {

            $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
                ->whereHas('penawaran', function ($q) use ($kodeMk) {
                    $q->where('kodemk', $kodeMk);
                })
                ->first();

            if (!$registrasi) {
                return back()->with('error', "Anda belum mengambil mata kuliah prasyarat {$kodeMk}.");
            }

            $lulus = Krs::where('registrasi_id', $registrasi->regkrs)
                ->whereIn('na', ['A', 'AB', 'B', 'BC', 'C'])
                ->exists();

            if (!$lulus) {
                return back()->with('error', "Anda belum lulus mata kuliah prasyarat {$kodeMk}.");
            }
        }

        // ===============================
        // TRANSAKSI
        // ===============================
        // ============================================================
        // CEK BENTROK JADWAL
        // ============================================================

        $periodeAktif = Periode::where('aktif', 1)->first();
        $jenisSemester = $periodeAktif?->semesters()->where('aktif', 1)->value('jenis');

        $jadwalBentrok = DB::table('registrasi')
            ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
            ->join('semester', 'penawaran.semester_id', '=', 'semester.id')
            ->join('periode', 'semester.periode_id', '=', 'periode.id')
            ->where('registrasi.nrp', $mahasiswa->nrp)
            ->where('periode.aktif', 1)
            ->where('semester.jenis', $jenisSemester)
            ->where('penawaran.hari', $penawaran->hari)
            ->where(function ($q) use ($penawaran) {
                $q->whereBetween('penawaran.mulaipukul', [
                        $penawaran->mulaipukul,
                        $penawaran->selesaipukul
                    ])
                ->orWhereBetween('penawaran.selesaipukul', [
                        $penawaran->mulaipukul,
                        $penawaran->selesaipukul
                    ])
                ->orWhere(function ($q2) use ($penawaran) {
                        $q2->where('penawaran.mulaipukul', '<=', $penawaran->mulaipukul)
                        ->where('penawaran.selesaipukul', '>=', $penawaran->selesaipukul);
                    });
            })
            ->exists();

        if ($jadwalBentrok) {
            return back()->withErrors([
                'jadwal' => 'Pendaftaran gagal! Jadwal mata kuliah bentrok dengan yang sudah diambil.'
            ]);
        }
        DB::beginTransaction();

        try {

            Registrasi::create([
                'nrp' => $mahasiswa->nrp,
                'penawaran_id' => $penawaran->recno,
                'status' => 'B',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
            ]);

            // ===============================
            // AMBIL PERIODE & SEMESTER AKTIF
            // ===============================
            $periodeAktif = Periode::where('aktif', 1)->first();

            if (!$periodeAktif) { // FIX
                DB::rollBack();
                return back()->with('error', 'Tidak ada periode aktif.');
            }

            $semesterAktif = $periodeAktif->semesters()
                ->where('aktif', 1)
                ->first(); // FIX (jangan pluck string)

            if (!$semesterAktif) { // FIX
                DB::rollBack();
                return back()->with('error', 'Tidak ada semester aktif.');
            }

            // ===============================
            // HITUNG TOTAL SKS
            // ===============================
            $totalSks = DB::table('registrasi')
                ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                ->join('semester', 'penawaran.semester_id', '=', 'semester.id')
                ->join('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
                ->join('periode', 'semester.periode_id', '=', 'periode.id')
                ->where('periode.id', $periodeAktif->id) // FIX lebih aman
                ->where('semester.id', $semesterAktif->id) // FIX
                ->where('registrasi.nrp', $mahasiswa->nrp)
                ->sum('mk.sks'); // FIX langsung sum

            // ===============================
            // VALIDASI SKS
            // ===============================
            if ($totalSks > $limitSks) {
                DB::rollBack();

                return back()->withErrors([
                    'limit_sks' => "Pendaftaran gagal! Total SKS melampaui batas {$limitSks} SKS."
                ]);
            }

            // ===============================
            // CEK PRASYARAT SKS MK
            // ===============================
            if ($limitSks < ($mk->prasyaratsks ?? 0)) {
                DB::rollBack();

                $butuh = $mk->prasyaratsks ?? 0;
                $kurang = $butuh - $limitSks;

                return back()->withErrors([
                    'prasyarat_sks' => "Pendaftaran gagal! Minimal SKS {$butuh}, kurang {$kurang}."
                ]);
            }

            DB::commit();

            return redirect()
                ->route('mahasiswa.krs.index')
                ->with('success', 'Berhasil mengambil KRS.');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal daftar KRS: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function batal(Penawaran $penawaran)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci.');
        }

        Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->delete();

        return back()->with('success', 'Berhasil membatalkan KRS.');
    }
}
