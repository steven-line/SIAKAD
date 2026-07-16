<?php

namespace App\Imports;

use App\Models\Mk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FirstSheetImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Mk([
            'kodemk'           => $row['kodemk'],
            'nama'             => $row['nama'],
            'sks'              => $row['sks'],
            'kode_kurikulum'   => $row['kode_kurikulum'],
            'nm_jenj_didik'    => $row['nm_jenj_didik'],
            'prasyaratsks'     => $row['prasyaratsks'],
            'prasyarat1'       => $row['prasyarat1'],
            'prasyarat2'       => $row['prasyarat2'],
            'prasyarat3'       => $row['prasyarat3'],
            'prasyarat4'       => $row['prasyarat4'],
            'prasyarat5'       => $row['prasyarat5'],
            'prasyarat6'       => $row['prasyarat6'],
            'prasyarat7'       => $row['prasyarat7'],
            'prasyarat8'       => $row['prasyarat8'],
            'prasyarat9'       => $row['prasyarat9'],
            'prasyarat10'      => $row['prasyarat10'],
            'prasyaratgrade'   => $row['prasyaratgrade'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kodemk' => ['required', 'unique:mk', 'max:8', 'regex:/^[A-Za-z0-9\-]+$/'],
            'nama' => ['required', 'max:50'],
            'sks' => ['required', 'max:3'],
            'nm_jenj_didik' => ['required', 'max:2'],
            'kode_kurikulum' => ['required', 'max:10'],
            'prasyaratsks' => ['required', 'max:3'],
            'prasyarat1' => ['required', 'max:8'],
            'prasyarat2' => ['required', 'max:8'],
            'prasyarat3' => ['required', 'max:8'],
            'prasyarat4' => ['required', 'max:8'],
            'prasyarat5' => ['required', 'max:8'],
            'prasyarat6' => ['required', 'max:8'],
            'prasyarat7' => ['required', 'max:8'],
            'prasyarat8' => ['required', 'max:8'],
            'prasyarat9' => ['required', 'max:8'],
            'prasyarat10' => ['required', 'max:8'],
            'prasyaratgrade' => ['required', 'max:1'],
        ];
    }
}