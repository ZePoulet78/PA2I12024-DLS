<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
                'date_debut' => 'required|date_format:Y-m-d',
                'date_fin' => 'required|date_format:Y-m-d|after_or_equal:date_debut',
                'time' => 'required|integer',
                'but' => 'required|string',
                'description' => 'required|string',
                'lieu' => 'required|string',
            ]);

            $today = Carbon::today()->format('Y-m-d');
            if ($request->date_debut < $today) {
                return response()->json(['message' => 'La date de la formation ne peut pas être antérieure à aujourd\'hui.'], 400);
            }

            $start = strtotime($request->date_debut . ' 00:00:00');
            $end = strtotime($request->date_fin . ' 23:59:59');
            $diff = ($end - $start) / (60 * 60); 
    
            if ($request->time > $diff) {
                return response()->json(['error' => 'Le temps spécifié dépasse la durée entre la date de début et la date de fin.'], 400);
            }

            $formation = Formation::create($request->all());
            return response()->json(['message' => 'Formation créée avec succès', 'formation' => $formation], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la création de la formation, veuillez remplir les champs correctement'], 500);
        }
    }

    public function show($id)
    {
        try {
            $formation = Formation::findOrFail($id);
            return response()->json(['formations' => $formation]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Formation non trouvée'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $formation = Formation::findOrFail($id);
            $request->validate([
                'nom' => 'required|string',
                'date_debut' => 'required|date_format:Y-m-d',
                'date_fin' => 'required|date_format:Y-m-d|after_or_equal:date_debut',
                'time' => 'required|integer',
                'but' => 'required|string',
                'description' => 'required|string',
                'lieu' => 'required|string',
            ]);

            // $today = Carbon::today()->format('Y-m-d');
            // if ($request->date_debut < $today) {
            //     return response()->json(['message' => 'La date de la formation ne peut pas être antérieure à aujourd\'hui.'], 400);
            // }

            $start = strtotime($request->date_debut . ' 00:00:00');
            $end = strtotime($request->date_fin . ' 23:59:59');
            $diff = ($end - $start) / (60 * 60); 
    
            if ($request->time > $diff) {
                return response()->json(['error' => 'Le temps spécifié dépasse la durée entre la date de début et la date de fin.'], 400);
            }
            
            $formation->update($request->all());
            return response()->json(['message' => 'Formation modifiée avec succès', 'formation' => $formation], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la modification de la formation'], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $formation = Formation::find($id);
            $formation->delete();
            return response()->json(['message' => 'Formation supprimée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite lors de la suppression de la formation'], 500);
        }
    }
}
