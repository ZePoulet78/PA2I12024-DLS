<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json($vehicle);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $vehicle = Vehicle::create($validator->validated());
        return response()->json($vehicle, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($validator->validated());
        return response()->json($vehicle, 200);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return response()->json(null, 204);
    }
}