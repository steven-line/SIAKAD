<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotNilai extends Model
{
    //
    public $timestamps = false;
     protected $table = 'bobotnilai';
     
    protected $fillable = [
        'kodemk',
        'ttt1',
        'ttt2',
        'lain',
        'uts',
        'uas',
       
      
    ];
    public function mk()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }
}
