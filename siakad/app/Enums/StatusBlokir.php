<?php

namespace App\Enums;

enum StatusBlokir:string
{
    Case BelumKrs = 'BELUM_KRS';
    Case MenungguValidasi = 'MENUNGGU_VALIDASI';
    Case Disetujui = 'DISETUJUI';

     public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
        // ["deposit" => "Deposit", "withdraw" => "Withdraw"]
    }
}
