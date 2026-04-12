<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $users = User::all();
        Gate::authorize('viewAny', User::class);
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
   
        
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', Password::default()],
                'level' => ['required'],
                'sks' => ['required'],
            ]);
            User::create([
                'username' => $request->username,
                'password' => $request->password, 
                'level' => $request->level,
                'sks' =>  $request->sks,
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                
            ]);

            return redirect('/admin/kelola-user');
    }   

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
         return redirect('/admin/kelola-user')->with('success', 'User dihapus');
        //
    }
}
