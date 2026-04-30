<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    
        protected $fillable = [
        'username',
        'level',
        'sks',
        'validasi',
        'firstlogin',
        'lastlogin',
        'pataum',
        'aksesnilai',
        'aktif',
        'password',
        'prodi', // 🔥 WAJIB TAMBAH INI
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

    public function isAdmin() {
        return $this->level === 1;
    }
    public function isKaprodi() {
        return $this->level === 2;
    }


    public function isMahasiswa() {
        return $this->level === 3;
    }
    public function isDosen() {
        return $this->level === 4;
    }

}
