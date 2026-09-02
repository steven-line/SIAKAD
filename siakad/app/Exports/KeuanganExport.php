<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeuanganExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Mahasiswa::query()
            ->orderBy('nrp')
            ->get()
            ->map(function ($mahasiswa) {
                return [
                    'nrp' => $mahasiswa->nrp,
                    'status_blokir' => $mahasiswa->status_blokir === 'BLOKIR'
                        ? 0
                        : 1,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'nrp',
            'status_blokir',
        ];
    }
}