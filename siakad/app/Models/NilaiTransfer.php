<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTransfer extends Model
{
    //
    protected $table = 'nilai_transfer';
    public $timestamps = false;
    protected $fillable = [
        'kodemk',
        'nrp',
        'na',
        'sks'
    ];

       public function mk()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }
}
