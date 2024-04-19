<?php

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'immatriculation' => 'required|unique:vehicles',
            'modele' => 'required',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            'id_entrepot' => 'required|exists:warehouses,id',
        ]);

        $vehicle = Vehicle::create($request->all());

        return response()->json($vehicle, 201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'immatriculation' => 'required|unique:vehicles,immatriculation,'.$vehicle->id,
            'modele' => 'required',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            'id_entrepot' => 'required|exists:warehouses,id',
        ]);

        $vehicle->update($request->all());

        return response()->json($vehicle, 200);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return response()->json(null, 204);
    }
}