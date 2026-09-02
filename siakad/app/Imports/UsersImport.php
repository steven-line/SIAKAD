<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Membuat User dari setiap baris Excel.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'username'   => trim($row['username']),
            'password'   => Hash::make($row['password']),
            'sks'        => $row['sks'] ?? 0,
            'validasi'   => $row['validasi'] ?? null,
            'aksesnilai' => $row['aksesnilai'] ?? null,
            'pataum'     => !empty($row['pataum']) ? $row['pataum'] : 'P',
            'aktif'      => isset($row['aktif'])
                ? filter_var($row['aktif'], FILTER_VALIDATE_BOOLEAN)
                : true,
            'firstlogin' => Carbon::now(),
            'lastlogin'  => Carbon::now(),
            
        ]);

        // Assign role
        $user->syncRoles([$row['role']]);

        return null;
    }

    /**
     * Validasi setiap baris Excel.
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:15',
                'unique:users,username',
                'regex:/^[A-Za-z0-9\-]+$/',
            ],

            'password' => [
                'required',
                Password::default(),
            ],

            'role' => [
                'required',
                'string',
                'exists:roles,name',
            ],

            'sks' => [
                'required',
                'numeric',
            ],

            'validasi' => [
                'nullable',
                'integer',
            ],

            'aksesnilai' => [
                'nullable',
                'integer',
            ],

            'pataum' => [
                'required_if:role,mahasiswa',
                'in:P,M',
            ],

            'aktif' => [
                'required',
                'boolean',
            ],
        ];
    }
}