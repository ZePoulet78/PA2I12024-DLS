<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Formation;
use App\Models\MakeFormation;

class MakeFormationController extends Controller
{
    public function makeFormation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formations,id|unique:make_formations,formation_id,NULL,id,user_id,' . $request->user_id,
        ]);


        
        $newFormation = Formation::findOrFail($request->formation_id);

        $conflictingActivity = MakeActivity::join('activity', 'make_activity.activity_id', '=', 'activity.id')
            ->where('make_activity.user_id', $request->user_id)
            ->where('activity.date', $newFormation->date_debut)
            ->first();


        $conflictingFormation = MakeFormation::join('formations', 'make_formations.formation_id', '=', 'formations.id')
            ->where('make_formations.user_id', $request->user_id)
            ->whereDate('formations.date_debut', '<=', $newFormation->date_debut)
            ->whereDate('formations.date_fin', '>=', $newFormation->date_fin)
            ->orWhereBetween('formations.date_debut', [$newFormation->date_debut, $newFormation->date_fin])
            ->orWhereBetween('formations.date_fin', [$newFormation->date_debut, $newFormation->date_fin])
            ->first();


        if ($conflictingActivity || $conflictingFormation ) {
            return response()->json(['error' => 'L\'utilisateur a déjà une activité ou une formation prévue à la même date et heure'], 400);
        }

        $makeFormation = MakeFormation::create($request->all());

        return response()->json(['message' => 'MakeFormation créée avec succès', 'makeformations' => $makeFormation], 201);
    }

    public function indexMf()
    {
        $makeFormations = MakeFormation::all();

        return response()->json(['makeformations' => $makeFormations]);
    }

    public function showMf($id)
    {
        $makeFormation = MakeFormation::find($id);

        if (!$makeFormation) {
            return response()->json(['message' => 'MakeFormation non trouvée'], 404);
        }

        return response()->json(['makeformations' => $makeFormation]);
    }
    
    public function GetUserByIdFormation($formation_id)
    {
        $users = MakeFormation::where('formation_id', $formation_id)->get();
        if (!$users) {
            return response()->json(['message' => 'formation not found'], 404);
        }

        return response()->json(['users' => $users]);
    }

    public function GetFormationByIdUser($user_id)
    {
        $formations = MakeFormation::where('user_id', $user_id)->get();
        if (!$formations) {
            return response()->json(['message' => 'user not found'], 404);
        }

        return response()->json(['formations' => $formations]);
    } 
      
}
