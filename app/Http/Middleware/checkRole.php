<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

class checkRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
    
        if (!$user || ($roles && !in_array($user->role, $roles))) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }
    
        return $next($request);
    }
}
