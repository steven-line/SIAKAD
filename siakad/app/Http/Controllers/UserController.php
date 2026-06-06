<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);
        
        // Eager load roles dan permissions untuk performa yang lebih baik
        $users = User::with(['roles', 'permissions'])->get();
        
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('admin.users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'    => ['required', 'string', 'max:255', 'unique:users'],
            'password'    => ['required', Password::default()],
            'role'        => ['required', 'string', 'exists:roles,name'],
            'permissions' => ['nullable', 'array'],
            'sks'         => ['required', 'numeric'],
        ]);

        $user = User::create([
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'sks'        => $request->sks,
            'firstlogin' => Carbon::now(),
            'lastlogin'  => Carbon::now(),
        ]);

        // Assign Role (Single Role)
        $user->assignRole($request->role);

        // Assign Direct Permissions (Optional)
        if ($request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        return redirect('/admin/kelola-user')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username'    => ['required', 'string', 'max:255'],
            'role'        => ['required', 'string', 'exists:roles,name'],
            'permissions' => ['nullable', 'array'],
            'sks'         => ['required', 'numeric'],
        ]);

        $user->update([
            'username' => $request->username,
            'sks'      => $request->sks,
        ]);

        // Sync Roles (Menghapus role lama, memasang role baru)
        $user->syncRoles($request->role);

        // Sync Permissions (Memastikan permission sesuai dengan checkbox yang dicentang)
        $user->syncPermissions($request->permissions ?? []);

        return redirect('/admin/kelola-user')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/admin/kelola-user')->with('success', 'User berhasil dihapus.');
    }
}