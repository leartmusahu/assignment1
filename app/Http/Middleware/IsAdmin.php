<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class IsAdmin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is an admin
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // Return unauthorized response if not an admin
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
