<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        if (!$roles) {
            return response()->json(['message' => 'Roles not found'], 404);
        }

        return response()->json($roles, 200);
    }

    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);

        $data = $request->all();

        $role = new Role();
        $role->name = $data['name'];
        $role->save();

        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);

        $data = $request->all();

        $role->name = $data['name'];
        $role->save();

        return response()->json(['message' => 'Role updated successfully', 'data' => $role], 200);
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
