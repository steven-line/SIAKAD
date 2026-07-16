<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MkImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new FirstSheetImport(),
            // atau 'Data MK' => new FirstSheetImport(),
        ];
    }
}