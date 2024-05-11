<?php

namespace App\Http\Controllers;

use App\Models\HasRole;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class HasRoleController extends Controller
{
    public function assignRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            // 'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $role = Role::find($request->role_id);

        

        $data = $request->all();
        $hasRole = HasRole::where('role_id', $data['role_id'])
            ->where('user_id', $id)
            ->first();

        if ($hasRole) {
            return response()->json(['message' => 'Role already assigned to user'], 400);
        }

        $hasRole = new HasRole();
        $hasRole->role_id = $data['role_id'];
        $hasRole->user_id = $id;
        $hasRole->save();

        return response()->json(['message' => 'Role assigned to user successfully'], 201);
    }
}
