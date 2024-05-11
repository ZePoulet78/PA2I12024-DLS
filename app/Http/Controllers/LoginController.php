<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {


        // j'ai ajt verif pour pas se connecter plusieurs fois
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // $user = User::where('email', $credentials['email'])->first();

        // if ($user && $user->tokens()->count() > 0) {
        //     return response()->json(['message' => 'User is already authenticated'], 422);
        // }
        // 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken', expiresAt:now()->addDay())->plainTextToken;
    
            return response()->json([
                'message' => 'Logged in successfully',
                'authToken' => $token,
                'user' => $user,
                'roles' => $user->roles,
                'expires_in' => config('sanctum.expiration'), 
            ]);
        }
    
        return response()->json(['message' => 'Erreur lors de l\'authentification'], 401);


    }
    

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
