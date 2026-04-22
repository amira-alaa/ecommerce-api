<?php

use App\Http\Middleware\Role;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api:__DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'role' => Role::class
        ]);
    })
    ->withMiddleware(function ($middleware) {
    $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                // return $request->is('api/*');
                if ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'message' => 'Method not allowed for this endpoint'
                        ] , 405);
                }

            }
            return null;
        });
    })->create();


