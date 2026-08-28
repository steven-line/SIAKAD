<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::create([
            'username' => $row['username'], 
            'password' => Hash::make($row['password']), 
            'sks' => $row['sks'],
            'firstlogin' => $row['firstlogin'],
            'lastlogin' => $row['lastlogin'],
            'validasi' => $row['validasi'],
            'aksesnilai' => $row['aksesnilai'],
            'pataum' => $row['pataum'],
            'aktif' => $row['aktif']
        ]);
        if (!empty($row['role'])) {
            $user->syncRoles([$row['role']]);
        }
        return null;

    }
    public function rules(): array {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users',  'regex:/^[A-Za-z0-9\-]+$/'],
            'password' => ['required', Password::default()],
            'role'     => ['required', 'exists:roles,name'],
            'sks'      => ['numeric'],
            'pataum'   => ['required_if:role, mahasiswa', 'in:P,M'],
        ];
    }
}
