<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\makeFormation;

class MakeFormationController extends Controller
{
    public function makeFormation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'formation_id' => 'required|exists:formation,id',
        ]);

        $makeFormation = MakeFormation::create($request->all());

        return response()->json(['message' => 'MakeFormation créée avec succès', 'data' => $makeFormation], 201);
    }

    public function indexMf()
    {
        $for = makeFormation::all();

        if (!$for) {
            return response()->json(['message' => 'formation not found'], 404);
        }

        return response()->json(['formation' => $for]);
    }

    public function showMf($id)
    {
        $for = makeFormation::find($id);

        if (!$for) {
            return response()->json(['message' => 'formation not found'], 404);
        }
        return response()->json(['formation' => $for]);
    }
}

