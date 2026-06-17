<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * LIST USER
     */
    public function index()
{
    $users = User::with(['roles', 'permissions'])->paginate(10);

    return view('admin.users.index', compact('users'));
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
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'password' => ['required', Password::default()],
        'role'     => ['required', 'exists:roles,name'],
        'permissions' => ['nullable', 'array'],
        'permissions.*' => ['string', 'exists:permissions,name'],
        'sks'      => ['required', 'numeric'],
        'pataum'   => ['nullable', 'in:P,M'],
    ]);

    $user = User::create([
        'username'   => $validated['username'],
        'password'   => Hash::make($validated['password']),
        'sks'        => $validated['sks'],
        'pataum'     => $validated['pataum'] ?? null,
        'firstlogin' => Carbon::now(),
        'lastlogin'  => Carbon::now(),
    ]);

    $user->syncRoles([$validated['role']]);
    $user->syncPermissions($validated['permissions'] ?? []);

    return redirect()->route('users.index')
        ->with('success', 'User berhasil ditambahkan');
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

/**
 * UPDATE USER
 */
public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'username' => ['required', 'string', 'max:255'],
        'role'     => ['required', 'exists:roles,name'],
        'permissions' => ['nullable', 'array'],
        'permissions.*' => ['string', 'exists:permissions,name'],
        'sks'      => ['required', 'numeric'],
        'pataum'   => ['nullable', 'in:P,M'],
    ]);

    $user->update([
        'username' => $validated['username'],
        'sks'      => $validated['sks'],
        'pataum'   => $validated['pataum'] ?? $user->pataum,
    ]);

    $user->syncRoles([$validated['role']]);
    $user->syncPermissions($validated['permissions'] ?? []);

    return redirect()->route('users.index')
        ->with('success', 'User berhasil diperbarui');
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