<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotNilai extends Model
{
    //
    public $timestamps = false;
     protected $table = 'bobotnilai';
     
    protected $fillable = [
   
        'ttt1',
        'ttt2',
        'lain',
        'uts',
        'uas',
       
      
    ];

}
