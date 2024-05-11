<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Warehouse;
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

    public function store(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);

        $this->validate($request, [
            'registration_number' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $data = $request->all();

        $vehicle = new Vehicle();
        $vehicle->registration_number = $data['registration_number'];
        $vehicle->model = $data['model'];
        $vehicle->year = $data['year'];
        $vehicle->warehouse_id = $warehouseId;
        $vehicle->save();

        return response()->json(['message' => 'Véhicule ajouté avec succès', 'data' => $vehicle], 201);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $warehouse = Warehouse::findOrFail($vehicle->warehouse_id);

        $this->validate($request, [
            'registration_number' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $data = $request->all();

        $vehicle->fill([
            'registration_number' => $data['registration_number'],
            'model' => $data['model'],
            'year' => $data['year'],
            'warehouse_id' => $data['warehouse_id'],
        ]);
        $vehicle->save();

        return response()->json(['message' => 'Véhicule modifié avec succès', 'data' => $vehicle], 200);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return response()->json(['message' => 'Véhicule supprimé avec succès'], 200);
    }
}