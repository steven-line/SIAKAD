<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pjmk extends Model
{
    protected $table = 'pjmk';
    protected $primaryKey = 'kodemk';
    public $incrementing = false;

    public $timestamps = false;
    protected $fillable = ['kodemk', 'nim_dosen'];
    
    public function dosen() {
        return $this->belongsTo(Dosen::class, 'nim_dosen');
    }
    
}
