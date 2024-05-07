<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckItRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You do not have permission to access this page'], 403);
        }

        $user = Auth::user();

        if (!$user->hasRole('Technicien de support')) {
            return response()->json(['message' => 'You do not have permission to access this page'], 403);
        }

        return $next($request);
    }
}
