<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;


class FormationController extends Controller
{
    public function index()
    {
        try {
            $formations = Formation::all(); 
            return response()->json(['formations' => $formations]); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la récupération des formations'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string',
                'time' => 'required|string',
                'but' => 'required|string',
                'description' => 'required|string',
                'lieu' => 'required|string'
            ]);
            $formation = Formation::create($request->all());
            return response()->json(['message' => 'Formation créée avec succès', 'data' => $formation], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la création de la formation'], 500);
        }
    }

    public function show($id)
    {
        try {
            $formation = Formation::findOrFail($id);
            return response()->json(['formation' => $formation]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Formation non trouvée'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $formation = Formation::findOrFail($id);
            $request->validate([
                'nom' => 'string',
                'time' => 'string',
                'but' => 'string',
                'description' => 'string',
                'lieu' => 'string',
            ]);
            $formation->update($request->all());
            return response()->json(['message' => 'Formation modifiée avec succès', 'data' => $formation], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la modification de la formation'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $formation = Formation::findOrFail($id);
            $formation->delete();
            return response()->json(['message' => 'Formation supprimée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la suppression de la formation'], 500);
        }
    }
}
