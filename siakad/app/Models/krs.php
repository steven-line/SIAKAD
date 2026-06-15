<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    //
    protected $table = 'krs';
     public $timestamps = false;
     protected $fillable = [
        'nrp',
        'kode',
        'bu',
        'ttt1',
        'ttt2',
        'ttt3',
        'lain',
        'uts',
        'uas',
        'na',
        'sks',
        'periode',
        'kelas',
        'survey'
        ];
}
