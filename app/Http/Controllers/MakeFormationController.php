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
            'formation_id' => 'required|exists:formations,id|unique:make_activities,formation_id,NULL,id,user_id,' . $request->user_id,
        ]);

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
}
