<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class EntrepotController extends Controller
{
    public function index()
    {
        $entrepots = Warehouse::all();
        return response()->json($entrepots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'max_capacity' => 'required|numeric|min:0',
        ]);

        try {
            $entrepot = Warehouse::create([
                'name' => $request->name,
                'address' => $request->address,
                'max_capacity' => $request->max_capacity,
                'actual_capacity' => $request->max_capacity,
            ]);
    
            return response()->json($entrepot, 201);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Failed to create warehouse.'], 500);
        }
    }
    

    public function show($id)
    {
        $entrepot = Warehouse::findOrFail($id);
        return response()->json($entrepot);
    }

    public function update(Request $request, $id)
    {
        $entrepot = Warehouse::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'max_capacity' => 'required|numeric|min:0',
        ]);

        $actual_capacity = $entrepot->actual_capacity + ($request->max_capacity - $entrepot->max_capacity);
        $entrepot->update([
            'name' => $request->name,
            'address' => $request->address,
            'max_capacity' => $request->max_capacity,
            'actual_capacity' => $actual_capacity, 
        ]);

        return response()->json($entrepot, 200);
    }

    public function destroy($id)
    {
        $entrepot = Warehouse::findOrFail($id);
        $entrepot->delete();
        return response()->json(['message' => 'Delete with success.'], 200);
    }
}