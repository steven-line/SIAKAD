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
            if ($request->user()->isAdmin()) {
                return '/admin';
            } elseif ($request->user()->isKaprodi()) {
                return '/kaprodi';
            } elseif ($request->user()->isMahasiswa()) {
                return '/mahasiswa';
            } elseif ($request->user()->isDosen()){
                return '/dosen';
            }
        });
       
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
