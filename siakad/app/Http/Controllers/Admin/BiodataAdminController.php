<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BiodataAdminController extends Controller
{
    public function index()
    {
        $biodatas = Biodata::paginate(15);

        return view('admin.biodata.index', [
            'biodatas' => $biodatas
        ]);
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::all();

        return view('admin.biodata.create', [
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function show(Biodata $biodata)
    {
        return view('admin.biodata.show', [
            'biodata' => $biodata
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|max:8|unique:biodata,nrp',
            'nama' => 'required|max:50',
            'nik' => 'required|max:16',
            'tempat_lahir' => 'nullable|max:25',
            'tanggal_lahir' => 'nullable|date',
            'tinggi' => 'required|integer',
            'berat' => 'required|integer',
            'alamat' => 'required|max:100',
            'kecamatan' => 'required|max:20',
            'kelurahan' => 'required|max:50',
            'kota' => 'required|max:25',
            'kodepos' => 'required|max:5',
            'no_telp' => 'required|max:13',
            'handphone' => 'required|max:13',
            'hobby' => 'required|max:30',
            'agama' => 'required|max:15',
            'warganegara' => 'required|max:15',
            'status_kawin' => 'required|max:15',
            'gol_darah' => 'required|max:10',
            'anak_ke' => 'required|integer',
            'jml_saudara' => 'required|integer',
            'jml_saudara_tanggungan' => 'required|integer',
            'sumber_biaya' => 'required|max:25',
            'jenis_rmh' => 'required|max:20',
            'asal_smu' => 'required|max:50',
            'lulus_smu' => 'required|max:4',
            'transportasi' => 'required|max:25',
            'nama_ayah' => 'required|max:50',
            'alamat_ayah' => 'required|max:100',
            'no_telp_ayah' => 'required|max:13',
            'kota_ayah' => 'required|max:25',
            'kodepos_ayah' => 'required|max:5',
            'handphone_ayah' => 'required|max:12',
            'agama_ayah' => 'required|max:15',
            'pekerjaan_ayah' => 'required|max:50',
            'pendidikan_ayah' => 'required|max:25',
            'warganegara_ayah' => 'required|max:20',
            'nama_ibu' => 'required|max:50',
            'alamat_ibu' => 'required|max:100',
            'kota_ibu' => 'required|max:25',
            'kodepos_ibu' => 'required|max:5',
            'no_telp_ibu' => 'required|max:13',
            'handphone_ibu' => 'required|max:12',
            'agama_ibu' => 'required|max:15',
            'pekerjaan_ibu' => 'required|max:50',
            'pendidikan_ibu' => 'required|max:25',
            'warganegara_ibu' => 'required|max:20',
            'nama_wali' => 'required|max:50',
            'alamat_wali' => 'required|max:100',
            'kota_wali' => 'required|max:25',
            'kodepos_wali' => 'required|max:5',
            'no_telp_wali' => 'required|max:13',
            'handphone_wali' => 'required|max:12',
            'agama_wali' => 'required|max:15',
            'pekerjaan_wali' => 'required|max:50',
            'pendidikan_wali' => 'required|max:25',
            'warganegara_wali' => 'required|max:20',
            'special_need' => 'required|max:4',
            'kps' => 'required|integer',
            'status_pendidikan' => 'required|max:1',
            'kebutuhan_ayah' => 'required|max:4',
            'kebutuhan_ibu' => 'required|max:4',
            'last_update' => 'required|date',
            'pataum' => 'required|in:P,M',
            'email' => 'required|email|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', // validasi nilai yang diterima
            'nisn' => 'required|max:25',
        ]);

        try {
            // Mapping nilai jenis_kelamin ke sex (L/P)
            $sex = $request->jenis_kelamin === 'Laki-laki' ? 'L' : 'P';

            Biodata::create([
                'nrp' => $request->nrp,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'sex' => $sex, // diisi dari mapping
                'tinggi' => $request->tinggi,
                'berat' => $request->berat,
                'alamat' => $request->alamat,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'kota' => $request->kota,
                'kodepos' => $request->kodepos,
                'no_telp' => $request->no_telp,
                'handphone' => $request->handphone,
                'hobby' => $request->hobby,
                'agama' => $request->agama,
                'warganegara' => $request->warganegara,
                'status_kawin' => $request->status_kawin,
                'gol_darah' => $request->gol_darah,
                'anak_ke' => $request->anak_ke,
                'jml_saudara' => $request->jml_saudara,
                'jml_saudara_tanggungan' => $request->jml_saudara_tanggungan,
                'sumber_biaya' => $request->sumber_biaya,
                'jenis_rmh' => $request->jenis_rmh,
                'asal_smu' => $request->asal_smu,
                'lulus_smu' => $request->lulus_smu,
                'transportasi' => $request->transportasi,
                'nama_ayah' => $request->nama_ayah,
                'alamat_ayah' => $request->alamat_ayah,
                'no_telp_ayah' => $request->no_telp_ayah,
                'kota_ayah' => $request->kota_ayah,
                'kodepos_ayah' => $request->kodepos_ayah,
                'handphone_ayah' => $request->handphone_ayah,
                'agama_ayah' => $request->agama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'warganegara_ayah' => $request->warganegara_ayah,
                'nama_ibu' => $request->nama_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'kota_ibu' => $request->kota_ibu,
                'kodepos_ibu' => $request->kodepos_ibu,
                'no_telp_ibu' => $request->no_telp_ibu,
                'handphone_ibu' => $request->handphone_ibu,
                'agama_ibu' => $request->agama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'warganegara_ibu' => $request->warganegara_ibu,
                'nama_wali' => $request->nama_wali,
                'alamat_wali' => $request->alamat_wali,
                'kota_wali' => $request->kota_wali,
                'kodepos_wali' => $request->kodepos_wali,
                'no_telp_wali' => $request->no_telp_wali,
                'handphone_wali' => $request->handphone_wali,
                'agama_wali' => $request->agama_wali,
                'pekerjaan_wali' => $request->pekerjaan_wali,
                'pendidikan_wali' => $request->pendidikan_wali,
                'warganegara_wali' => $request->warganegara_wali,
                'special_need' => $request->special_need,
                'kps' => $request->kps,
                'status_pendidikan' => $request->status_pendidikan,
                'kebutuhan_ayah' => $request->kebutuhan_ayah,
                'kebutuhan_ibu' => $request->kebutuhan_ibu,
                'last_update' => $request->last_update,
                'pataum' => $request->pataum,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin, // tetap menyimpan nilai asli
                'nisn' => $request->nisn,
            ]);

            return redirect()->route('biodata.index')->with('success', 'Biodata berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(Biodata $biodata)
    {
        $mahasiswas = Mahasiswa::all();

        return view('admin.biodata.edit', [
            'biodata' => $biodata,
            'mahasiswas' => $mahasiswas
        ]);
    }

    public function update(Request $request, Biodata $biodata)
    {
        // Validasi update (sama dengan store, tapi tanpa unique nrp)
        $request->validate([
            'nrp' => ['required', 'max:8', Rule::unique('biodata')->ignore($biodata)], // validasi unik dengan pengecualian untuk record saat ini
            'nama' => 'required|max:50',
            'nik' => 'required|max:16',
            'tempat_lahir' => 'nullable|max:25',
            'tanggal_lahir' => 'nullable|date',
            'tinggi' => 'required|integer',
            'berat' => 'required|integer',
            'alamat' => 'required|max:100',
            'kecamatan' => 'required|max:20',
            'kelurahan' => 'required|max:50',
            'kota' => 'required|max:25',
            'kodepos' => 'required|max:5',
            'no_telp' => 'required|max:13',
            'handphone' => 'required|max:13',
            'hobby' => 'required|max:30',
            'agama' => 'required|max:15',
            'warganegara' => 'required|max:15',
            'status_kawin' => 'required|max:15',
            'gol_darah' => 'required|max:10',
            'anak_ke' => 'required|integer',
            'jml_saudara' => 'required|integer',
            'jml_saudara_tanggungan' => 'required|integer',
            'sumber_biaya' => 'required|max:25',
            'jenis_rmh' => 'required|max:20',
            'asal_smu' => 'required|max:50',
            'lulus_smu' => 'required|max:4',
            'transportasi' => 'required|max:25',
           
            'nama_ayah' => 'required|max:50',
            'alamat_ayah' => 'required|max:100',
            'no_telp_ayah' => 'required|max:13',
            'kota_ayah' => 'required|max:25',
            'kodepos_ayah' => 'required|max:5',
            'handphone_ayah' => 'required|max:12',
            'agama_ayah' => 'required|max:15',
            'pekerjaan_ayah' => 'required|max:50',
            'pendidikan_ayah' => 'required|max:25',
            'warganegara_ayah' => 'required|max:20',
            'nama_ibu' => 'required|max:50',
            'alamat_ibu' => 'required|max:100',
            'kota_ibu' => 'required|max:25',
            'kodepos_ibu' => 'required|max:5',
            'no_telp_ibu' => 'required|max:13',
            'handphone_ibu' => 'required|max:12',
            'agama_ibu' => 'required|max:15',
            'pekerjaan_ibu' => 'required|max:50',
            'pendidikan_ibu' => 'required|max:25',
            'warganegara_ibu' => 'required|max:20',
            'nama_wali' => 'required|max:50',
            'alamat_wali' => 'required|max:100',
            'kota_wali' => 'required|max:25',
            'kodepos_wali' => 'required|max:5',
            'no_telp_wali' => 'required|max:13',
            'handphone_wali' => 'required|max:12',
            'agama_wali' => 'required|max:15',
            'pekerjaan_wali' => 'required|max:50',
            'pendidikan_wali' => 'required|max:25',
            'warganegara_wali' => 'required|max:20',
            'special_need' => 'required|max:4',
            'kps' => 'required|integer',
            'status_pendidikan' => 'required|max:1',
            'kebutuhan_ayah' => 'required|max:4',
            'kebutuhan_ibu' => 'required|max:4',
            'last_update' => 'required|date',
            'pataum' => 'required|in:P,M',
            'email' => 'required|email|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn' => 'required|max:25',
        ]);

        // Mapping sama seperti store
        $sex = $request->jenis_kelamin === 'Laki-laki' ? 'L' : 'P';

        try {
            $biodata->update([
                'nrp' => $request->nrp,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'sex' => $sex,
                'tinggi' => $request->tinggi,
                'berat' => $request->berat,
                'alamat' => $request->alamat,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'kota' => $request->kota,
                'kodepos' => $request->kodepos,
                'no_telp' => $request->no_telp,
                'handphone' => $request->handphone,
                'hobby' => $request->hobby,
                'agama' => $request->agama,
                'warganegara' => $request->warganegara,
                'status_kawin' => $request->status_kawin,
                'gol_darah' => $request->gol_darah,
                'anak_ke' => $request->anak_ke,
                'jml_saudara' => $request->jml_saudara,
                'jml_saudara_tanggungan' => $request->jml_saudara_tanggungan,
                'sumber_biaya' => $request->sumber_biaya,
                'jenis_rmh' => $request->jenis_rmh,
                'asal_smu' => $request->asal_smu,
                'lulus_smu' => $request->lulus_smu,
                'transportasi' => $request->transportasi,
             
                'nama_ayah' => $request->nama_ayah,
                'alamat_ayah' => $request->alamat_ayah,
                'no_telp_ayah' => $request->no_telp_ayah,
                'kota_ayah' => $request->kota_ayah,
                'kodepos_ayah' => $request->kodepos_ayah,
                'handphone_ayah' => $request->handphone_ayah,
                'agama_ayah' => $request->agama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'warganegara_ayah' => $request->warganegara_ayah,
                'nama_ibu' => $request->nama_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'kota_ibu' => $request->kota_ibu,
                'kodepos_ibu' => $request->kodepos_ibu,
                'no_telp_ibu' => $request->no_telp_ibu,
                'handphone_ibu' => $request->handphone_ibu,
                'agama_ibu' => $request->agama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'warganegara_ibu' => $request->warganegara_ibu,
                'nama_wali' => $request->nama_wali,
                'alamat_wali' => $request->alamat_wali,
                'kota_wali' => $request->kota_wali,
                'kodepos_wali' => $request->kodepos_wali,
                'no_telp_wali' => $request->no_telp_wali,
                'handphone_wali' => $request->handphone_wali,
                'agama_wali' => $request->agama_wali,
                'pekerjaan_wali' => $request->pekerjaan_wali,
                'pendidikan_wali' => $request->pendidikan_wali,
                'warganegara_wali' => $request->warganegara_wali,
                'special_need' => $request->special_need,
                'kps' => $request->kps,
                'status_pendidikan' => $request->status_pendidikan,
                'kebutuhan_ayah' => $request->kebutuhan_ayah,
                'kebutuhan_ibu' => $request->kebutuhan_ibu,
                'last_update' => $request->last_update,
                'pataum' => $request->pataum,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nisn' => $request->nisn,
            ]);

            return redirect()->route('biodata.index')->with('success', 'Biodata berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy(Biodata $biodata)
    {
        try {
            $biodata->delete();
            return redirect()->route('biodata.index')->with('success', 'Biodata berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}