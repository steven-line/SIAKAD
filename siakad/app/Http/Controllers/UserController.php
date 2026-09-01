<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * LIST USER
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('username', 'like', '%' . $search . '%');

        })->with(['roles', 'permissions'])->select('username', 'pataum', 'aktif')->paginate(10);
        return view('admin.users.index', compact('users', 'search'));
    }

/**
 * FORM CREATE
 */
public function create()
{
    return view('admin.users.create', [
        'roles' => Role::all(),
        'permissions' => Permission::all(),
    ]);
}

/**
 * STORE USER
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'username' => ['required', 'string', 'max:255', 'unique:users',  'regex:/^[A-Za-z0-9\-]+$/'],
        'password' => ['required', Password::default()],
        'role'     => ['required', 'exists:roles,name'],
        'permissions' => ['nullable', 'array'],
        'permissions.*' => ['string', 'exists:permissions,name'],
        'sks'      => ['required', 'numeric'],
        'pataum'   => ['required_if:role, mahasiswa', 'in:P,M'],
    ]);

    $user = User::create([
        'username'   => $validated['username'],
        'password'   => Hash::make($validated['password']),
        'sks'        => $validated['sks'],
        'pataum'     => $validated['pataum'] ?? 'P',
        'firstlogin' => Carbon::now(),
        'lastlogin'  => Carbon::now(),
    ]);

    $user->syncRoles([$validated['role']]);
    $user->syncPermissions($validated['permissions'] ?? []);

    return redirect()->route('users.index')
        ->with('success', 'User berhasil ditambahkan');
}


    public function upload(Request $request) {
        $request->validate(['file' => 'required|mimes:csv,xlsx,xls']);
        try{
            Excel::import(new UsersImport, $request->file("file"));
            return redirect()->route('users.index')->with('success', 'Import Berhasil!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()} - {$failure->errors()[0]}";
            }

            return back()->with('error', implode(', ', $errors));
     }
         catch (\Throwable $e) {
            // Error umum
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
/**
 * EDIT FORM
 */
public function edit(User $user)
{
    
    return view('admin.users.edit', [
        'user' => $user->load(['roles', 'permissions']),
        'roles' => Role::all(),
        'permissions' => Permission::all(),
    ]);
}

public function show(User $user)
{
    return view('admin.users.show', [
        'user' =>  $user->load(['roles', 'permissions'])
    ]);
}


public function update(Request $request, User $user)    
{
    $validated = $request->validate([
        'username' => ['required', 'string', 'max:255',    'regex:/^[A-Za-z0-9\-]+$/',Rule::unique('users')->ignoreModel($user)],
        'role'     => ['required', 'exists:roles,name', ],
        'permissions' => ['nullable', 'array'],
        'permissions.*' => ['string', 'exists:permissions,name'],
        'sks'      => ['required', 'numeric'],
        'pataum'   => ['required_if:role,mahasiswa', 'in:P,M'],
        'aktif' => ['required', 'in:0,1']
    ]);

    $user->update([
        'username' => $validated['username'],
        'sks'      => $validated['sks'],
        'pataum'   => $validated['pataum'] ?? $user->pataum,
        'aktif' => $request->aktif
    ]);

    $user->syncRoles([$validated['role']]);
    $user->syncPermissions($validated['permissions'] ?? []);

    return redirect()->route('users.index')
        ->with('success', 'User berhasil diperbarui');
}


public function resetPassword(User $user) {
    $user->update(['password' => Hash::make('hello12345')]);
    return redirect()->route('users.index')
        ->with('success', 'Password user berhasil direset menjadi "hello12345"');   
}
/**
 * DELETE USER
 */
public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('users.index')
        ->with('success', 'User berhasil dihapus');
}
}