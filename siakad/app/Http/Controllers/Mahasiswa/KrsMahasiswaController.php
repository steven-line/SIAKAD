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
   

    /**
     * Menampilkan daftar KRS mahasiswa yang sedang login
     */
   public function index()
{
    $nrp = session('nrp') ?? Auth::user()->username;

   

    // 🔥 DEBUG SAFE QUERY (tidak langsung hilang kalau periode salah)
    $registrasiQuery = Registrasi::where('nrp', $nrp);

    // kalau periode ada, pakai filter
    if (!empty($periode)) {
        $registrasiQuery->where('periode', $periode);
    }

    $registrasi = $registrasiQuery
        ->get();

    // 🔥 mapping aman tanpa relasi wajib
    $krsItems = $registrasi->map(function ($reg) {

        return (object) [
            'id'            => $reg->regkrs,
            'kode_mk'       => $reg->kodemk,

            // 🔥 FIX UTAMA: jangan paksa relasi matkul
            'nama_mk'       => optional($reg->matkul)->nama_mk
                                ?? optional($reg->matkul)->nama
                                ?? $reg->kodemk,

            'status'        => $reg->status ?? 'BARU',
            'hari'          => $reg->hari ?? '-',

            'jam_mulai'     => $reg->mulaipukul
                ? date('H:i', strtotime($reg->mulaipukul))
                : '-',

            'jam_selesai'   => $reg->selesaipukul
                ? date('H:i', strtotime($reg->selesaipukul))
                : '-',

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
        $request->validate([
            'penawaran_id' => 'required|exists:penawaran,recno',
        ]);

        $nrp = session('nrp') ?? Auth::user()->username;
        $penawaran = Penawaran::with('mk')->find($request->penawaran_id);

        if (!$penawaran) {
            return redirect()->back()->with('error', 'Data penawaran tidak ditemukan.');
        }

        // Cek apakah sudah terdaftar
        $sudah = Registrasi::where('nrp', $nrp)
                    ->where('kodemk', $penawaran->kodemk)
                    ->where('periode', $penawaran->periode)
                    ->exists();

        if ($sudah) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar mata kuliah ini.');
        }

        // Hitung total SKS yang sudah diambil pada periode yang sama
        $totalSksTerdaftar = Registrasi::where('nrp', $nrp)
                            ->where('periode', $penawaran->periode)
                            ->sum('sks');

        $sksMatkul = $penawaran->mk ? $penawaran->mk->sks : 3;
        $limitSks = 24; // nanti ambil dari setting atau hitung berdasarkan IPS

        if ($totalSksTerdaftar + $sksMatkul > $limitSks) {
            return redirect()->back()->with('error', 'Melebihi batas SKS yang diizinkan (maksimal ' . $limitSks . ' SKS).');
        }

        // Simpan registrasi
        Registrasi::create([
            'nrp'           => $nrp,
            'kodemk'        => $penawaran->kodemk,
            'periode'       => $penawaran->periode,
            'status'        => 'BARU',
            'sesi'          => $penawaran->sesi,
            'tanggal'       => now(),
            'jam'           => now(),
            'validasi'      => 0,
            'hari'          => $penawaran->hari,
            'mulaipukul'    => $penawaran->mulaipukul,
            'selesaipukul'  => $penawaran->selesaipukul,
            'ip_address'    => $request->ip(),
            'sks'           => $sksMatkul,
            'pataum'        => $penawaran->pataum ?? '1',
            'dosen'         => $penawaran->dosen
        ]);

        return redirect()->route('mahasiswa.krs.index')->with('success', 'Berhasil mendaftar mata kuliah.');
    }

    /**
     * Batalkan satu mata kuliah berdasarkan ID registrasi
     */
    public function destroy($id)
    {
        $nrp = session('nrp') ?? Auth::user()->username;
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
     * Batalkan beberapa mata kuliah sekaligus (dari checkbox)
     */
    public function batalMultiple(Request $request)
    {
        $nrp = session('nrp') ?? Auth::user()->username;
        $ids = $request->input('batal_ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada mata kuliah yang dipilih.');
        }

        Registrasi::where('nrp', $nrp)
                  ->whereIn('regkrs', $ids)
                  ->delete();

        return redirect()->route('mahasiswa.krs.index')
                         ->with('success', 'Mata kuliah yang dipilih berhasil dibatalkan.');
    }

        public function validasi(Mahasiswa $mahasiswa)
    {
            $loginNrp = session('nrp') ?? Auth::user()->username;

            // pastikan tidak sembarang orang bisa validasi
            if ($loginNrp !== $mahasiswa->nrp) {
                abort(403, 'Tidak diizinkan');
            }


            $mahasiswa->status_blokir = "MENUNGGU_VALIDASI";
            $mahasiswa->save();

            return redirect('/mahasiswa/krs')
                ->with('success', 'Menunggu Validasi Dosen');
    }
}