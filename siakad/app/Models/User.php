<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    
        protected $fillable = [
        'username',

        'sks',
        'validasi',
        'firstlogin',
        'lastlogin',
        'pataum',
        'aksesnilai',
        'aktif',
        'password',
        'prodi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $primaryKey =  'username';
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public $incrementing = false;       // Jika username bukan angka (string)
    protected $keyType = 'string'; 
    public $timestamps = false;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    
    
    public function dosen()
        {
             return $this->hasOne(Dosen::class, 'user_id', 'username');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'nrp', 'username');
    }

}
