<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biodata;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BiodataSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nrp' => '31128888',
                'nama' => 'Andi Wijaya',
                'nik' => '3201010101010002',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2000-05-10',
              
                'tinggi' => 168,
                'berat' => 60,
                'alamat' => 'Jl. Melati',
                'kecamatan' => 'Antapani',
                'kelurahan' => 'Sukamaju',
                'kota' => 'Bandung',
                'kodepos' => '40112',
                'no_telp' => '0223333333',
                'handphone' => '081333333333',
                'hobby' => 'Olahraga',
                'agama' => 'Islam',
                'warganegara' => 'Indonesia',
                'status_kawin' => 'Belum',
                'gol_darah' => 'A',
                'anak_ke' => 2,
                'jml_saudara' => 3,
                'jml_saudara_tanggungan' => 1,
                'sumber_biaya' => 'Beasiswa',
                'jenis_rmh' => 'Kontrakan',
                'asal_smu' => 'SMAN 2 Bandung',
                'lulus_smu' => '2018',
                'transportasi' => 'Motor',
                

                'nama_ayah' => 'Bambang',
                'alamat_ayah' => 'Bandung',
                'no_telp_ayah' => '0224444444',
                'kota_ayah' => 'Bandung',
                'kodepos_ayah' => '40112',
                'handphone_ayah' => '081444444444',
                'agama_ayah' => 'Islam',
                'pekerjaan_ayah' => 'Wiraswasta',
                'pendidikan_ayah' => 'SMA',
                'warganegara_ayah' => 'Indonesia',

                'nama_ibu' => 'Susi',
                'alamat_ibu' => 'Bandung',
                'kota_ibu' => 'Bandung',
                'kodepos_ibu' => '40112',
                'no_telp_ibu' => '0225555555',
                'handphone_ibu' => '082555555555',
                'agama_ibu' => 'Islam',
                'pekerjaan_ibu' => 'Guru',
                'pendidikan_ibu' => 'S1',
                'warganegara_ibu' => 'Indonesia',

                'nama_wali' => 'Tidak Ada',
                'alamat_wali' => '-',
                'kota_wali' => '-',
                'kodepos_wali' => '00000',
                'no_telp_wali' => '-',
                'handphone_wali' => '-',
                'agama_wali' => '-',
                'pekerjaan_wali' => '-',
                'pendidikan_wali' => '-',
                'warganegara_wali' => '-',

                'special_need' => '0',
                'kps' => 0,
                'status_pendidikan' => 'A',
                'kebutuhan_ayah' => '0',
                'kebutuhan_ibu' => '0',
                'last_update' => Carbon::now(),

                'email' => 'andi@example.com',
                'jenis_kelamin' => 'L',
                'nisn' => '1234567891',
            ],

        ];

        foreach ($data as $item) {
            Biodata::create($item);
        }
    }
}