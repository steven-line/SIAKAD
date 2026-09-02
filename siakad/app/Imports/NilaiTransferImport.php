<?php

namespace App\Imports;

use App\Models\NilaiTransfer;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NilaiTransferImport implements ToModel, WithHeadingRow, WithValidation
{
    // Properti untuk menangkap NRP dari baris yang sedang divalidasi
    private $currentNrp = null;
    private $currentId = null;

    /**
    * @param array $data
    * @param int $index
    * @return array
    */
    
    public function prepareForValidation($data, $index)
    {
        if (isset($data['nrp'])) {
            $data['nrp'] = (string) $data['nrp'];
            // Simpan NRP baris ini agar bisa dibaca di fungsi rules()
            $this->currentNrp = $data['nrp'];
        }

        if (isset($data['kodemk'])) {
            $data['kodemk'] = (string) $data['kodemk'];
        }

        if (isset($data['id'])) {
            $this->currentId = $data['id'];
        } else {
            $this->currentId = null;
        }

        return $data;
    }

    public function model(array $row)
    {
        return NilaiTransfer::updateOrCreate(['id' => $row['id'] ?? null],[
            'nrp' => $row['nrp'],
            'kodemk' => $row['kodemk'],
            'sks' => $row['sks'],
            'na' => $row['na'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nrp' => ['required', 'string', 'max:8', 'exists:mahasiswas,nrp'],
            'kodemk' => [
                'required', 
                'string', 
                'max:8', 
                'exists:mk,kodemk',
                // Validasi: kodemk harus unik di dalam tabel 'nilai_transfer' khusus untuk nrp ini
                Rule::unique('nilai_transfer', 'kodemk')
                    ->where(function ($query) {
                        return $query->where('nrp', $this->currentNrp);
                    })
                    ->ignore($this->currentId) // Abaikan ID ini jika tujuannya adalah update data lama
            ],
            'sks' => ['required', 'integer', 'min:0', 'max:255'],
            'na' => ['required', 'string', 'max:2'],
        ];
    }

    /**
     * Kustomisasi pesan error agar lebih informatif bagi pengguna
     */
    public function customValidationMessages()
    {
        return [
            'kodemk.unique' => 'Mata kuliah :input sudah terdaftar untuk mahasiswa dengan NRP tersebut.',
        ];
    }
}

//semester matkul. aljabar linear 3
// periode genap gasal.

// 2025-2026
// 1-7 Genap /Gasal
// 
// semester akademik 1-7
// 1-7
// 
// semester periode gasal genap.
// semester -tahun_ajaran
// gasal/genap periode_id