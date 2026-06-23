<?php

namespace App\Enums;

enum JenisSemester: string
{
    
    Case Ganjil = 'GANJIL';
    Case Genap = 'GENAP';

     public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
        // ["deposit" => "Deposit", "withdraw" => "Withdraw"]
    }
}
