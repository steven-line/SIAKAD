<?php

namespace App\Exports;

use App\Models\NilaiTransfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiTransferExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'id',
            'nrp',
            'kodemk',
            'sks',
            'na'
        ];
    }
    public function collection()
    {
        return NilaiTransfer::all();
    }
}
