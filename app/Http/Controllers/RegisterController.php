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

        
        $user = new Demande();
        $user->role = $data['role'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->tel = $data['tel'];
        $user->avatar = $data['avatar'];
        $user->save();
        
        return response()->json(['message' => 'demand to create acount sent successfully', 'data' => $user], 201);
    }

    public function approveUser(Request $request, $id){

        $demande = Demande::find($id);
        if (!$demande) {
            return response()->json(['message' => 'Demand not found'], 404);
        }

        $userD = [
            'role' => $demande->role,
            'firstname' => $demande->firstname,
            'lastname' => $demande->lastname,
            'email' => $demande->email,
            'password' => $demande->password, 
            'tel' => $demande->tel,
            'avatar' => $demande->avatar,
        ];
    
        $user = User::create($userD);
    
        return response()->json(['message' => 'User approved successfully', 'data' => $user], 200);
        $demande->delete();

    }

    public function rejectUser(Request $request, $demandeId){
    
        $demande = Demande::find($demandeId);

        if (!$demande) {
            return response()->json(['message' => 'Demand not found'], 404);
        }

        $demande->delete();

        return response()->json(['message' => 'User rejected successfully'], 200);
        
    }


    public function indexRegister(){
        $users = Demande::all();

        if (!$users) {
            return response()->json(['message' => 'Demands not found'], 404);
        }

        return response()->json(['user' => $users]);
}

    public function showRegister($id){
        
        $user = Demande::find($id);

        if (!$user) {
            return response()->json(['message' => 'Demand not found'], 404);
        }
        return response()->json(['user' => $user]);
}

}


    
