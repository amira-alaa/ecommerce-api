<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{

    public function handle(Request $request, Closure $next , ...$roles): Response
    {
        $user = $request->user();
        if (!$user)
            return response()->json([
                'message' => 'You \'re UnAuthenticated'
            ], 401);
        elseif(!in_array($user->role->name , $roles))
            return response()->json([
                'message' => 'Cannot access this Page , You \'re Forbidden',
                'success' => false
            ] , 403);

        return $next($request);
    }
}
