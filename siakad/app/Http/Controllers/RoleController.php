<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5']
        ]);

        role::create([
            'name' => $request->name,
            'guard_name' => 'web'
           
        ]);
        
        return redirect('/admin/master-role/');
    }

    /**
     * Display the specified resource.
     */
    public function show(role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(role $role)
    {
         return view('admin.role.edit', ['role' => $role]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, role $role)
    {
           $role->update([
            'name' => $request->name

        ]);

        return redirect('/admin/master-role/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $role)
    {
        $role->delete();
        return redirect('/admin/master-role')->with('success', 'role Dihapus');
   
    }
}
