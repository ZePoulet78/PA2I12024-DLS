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

    public function deleteRole($role_id, $user_id)
    {

        $hasRole = HasRole::where('role_id', $role_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$hasRole) {
            return response()->json(['message' => 'Role not assigned to user'], 404);
        }

        $hasRole->delete();

        return response()->json(['message' => 'Role deleted from user successfully'], 201);

    }

    public function showRoles($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $roles = $user->roles;

        return response()->json(['roles' => $roles], 200);
    }

    public function showUsers($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $users = $role->users;

        return response()->json(['users' => $users], 200);
    }
}
