<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate('10');

        return view('admin.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.role.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5','max:191', 'unique:roles'],
            'permissions' => ['required']
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
           
        ]);
        
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }
           return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(role $role)
    {
        $permissions = $role->permissions->pluck('name');
        return view('admin.role.show', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(role $role)
    {
           $role->load('permissions'); 
         $permissions = Permission::all();
         return view('admin.role.edit', ['role' => $role, 'permissions' => $permissions]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, role $role)
    {
          $request->validate([
            'name' => ['required', 'min:5', 'max:191', Rule::unique('roles')->ignore($role)],
            'permissions' => ['required']
        ]);

           $role->update([
            'name' => $request->name,
            'guard_name' => 'web',

        ]);
        if ($request->has('permissions')) {
                    $role->syncPermissions($request->permissions);
                }
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $role)
    {
        $role->delete();
          return redirect()->route('roles.index')->with('success', 'role Dihapus');
   
    }
}
