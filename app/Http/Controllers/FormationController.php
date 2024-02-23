<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        // Récupérer toutes les formations depuis la base de données
        $formations = Formation::all();
        
        // Retourner la liste des formations au format JSON
        return response()->json($formations);
    }

    public function store(Request $request)
    {
        // Valider les données reçues du formulaire
        $request->validate([
            'nom' => 'required|string',
            'time' => 'required|string',
            'but' => 'required|string',
            'description' => 'required|string',
            'lieu' => 'required|string',
            // Ajoutez d'autres règles de validation au besoin
        ]);

        // Créer une nouvelle formation avec les données reçues et sauvegarder dans la base de données
        $formation = Formation::create($request->all());

        // Retourner la formation créée au format JSON
        return response()->json($formation);
    }

    public function show($id)
    {
        // Rechercher la formation avec l'ID spécifié
        $formation = Formation::findOrFail($id);

        // Retourner la formation trouvée au format JSON
        return response()->json($formation);
    }

    public function update(Request $request, $id)
    {
        // Rechercher la formation avec l'ID spécifié
        $formation = Formation::findOrFail($id);

        // Valider les données reçues du formulaire
        $request->validate([
            'nom' => 'string',
            'time' => 'string',
            'but' => 'string',
            'description' => 'string',
            'lieu' => 'string',
            // Ajoutez d'autres règles de validation au besoin
        ]);

        // Mettre à jour les données de la formation avec les données reçues
        $formation->update($request->all());

        // Retourner la formation mise à jour au format JSON
        return response()->json($formation);
    }

    public function destroy($id)
    {
        // Rechercher la formation avec l'ID spécifié
        $formation = Formation::findOrFail($id);
        
        // Supprimer la formation
        $formation->delete();

        // Retourner un message JSON indiquant que la formation a été supprimée avec succès
        return response()->json(['message' => 'Formation supprimée avec succès']);
    }
}
