<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsMahasiswaController extends Controller
{
    /**
     * Ambil periode aktif (bisa dari session, config, atau database)
     */
    protected function getPeriodeAktif()
    {
        // Sesuaikan dengan periode yang sedang berjalan
        return '2026/2027'; // atau ambil dari session
    }

    /**
     * Menampilkan daftar KRS mahasiswa yang sedang login
     */
    public function index()
    {
        $nrp = session('nrp') ?? Auth::user()->username;

        // Ambil periode aktif
        $periode = $this->getPeriodeAktif();

        // Query registrasi dengan relasi penawaran
        $registrasiQuery = Registrasi::with('penawaran.mk')
            ->where('nrp', $nrp);

        // Filter periode melalui relasi penawaran
        if (!empty($periode)) {
            $registrasiQuery->whereHas('penawaran', function ($query) use ($periode) {
                $query->where('periode', $periode);
            });
        }

        $registrasi = $registrasiQuery->get();

        // Mapping data
        $krsItems = $registrasi->map(function ($reg) {
            $penawaran = $reg->penawaran;
            return (object) [
                'id'            => $reg->regkrs,
                'kode_mk'       => $penawaran ? $penawaran->kodemk : '-',
                'nama_mk'       => $penawaran && $penawaran->mk ? $penawaran->mk->nama : '-',
                'status'        => $reg->status ?? 'BARU',
                'hari'          => $reg->hari ?? '-',
                'jam_mulai'     => $reg->mulaipukul ? date('H:i', strtotime($reg->mulaipukul)) : '-',
                'jam_selesai'   => $reg->selesaipukul ? date('H:i', strtotime($reg->selesaipukul)) : '-',
                'sks'           => $reg->sks ?? 0,
            ];
        });

        $totalSks = $krsItems->sum('sks');

        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();
        $statusBlokir = $mahasiswa?->status_blokir ?? 'BELUM_KRS';

        $ipsTerakhir  = 3.813;
        $limitSks     = 24;
        $toleransiSks = 0;
        $sisaLimit    = $limitSks - $totalSks - $toleransiSks;

        return view('mahasiswa.kartu_KRS.index', compact(
            'krsItems',
            'totalSks',
            'ipsTerakhir',
            'limitSks',
            'toleransiSks',
            'sisaLimit',
            'statusBlokir',
            'nrp'
        ));
    }

    public function store(Request $request)
    {
        // ============================================================
        // 1. CEK STATUS BLOKIR MAHASISWA
        // ============================================================
        $nrp = session('nrp') ?? Auth::user()->username;
        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();

        if ($mahasiswa && $mahasiswa->status_blokir !== 'BELUM_KRS') {
            return redirect()->back()->with('error', 'Anda tidak dapat mendaftar mata kuliah karena status KRS sudah tidak dalam status BELUM_KRS.');
        }

        // ============================================================
        // 2. VALIDASI & PROSES PENDAFTARAN
        // ============================================================
        $request->validate([
            'penawaran_id' => 'required|exists:penawaran,recno',
        ]);

        $penawaran = Penawaran::with('mk')->find($request->penawaran_id);

        if (!$penawaran) {
            return redirect()->back()->with('error', 'Data penawaran tidak ditemukan.');
        }

        // Cek apakah sudah terdaftar (berdasarkan penawaran_id)
        $sudah = Registrasi::where('nrp', $nrp)
                    ->where('penawaran_id', $penawaran->recno)
                    ->exists();

        if ($sudah) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar mata kuliah ini.');
        }

        // Hitung total SKS yang sudah diambil pada periode yang sama
        // Gunakan whereHas untuk mengambil registrasi dengan penawaran periode yang sama
        $totalSksTerdaftar = Registrasi::where('nrp', $nrp)
                            ->whereHas('penawaran', function ($query) use ($penawaran) {
                                $query->where('periode', $penawaran->periode);
                            })
                            ->sum('sks');

        $sksMatkul = $penawaran->mk ? $penawaran->mk->sks : 3;
        $limitSks = 24; // nanti ambil dari setting

        if ($totalSksTerdaftar + $sksMatkul > $limitSks) {
            return redirect()->back()->with('error', 'Melebihi batas SKS yang diizinkan (maksimal ' . $limitSks . ' SKS).');
        }

        // Simpan registrasi dengan field yang sesuai tabel registrasi
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
            'pataum'        => $penawaran->pataum ?? 'P', // default 'P'
        ]);

        return redirect()->route('mahasiswa.krs.index')->with('success', 'Berhasil mendaftar mata kuliah.');
    }

    /**
     * Batalkan satu mata kuliah berdasarkan ID registrasi
     */
    public function destroy($id)
    {
        $nrp = session('nrp') ?? Auth::user()->username;

        // ============================================================
        // CEK STATUS BLOKIR
        // ============================================================
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
     */
    public function validasi($nrp)
    {
        $loginNrp = session('nrp') ?? Auth::user()->username;

        if ($loginNrp !== $nrp) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $mahasiswa->status_blokir = 'MENUNGGU_VALIDASI';
        $mahasiswa->save();

        return redirect()->route('mahasiswa.krs.index')
                         ->with('success', 'KRS berhasil divalidasi, menunggu persetujuan dosen wali.');
    }
}