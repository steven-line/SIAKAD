<?php

namespace App\Http\Controllers;

use App\Models\BobotNilai;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Mk;
use App\Models\Penawaran;
use App\Models\Registrasi;
use App\Models\Semester;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * LIST MATA KULIAH
     */
    public function list_matkul()
    {
        $user = auth()->user();

        if (!$user || !$user->dosen) {
            abort(403, 'Akun tidak memiliki data dosen.');
        }

        $nimDosen = $user->dosen->nim_dosen;

        $mks = Penawaran::with('mk')
            ->where('dosen', $nimDosen)
            ->paginate(15);

        return view('dosen.input_nilai.list_matkul', compact('mks'));
    }
    /**
     * LIST MAHASISWA PER MK
     */
    public function list_mahasiswa(Mk $mk)
    {
        $mahasiswas = Registrasi::with([
            'mahasiswa',
            'penawaran.semester.periode',
            'krs'
        ])
        ->whereHas('penawaran', function ($q) use ($mk) {
            $q->where('kodemk', $mk->kodemk);
        })
        ->whereHas('mahasiswa', function ($q) {
            $q->where('status_blokir', 'DISETUJUI');
        })
        ->get();

        return view('dosen.input_nilai.list_mahasiswa', [
            'mahasiswas' => $mahasiswas,
            'mk' => $mk
        ]);
    }

    /**
     * FORM INPUT NILAI
     * ⚠️ URUTAN HARUS: Mahasiswa dulu, baru MK (sesuai URL)
     */
    public function show(Mahasiswa $mahasiswa, Mk $mk)
    {
        $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
            ->whereHas('penawaran', function ($q) use ($mk) {
                $q->where('kodemk', $mk->kodemk);
            })
            ->firstOrFail();

        $krs = Krs::with([
            'registrasi.mahasiswa',
            'registrasi.penawaran.mk',
            'registrasi.penawaran.semester.periode'
        ])
        ->where('registrasi_id', $registrasi->regkrs)
        ->first(); // ❌ HAPUS where('kode')

        return view('dosen.input_nilai.show', [
            'krs' => $krs,
            'mahasiswa' => $mahasiswa,
            'mk' => $mk,
            'registrasi' => $registrasi,
        ]);
    }
    /**
     * SIMPAN NILAI KRS
     */
public function edit_bobot (Mk $mk){
    return view('dosen.input_nilai.edit_bobot_matkul', ['mk' => $mk]);

}

public function update_bobot(Request $request, Mk $mk) {
    $request->validate([
        'ttt1' => ['required', 'numeric', 'between:0,100'],
        'ttt2' => ['required', 'numeric', 'between:0,100'],
        'lain' => ['required', 'numeric', 'between:0,100'],
        'uts'  => ['required', 'numeric', 'between:0,100'],
        'uas'  => ['required', 'numeric', 'between:0,100'],
    ]);

    $bobotFields = ['ttt1','ttt2','lain','uts','uas'];

    $total = round(collect($bobotFields)
        ->sum(fn($f) => (float) $request->$f), 2);

    if ($total !== 100.00) {
        return back()
            ->withErrors([
                'bobot' => "Total bobot harus 100%. Saat ini: {$total}%"
            ])
            ->withInput();
    }
    BobotNilai::updateOrCreate(
        ['kodemk' => $mk->kodemk],
        [
            'ttt1' => $request->ttt1,
            'ttt2' => $request->ttt2,
            'lain' => $request->lain,
            'uts' => $request->uts,
            'uas' => $request->uas
        ]
    );
    return redirect()->route('nilai.edit_bobot', ['mk' => $mk])->with('success', 'Bobot nilai berhasil diperbarui.');


}
    public function edit(Mahasiswa $mahasiswa, Mk $mk)
    {
        $registrasi = Registrasi::with('penawaran.semester.periode')
            ->where('nrp', $mahasiswa->nrp)
            ->whereHas('penawaran', function ($q) use ($mk) {
                $q->where('kodemk', $mk->kodemk);
            })
            ->firstOrFail();

        $krs = Krs::where('registrasi_id', $registrasi->regkrs)
            ->firstOrFail();

        $semester = $registrasi->penawaran->semester;

        return view('dosen.input_nilai.edit', [
            'krs' => $krs,
            'mahasiswa' => $mahasiswa,
            'mk' => $mk,
            'semester' => $semester,
        ]);
    }
public function update(Request $request, Mahasiswa $mahasiswa, Mk $mk)
{
    $validated = $request->validate([
        'kelas' => [
            'required',
            'string',
            'size:1',
            'in:A,B,C',
        ],
        'bu' => [
            'nullable',
            'string',
            'size:1',
            'in:Y,N',
        ],
        'ttt1' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],
        'ttt2' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],

        'lain' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],
        'uts' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],
        'uas' => [
            'nullable',
            'numeric',
            'between:0,100',
        ],
        'survey' => [
            'required',
            'boolean',
        ],
    ]);

    // Ambil registrasi
    $registrasi = Registrasi::where('nrp', $mahasiswa->nrp)
        ->whereHas('penawaran', function ($q) use ($mk) {
            $q->where('kodemk', $mk->kodemk);
        })
        ->firstOrFail();

    // Ambil KRS
    $krs = Krs::where('registrasi_id', $registrasi->regkrs)
        ->firstOrFail();

    // Ambil bobot
    $bobot = BobotNilai::where('kodemk', $mk->kodemk)->first();

    // Hitung nilai akhir angka
    $nilaiAkhirAngka = 0;

    if ($bobot) {
        $nilaiAkhirAngka =
            (($validated['ttt1'] ?? 0) * $bobot->ttt1 / 100) +
            (($validated['ttt2'] ?? 0) * $bobot->ttt2 / 100) +// ✅ ditambahkan
            (($validated['lain'] ?? 0) * $bobot->lain / 100) +
            (($validated['uts'] ?? 0) * $bobot->uts / 100) +
            (($validated['uas'] ?? 0) * $bobot->uas / 100);
    }

    // Konversi ke nilai huruf (SESUI PEDOMAN BARU)
    $na = match (true) {
        $nilaiAkhirAngka >= 80 => 'A',
        $nilaiAkhirAngka >= 74 => 'AB',
        $nilaiAkhirAngka >= 68 => 'B',
        $nilaiAkhirAngka >= 62 => 'BC',
        $nilaiAkhirAngka >= 56 => 'C',
        $nilaiAkhirAngka >= 41 => 'D',
        default => 'E',
    };

    // Update data (PAKAI UPDATE, BUKAN updateOrCreate)
    $krs->update([
        'kelas'   => $validated['kelas'],
        'bu'      => $validated['bu'],
        'ttt1'    => $validated['ttt1'],
        'ttt2'    => $validated['ttt2'],
        'lain'    => $validated['lain'],
        'uts'     => $validated['uts'],
        'uas'     => $validated['uas'],
        'na'      => $na, // ✅ hasil hitungan
        'sks'     => $mk->sks,
        'survey'  => $validated['survey'],
    ]);

    return redirect()
        ->route('nilai.show', [
            'mahasiswa' => $mahasiswa->nrp,
            'mk' => $mk->kodemk,
        ])
        ->with('success', 'Nilai berhasil diperbarui.');
}
    public function destroy(Krs $krs) {}
}