<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function addUser(Request $request){

        $this->validate($request,[
            'role' => 'required|integer',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tel' => 'required|string|max:10',
        ]);

        $data = $request->all();

        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            return response()->json(['message' => 'User already exists'], 409);
        }

        
        $user = new User();
        $user->role = $data['role'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->tel = $data['tel'];
        $user->save();
        
        return response()->json(['message' => 'user created successfully', 'data' => $user], 201);
    }

    // fonction pour voir listé les users

    public function index()
    {
        $users = User::all();

        if (!$users) {
            return response()->json(['message' => 'Users not found'], 404);
        }

        return response()->json(['user' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $user]);
    }

    //fonction de modification

    public function update(Request $request, $id){

        $new = User::find($id);

        if(!$new){
            return response()->json(['message' => 'User not found', 404]);
        }

        $this->validate($request, [
            'role' => 'required|integer',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tel' => 'required|string|max:10',
        ]);

        $data = $request->all();
    
        $new->fill([
            'role' => $data['role'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tel' => $data['tel']
        ]);
        
        $new->save();
    
        return response()->json(['message' => 'User modified successfully', 'data' => $data], 201);

    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 201);
    }








}