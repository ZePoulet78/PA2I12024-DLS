<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function resgisterUser(Request $request){

        $this->validate($request,[
            'role' => 'integer|string',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tel' => 'required|string|max:10',
            'avatar' => 'nullable|string|max:255'
        ]);

        $data = $request->all();

        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            return response()->json(['message' => 'email already used'], 409);
        }

        
        $user = new User();
        $user->role = $data['role'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->tel = $data['tel'];
        $user->avatar = $data['avatar'] ?? null;

        $user->isRegistered = 0;

        $user->save();
        
        return response()->json(['message' => 'demand to create acount sent successfully', 'data' => $user], 201);
    }

    public function approveUser(Request $request, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->isRegistered = 1;
        $user->save();
    
        return response()->json(['message' => 'User approved successfully', 'data' => $user], 200);
    }

    public function rejectUser(Request $request, $demandeId){
    
        $demande = User::find($demandeId);

        if (!$demande) {
            return response()->json(['message' => 'Demand not found'], 404);
        }

        $demande->delete();

        return response()->json(['message' => 'User rejected successfully'], 200);
        
    }


    public function indexRegister(){
        $users = User::where('isRegistered', 0)->get();
        if (!$users) {
            return response()->json(['message' => 'Demands not found'], 404);
        }

        return response()->json(['user' => $users]);
}

    public function showRegister($id){
        
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Demand not found'], 404);
        }
        return response()->json(['user' => $user]);
}

}