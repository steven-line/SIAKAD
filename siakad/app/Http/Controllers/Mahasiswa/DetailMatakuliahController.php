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
    
    $periodeKrs = Metaperiode::first();
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
  
    return view('mahasiswa.penawaran.show', compact('registrasis', 'penawaran', 'sudahAmbil', 'statusBlokir','periodeKrs'));
}
    public function daftar(Penawaran $penawaran)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;  
        $sksMahasiswa = Registrasi::join('krs', 'registrasi.regkrs', '=', 'krs.registrasi_id')
                                ->leftJoin('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                                ->leftJoin('mk', 'penawaran.kodemk', '=', 'mk.kodemk')
                                ->select('mk.sks')
                                ->where('nrp', $user->mahasiswa->nrp)
                                ->get();

        $periodeKrs = Metaperiode::first();
        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        if (now()->lt($periodeKrs->krs_mulai) || now()->gt($periodeKrs->krs_selesai)) {
            return redirect()->back()->with('error', 'Pendaftaran gagal! Anda berada di luar periode KRS.');
        }
        if ($mahasiswa->status_blokir === 'TERKUNCI') {
            return back()->with('error', 'KRS Anda terkunci. Tidak dapat mengambil mata kuliah.');
        }

        $sudah = Registrasi::where('nrp', $mahasiswa->nrp)
            ->where('penawaran_id', $penawaran->recno)
            ->exists();

            $mk = $penawaran->mk;
            

            if ($mk) {

                $prasyarat = [];

                for ($i = 1; $i <= 10; $i++) {

                    $kode = trim((string) ($mk->{'prasyarat'.$i} ?? ''));

                    // abaikan "-", kosong, NULL
                    if ($kode === '' || $kode === '-' || strtoupper($kode) === 'NULL') {
                        continue;
                    }

                    $prasyarat[] = $kode;
                }

                // Hanya cek bila memang ada prasyarat
                if (!empty($prasyarat)) {

                    foreach ($prasyarat as $kodeMk) {

                        $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
                            ->whereHas('penawaran', function ($q) use ($kodeMk) {
                                $q->where('kodemk', $kodeMk);
                            })
                            ->first();

                        if (!$registrasi) {
                            return back()->with(
                                'error',
                                "Anda belum mengambil mata kuliah prasyarat {$mk->nama}."
                            );
                        }

                        $lulus = Krs::where('registrasi_id', $registrasi->regkrs)
                            ->whereIn('na', ['A', 'AB', 'B', 'BC', 'C'])
                            ->exists();

                        if (!$lulus) {
                            return back()->with(
                                'error',
                                "Anda belum lulus mata kuliah prasyarat {$kodeMk}."
                            );
                        }
                    }
                }
            }

        if ($sudah) {
            return back()->with('error', 'Sudah mengambil mata kuliah ini.');
        }

        // 1. MULAI TRANSAKSI DATABASE
        DB::beginTransaction();

        try {
            // Data dibuat di dalam lingkup transaksi (belum permanen)
            Registrasi::create([
                'nrp' => $mahasiswa->nrp,
                'penawaran_id' => $penawaran->recno,
                'status' => 'B',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
            ]);
            $periodeAktif = Periode::where('aktif', 1)->first();
            $jenisSemester = $periodeAktif->semesters()->where('aktif', 1)->pluck('jenis')->first();
    
            $registrasiMK = DB::table('registrasi')
                ->join('penawaran', 'registrasi.penawaran_id', '=', 'penawaran.recno')
                ->join('semester', 'penawaran.semester_id', '=', 'semester.id')
                ->join('mk' ,'penawaran.kodemk', '=', 'mk.kodemk')
                ->join('periode', 'semester.periode_id', '=', 'periode.id')
                ->where('periode.aktif', '=', 1)
                ->where('semester.jenis', '=', $jenisSemester)
                ->where('registrasi.nrp', $mahasiswa->nrp)
                ->select('mk.sks')
                ->get();    

     
            // 2. JIKA SKS MELEBIHI LIMIT, BATALKAN (ROLLBACK)
            if ($registrasiMK->sum('sks') > $mahasiswa->ips->maksimal_sks) {
                DB::rollBack(); // Data Registrasi::create tadi otomatis dihapus kembali
                dd($registrasiMK);
                return back()->withErrors(['limit_sks' => 'Pendaftaran gagal! Total SKS melampaui limit Anda.']);
            }
            if ($sksMahasiswa->sum('sks') < $penawaran->mk->prasyaratsks) {
                  DB::rollBack(); // Data Registrasi::create tadi otomatis dihapus kembali
                    
                  $prasyaratSKSMK = $penawaran->mk->prasyaratsks;
                  $selisihSKS = $prasyaratSKSMK - $sksMahasiswa->sum('sks');
                  
                  return back()->withErrors(['prasyarat_sks' => "Pendaftaran gagal!  Anda belum memenuhi Prasyarat SKS $prasyaratSKSMK, Anda masih kurang $selisihSKS"]);
            }
            // 3. JIKA AMAN, SIMPAN PERMANEN
            DB::commit();

            return redirect()
                ->route('mahasiswa.krs.index')
                ->with('success', 'Berhasil mengambil KRS.');

        } catch (\Exception $e) {
            // 4. ROLLBACK JIKA TERJADI ERROR SISTEM
            DB::rollBack();
            Log::error('Gagal daftar KRS: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
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
