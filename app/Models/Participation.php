<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participation;

class ParticipationController extends Controller
{
    public function index()
    {
        $participations = Participation::all();
        return response()->json($participations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_maraude' => 'required|exists:maraudes,id',
            'id_vehicule' => 'required|exists:vehicles,id',
            'id_user' => 'required|exists:users,id',
            // Ajoutez ici d'autres validations si nécessaire
        ]);

        $participation = Participation::create($request->all());

        return response()->json($participation, 201);
    }

    public function show($id)
    {
        $participation = Participation::findOrFail($id);
        return response()->json($participation);
    }

    public function update(Request $request, $id)
    {
        $participation = Participation::findOrFail($id);

        $request->validate([
            'id_maraude' => 'required|exists:maraudes,id',
            'id_vehicule' => 'required|exists:vehicles,id',
            'id_user' => 'required|exists:users,id',
            // Ajoutez ici d'autres validations si nécessaire
        ]);

        $participation->update($request->all());

        return response()->json($participation, 200);
    }

    public function destroy($id)
    {
        $participation = Participation::findOrFail($id);
        $participation->delete();
        return response()->json(null, 204);
    }
}