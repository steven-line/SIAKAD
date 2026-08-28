<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class KeuanganImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (
                empty($row['nrp']) &&
                empty($row['status_blokir'])
            ) {
                continue;
            }

            $nrp = trim((string) $row['nrp']);
            $status = trim((string) $row['status_blokir']);

            if (!$nrp) {
                throw new \Exception('NRP wajib diisi.');
            }

            if (!$status) {
                throw new \Exception(
                    "Status blokir untuk NRP {$nrp} wajib diisi."
                );
            }

            $statusValid = [
                'BLOKIR',
                'BELUM_KRS',
                'MENUNGGU_VALIDASI',
                'DISETUJUI',
                'TERKUNCI',
            ];

            if (!in_array($status, $statusValid)) {
                throw new \Exception(
                    "Status blokir '{$status}' untuk NRP {$nrp} tidak valid."
                );
            }

            $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();

            if (!$mahasiswa) {
                throw new \Exception(
                    "NRP {$nrp} tidak ditemukan di database."
                );
            }

            $mahasiswa->update([
                'status_blokir' => $status,
            ]);
        }
    }
}