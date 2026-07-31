<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use App\Models\Penawaran;
use App\Models\Periode;
use App\Models\Ips;
use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsMahasiswaController extends Controller
{
    /**
     * Menampilkan daftar KRS mahasiswa yang sedang login
     */
    public function index()
    {
        $nrp = session('nrp') ?? Auth::user()->username;

        // Ambil periode & semester aktif
        $periodeAktif = Periode::where('aktif', 1)->first();
        $semesterAktif = $periodeAktif?->semesters()->where('aktif', 1)->first();

        if (!$semesterAktif) {
            return back()->with('error', 'Semester aktif tidak ditemukan');
        }

        // 🔥 FILTER DI SINI
        $registrasi = Registrasi::with(['penawaran.mk'])
            ->where('nrp', $nrp)
            ->whereHas('penawaran', function ($q) use ($periodeAktif) {
                $q->whereHas('semester', function ($s) use ($periodeAktif) {
                    $s->where('periode_id', $periodeAktif->id);
                });
            })
            ->get();

        // Mapping data
        $krsItems = $registrasi->map(function ($reg) {
            $penawaran = $reg->penawaran;
            return (object) [
                'id'            => $reg->regkrs,
                'recno'         => $penawaran->recno ?? null, // 🔥 TAMBAHKAN INI
                'kode_mk'       => $penawaran ? $penawaran->kodemk : '-',
                'nama_mk'       => $penawaran && $penawaran->mk ? $penawaran->mk->nama : '-',
                'status'        => $reg->status ?? 'BARU',
                'hari'          => $reg->penawaran->hari ?? '-',
                'jam_mulai'     => $reg->penawaran->mulaipukul ? date('H:i', strtotime($reg->penawaran->mulaipukul)) : '-',
                'jam_selesai'   => $reg->penawaran->selesaipukul ? date('H:i', strtotime($reg->penawaran->selesaipukul)) : '-',
                'sks'           => $reg->penawaran->mk->sks ?? 0,
            ];
        });

        $totalSks = $krsItems->sum('sks');

        $mahasiswa = Mahasiswa::with(['dosenWali', 'prodi'])->where('nrp', $nrp)->first();

        $statusBlokir = $mahasiswa?->status_blokir ?? 'BELUM_KRS';
        $ipsMahasiswa = Ips::where('nrp', $nrp)->first();

        $ipsTerakhir  = $ipsMahasiswa?->ips ?? 0;
        $limitSks     = $ipsMahasiswa?->maksimal_sks ?? 21;
        $toleransiSks = $ipsMahasiswa?->toleransi ?? 0;

        // Maksimal SKS yang boleh diambil termasuk toleransi
        $batasSks = $limitSks + $toleransiSks;

        $sisaLimit = $batasSks - $totalSks;

        return view('mahasiswa.kartu_KRS.index', compact(
            'krsItems',
            'totalSks',
            'ipsTerakhir',
            'limitSks',
            'toleransiSks',
            'sisaLimit',
            'statusBlokir',
            'nrp',
            'mahasiswa',
        ));
    }

    /**
     * Menyimpan registrasi mata kuliah baru (tambah KRS)
     */
    public function store(Request $request)
    {
        // CEK STATUS BLOKIR MAHASISWA
        $nrp = session('nrp') ?? Auth::user()->username;
        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();

        if ($mahasiswa && $mahasiswa->status_blokir !== 'BELUM_KRS') {
            return redirect()->back()->with('error', 'Anda tidak dapat mendaftar mata kuliah karena status KRS sudah tidak dalam status BELUM_KRS.');
        }

        // VALIDASI
        $request->validate([
            'penawaran_id' => 'required|exists:penawaran,recno',
        ]);

        $penawaran = Penawaran::with('mk')->find($request->penawaran_id);

        if (!$penawaran) {
            return redirect()->back()->with('error', 'Data penawaran tidak ditemukan.');
        }

        // ======================================================
        // CEK PRASYARAT MATA KULIAH
        // ======================================================

        $mk = $penawaran->mk;

        $daftarPrasyarat = collect([
            $mk->prasyarat1,
            $mk->prasyarat2,
            $mk->prasyarat3,
            $mk->prasyarat4,
            $mk->prasyarat5,
            $mk->prasyarat6,
            $mk->prasyarat7,
            $mk->prasyarat8,
            $mk->prasyarat9,
            $mk->prasyarat10,
        ])->filter();

        foreach ($daftarPrasyarat as $kodePrasyarat) {

            $lulus = Krs::whereHas('registrasi', function ($q) use ($nrp) {
                    $q->where('nrp', $nrp);
                })
                ->whereHas('registrasi.penawaran', function ($q) use ($kodePrasyarat) {
                    $q->where('kodemk', $kodePrasyarat);
                })
                ->where(function ($q) use ($mk) {

                    if (!empty($mk->prasyaratgrade)) {
                        $q->where('na', $mk->prasyaratgrade);
                    } else {
                        $q->whereIn('na', ['A','AB','B','BC','C']);
                    }

                })
                ->exists();

            if (!$lulus) {

                return redirect()->back()->with(
                    'error',
                    'Anda belum memenuhi prasyarat mata kuliah ' . $kodePrasyarat . '.'
                );

            }
        }

        // Cek apakah sudah terdaftar
        $sudah = Registrasi::where('nrp', $nrp)
                    ->where('penawaran_id', $penawaran->recno)
                    ->exists();

        if ($sudah) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar mata kuliah ini.');
        }

        // Hitung total SKS yang sudah diambil pada semester yang sama
        $totalSksTerdaftar = Registrasi::where('nrp', $nrp)
                            ->whereHas('penawaran', function ($query) use ($penawaran) {
                                $query->where('semester_id', $penawaran->semester_id);
                            })
                            ->sum('sks');

        $sksMatkul = $penawaran->mk ? $penawaran->mk->sks : 3;

        // Ambil data IPS mahasiswa
        $ipsMahasiswa = Ips::where('nrp', $nrp)->first();

        $limitSks = $ipsMahasiswa?->maksimal_sks ?? 21;
        $toleransi = $ipsMahasiswa?->toleransi ?? 0;

        // Total SKS yang diizinkan
        $batasSks = $limitSks + $toleransi;

        if (($totalSksTerdaftar + $sksMatkul) > $batasSks) {

            return redirect()->back()->with(
                'error',
                'Pengambilan mata kuliah melebihi batas SKS. Maksimal yang dapat diambil adalah '
                . $batasSks .
                ' SKS ('
                . $limitSks .
                ' SKS + toleransi '
                . $toleransi .
                ' SKS).'
            );
        }

        // Simpan registrasi
        Registrasi::create([
            'nrp'           => $nrp,
            'penawaran_id'  => $penawaran->recno,
            'status'        => 'BARU',
            'sesi'          => $penawaran->sesi,
            'tanggal'       => now()->toDateString(),
            'jam'           => now()->toTimeString(),
            'validasi'      => 0,
            'hari'          => $penawaran->hari,
            'mulaipukul'    => $penawaran->mulaipukul,
            'selesaipukul'  => $penawaran->selesaipukul,
            'ip_address'    => $request->ip(),
            'sks'           => $sksMatkul,
            'pataum'        => $penawaran->pataum ?? 'P',
        ]);

        return redirect()->route('mahasiswa.krs.index')->with('success', 'Berhasil mendaftar mata kuliah.');
    }

    /**
     * Batalkan satu mata kuliah berdasarkan ID registrasi
     */
    public function destroy($id)
    {
        $nrp = session('nrp') ?? Auth::user()->username;

        // CEK STATUS BLOKIR
        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();
        if ($mahasiswa && $mahasiswa->status_blokir !== 'BELUM_KRS') {
            return redirect()->back()->with('error', 'Anda tidak dapat membatalkan mata kuliah karena status KRS sudah tidak dalam status BELUM_KRS.');
        }

        $registrasi = Registrasi::where('regkrs', $id)
                                ->where('nrp', $nrp)
                                ->first();

        if (!$registrasi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $registrasi->delete();
        return redirect()->route('mahasiswa.krs.index')
                         ->with('success', 'Mata kuliah berhasil dibatalkan.');
    }

    /**
     * Validasi KRS mahasiswa (ubah status menjadi MENUNGGU_VALIDASI)
     * Method ini dipanggil dari route: /mahasiswa/krs/krs/{nrp}/validasi
     */
    public function validasi($nrp)
    {
        $loginNrp = session('nrp') ?? Auth::user()->username;

        // Pastikan yang melakukan validasi adalah mahasiswa yang bersangkutan
        if ($loginNrp !== $nrp) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Ubah status blokir menjadi 'MENUNGGU_VALIDASI'
        $mahasiswa->status_blokir = 'MENUNGGU_VALIDASI';
        $mahasiswa->save();

        return redirect()->route('mahasiswa.krs.index')
                         ->with('success', 'KRS berhasil divalidasi, menunggu persetujuan dosen wali.');
    }
}