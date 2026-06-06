<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo(function (Request $request){
            if ($request->user()->hasRole('admin')) {
                return '/admin';
            } elseif ($request->user()->hasRole('kaprodi')) {
                return '/kaprodi';
            } elseif ($request->user()->hasRole('dosen-wali')){
                return '/dosen-wali';
                
            } elseif ($request->user()->hasRole('mahasiswa')) {
                return '/mahasiswa';
            } elseif ($request->user()->hasRole('dosen')){
                return '/dosen';
            }
           
        });
       
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
