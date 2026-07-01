<?php

namespace App\Imports;

use App\Models\Biodata;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Validators\Failure;
class BiodatasImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function prepareForValidation($data, $index)
    {
        // tanggal_lahir
        if (isset($data['tanggal_lahir'])) {
            $data['tanggal_lahir'] = $this->parseExcelDate($data['tanggal_lahir']);
        }

        // last_update
        if (isset($data['last_update'])) {
            $data['last_update'] = $this->parseExcelDate($data['last_update']);
        }

        return $data;
    }

    private function parseExcelDate($value)
    {
        try {
            // Kalau format Excel SERIAL NUMBER
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))
                    ->format('Y-m-d');
            }

            // Kalau sudah string (bebas format)
            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Exception $e) {
            return null;
        }
    }
    public function model(array $row)
    {
        return new Biodata([
                'nrp' => $row['nrp'],
                'nama' => $row['nama'],
                'nik' => $row['nik'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' =>  $row['tanggal_lahir'],

                'tinggi' => $row['tinggi'],
                'berat' => $row['berat'],
                'alamat' => $row['alamat'],
                'kecamatan' => $row['kecamatan'],
                'kelurahan' => $row['kelurahan'],
                'kota' => $row['kota'],
                'kodepos' => $row['kodepos'],
                'no_telp' => $row['no_telp'],
                'handphone' => $row['handphone'],
                'hobby' => $row['hobby'],
                'agama' => $row['agama'],
                'warganegara' => $row['warganegara'],
                'status_kawin' => $row['status_kawin'],
                'gol_darah' => $row['gol_darah'],
                'anak_ke' => $row['anak_ke'],
                'jml_saudara' => $row['jml_saudara'],
                'jml_saudara_tanggungan' => $row['jml_saudara_tanggungan'],
                'sumber_biaya' => $row['sumber_biaya'],
                'jenis_rmh' => $row['jenis_rmh'],
                'asal_smu' => $row['asal_smu'],
                'lulus_smu' => $row['lulus_smu'],
                'transportasi' => $row['transportasi'],
                'nama_ayah' => $row['nama_ayah'],
                'alamat_ayah' => $row['alamat_ayah'],
                'no_telp_ayah' => $row['no_telp_ayah'],
                'kota_ayah' => $row['kota_ayah'],
                'kodepos_ayah' => $row['kodepos_ayah'],
                'handphone_ayah' => $row['handphone_ayah'],
                'agama_ayah' => $row['agama_ayah'],
                'pekerjaan_ayah' => $row['pekerjaan_ayah'],
                'pendidikan_ayah' => $row['pendidikan_ayah'],
                'warganegara_ayah' => $row['warganegara_ayah'],
                'nama_ibu' => $row['nama_ibu'],
                'alamat_ibu' => $row['alamat_ibu'],
                'kota_ibu' => $row['kota_ibu'],
                'kodepos_ibu' => $row['kodepos_ibu'],
                'no_telp_ibu' => $row['no_telp_ibu'],
                'handphone_ibu' => $row['handphone_ibu'],
                'agama_ibu' => $row['agama_ibu'],
                'pekerjaan_ibu' => $row['pekerjaan_ibu'],
                'pendidikan_ibu' => $row['pendidikan_ibu'],
                'warganegara_ibu' => $row['warganegara_ibu'],
                'nama_wali' => $row['nama_wali'],
                'alamat_wali' => $row['alamat_wali'],
                'kota_wali' => $row['kota_wali'],
                'kodepos_wali' => $row['kodepos_wali'],
                'no_telp_wali' => $row['no_telp_wali'],
                'handphone_wali' => $row['handphone_wali'],
                'agama_wali' => $row['agama_wali'],
                'pekerjaan_wali' => $row['pekerjaan_wali'],
                'pendidikan_wali' => $row['pendidikan_wali'],
                'warganegara_wali' => $row['warganegara_wali'],
                'special_need' => $row['special_need'],
                'kps' => $row['kps'],
                'status_pendidikan' => $row['status_pendidikan'],
                'kebutuhan_ayah' => $row['kebutuhan_ayah'],
                'kebutuhan_ibu' => $row['kebutuhan_ibu'],
                'last_update'   => $row['last_update'],
               
                'email' => $row['email'],
                'jenis_kelamin' => $row['jenis_kelamin'], // tetap menyimpan nilai asli
                'nisn' => $row['nisn'],
        ]);
    }

    public function customValidationAttributes()
    {
    return [
        'nrp' => 'NRP',
        'nama' => 'Nama',
        'nik' => 'NIK',
        'tempat_lahir' => 'Tempat Lahir',
        'tanggal_lahir' => 'Tanggal Lahir',
        'tinggi' => 'Tinggi',
        'berat' => 'Berat',
        'alamat' => 'Alamat',
        'kecamatan' => 'Kecamatan',
        'kelurahan' => 'Kelurahan',
        'kota' => 'Kota',
        'kodepos' => 'Kodepos',
        'no_telp' => 'No Telepon',
        'handphone' => 'Handphone',
        'hobby' => 'Hobby',
        'agama' => 'Agama',
        'warganegara' => 'Warganegara',
        'status_kawin' => 'Status Kawin',
        'gol_darah' => 'Gol Darah',
        'anak_ke' => 'Anak Ke',
        'jml_saudara' => 'Jumlah Saudara',
        'jml_saudara_tanggungan' => 'Jumlah Saudara Tanggungan',
            'sumber_biaya' => 'Sumber Biaya',
            'jenis_rmh' => 'Jenis Rumah',
            'asal_smu' => 'Asal SMU',
            'lulus_smu' => 'Lulus SMU',
            'transportasi' => 'Transportasi',
            'nama_ayah' => 'Nama Ayah',
            'alamat_ayah' => 'Alamat Ayah',
            'no_telp_ayah' => 'No Telp Ayah',
            'kota_ayah' => 'Kota Ayah',
            'kodepos_ayah' => 'Kodepos Ayah',
            'handphone_ayah' => 'Handphone Ayah',
            'agama_ayah' => 'Agama Ayah',
            'pekerjaan_ayah' => 'Pekerjaan Ayah',
            'pendidikan_ayah' => 'Pendidikan Ayah',
            'warganegara_ayah' => 'Warganegara Ayah',
            'nama_ibu' => 'Nama Ibu',
            'alamat_ibu' => 'Alamat Ibu',
            'kota_ibu' => 'Kota Ibu',
            'kodepos_ibu' => 'Kodepos Ibu',
            'no_telp_ibu' => 'No Telp Ibu',
            'handphone_ibu' => 'Handphone Ibu',
            'agama_ibu' => 'Agama Ibu',
            'pekerjaan_ibu' => 'Pekerjaan Ibu',
            'pendidikan_ibu' => 'Pendidikan Ibu',
            'warganegara_ibu' => 'Warganegara Ibu',
            'nama_wali' => 'Nama Wali',
            'alamat_wali' => 'Alamat Wali',
            'kota_wali' => 'Kota Wali',
            'kodepos_wali' => 'Kodepos Wali',
            'no_telp_wali' => 'No Telp Wali',
            'handphone_wali' => 'Headphone Wali',
            'agama_wali' => 'Agama Wali',
            'pekerjaan_wali' => 'Pekerjaan Wali',
            'pendidikan_wali' => 'Pendidikan Wali',
            'warganegara_wali' => 'Warganegara Wali',
            'special_need' => 'Special Need',
            'kps' => 'KPS',
            'status_pendidikan' => 'Status Pendidikan',
            'kebutuhan_ayah' => 'Kebutuhan Ayah',
            'kebutuhan_ibu' => 'Kebutuhan Ibu',
            'last_update' => 'Last Update',
            'email' => 'Email',
            'jenis_kelamin' => 'Jenis Kelamin', // validasi nilai yang diterima
            'nisn' => 'NISN',
        ];
    }

    public function rules(): array {
        return [
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
            'email' => 'required|email|max:100',
            'jenis_kelamin' => 'required|in:L,P', // validasi nilai yang diterima
            'nisn' => 'required|max:25',
        ];
           

    }
}
