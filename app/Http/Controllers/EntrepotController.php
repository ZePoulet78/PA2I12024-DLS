<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntrepotController extends Controller
{
    public function index()
    {
        $entrepots = Entrepot::all();
        return response()->json($entrepots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_entrepot' => 'required',
            'adresse_entrepot' => 'required',
            'superficie_entrepot' => 'required|numeric|min:0',
        ]);

        $entrepot = Entrepot::create($request->all());

        return response()->json($entrepot, 201);
    }

    public function show($id)
    {
        $entrepot = Entrepot::findOrFail($id);
        return response()->json($entrepot);
    }

    public function update(Request $request, $id)
    {
        $entrepot = Entrepot::findOrFail($id);

        $request->validate([
            'nom_entrepot' => 'required',
            'adresse_entrepot' => 'required',
            'superficie_entrepot' => 'required|numeric|min:0',
        ]);

        $entrepot->update($request->all());

        return response()->json($entrepot, 200);
    }

    public function destroy($id)
    {
        $entrepot = Entrepot::findOrFail($id);
        $entrepot->delete();
        return response()->json(null, 204);
    }
}
