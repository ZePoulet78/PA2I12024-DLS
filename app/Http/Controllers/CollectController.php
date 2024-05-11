<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollectController extends Controller
{
    public function index()
    {
        $collects = Collect::all();
        return response()->json($collects);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'id_vehicule' => 'required|exists:vehicules,id',
            'id_user' => 'required|exists:users,id',
            'plan_de_route' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $collect = Collect::create($validator->validated());
        return response()->json($collect, 201);
    }

    public function show($id)
    {
        $collect = Collect::findOrFail($id);
        return response()->json($collect);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'id_vehicule' => 'required|exists:vehicules,id',
            'id_user' => 'required|exists:users,id',
            'plan_de_route' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $collect = Collect::findOrFail($id);
        $collect->update($validator->validated());
        return response()->json($collect, 200);
    }

    public function destroy($id)
    {
        $collect = Collect::findOrFail($id);
        $collect->delete();
        return response()->json(null, 200);
    }
}