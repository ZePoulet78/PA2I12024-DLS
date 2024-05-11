<?php

namespace App\Http\Controllers;

use App\Models\Maraude;
use Illuminate\Http\Request;

class MaraudeController extends Controller
{
    public function index()
    {
        $maraudes = Maraude::all();
        return response()->json($maraudes);
    }

    public function show($id)
    {
        $maraude = Maraude::findOrFail($id);
        return response()->json($maraude);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'maraud_date' => 'required|date_format:Y-m-d',
            'departure_time' => 'required|date_format:H:i',
            'return_time' => 'required|date_format:H:i|after:departure_time',
            'itinerary' => 'required|string',
        ]);

        $data = $request->all();

        $maraude = new Maraude();
        $maraude->maraud_date = $data['maraud_date'];
        $maraude->departure_time = $data['departure_time'];
        $maraude->return_time = $data['return_time'];
        $maraude->itinerary = $data['itinerary'];
        $maraude->save();

        return response()->json(['message' => 'Maraude ajoutée avec succès', 'data' => $maraude], 201);
    }

    public function update(Request $request, $id)
    {
        $maraude = Maraude::findOrFail($id);

        $this->validate($request, [
            'maraud_date' => 'required|date',
            'departure_time' => 'required',
            'return_time' => 'required',
            'itinerary' => 'required|string',
        ]);

        $data = $request->all();

        $maraude->fill([
            'maraud_date' => $data['maraud_date'],
            'departure_time' => $data['departure_time'],
            'return_time' => $data['return_time'],
            'itinerary' => $data['itinerary'],
        ]);
        $maraude->save();

        return response()->json(['message' => 'Maraude modifiée avec succès', 'data' => $maraude], 200);
    }

    public function destroy($id)
    {
        $maraude = Maraude::findOrFail($id);
        $maraude->delete();
        return response()->json(['message' => 'Maraude supprimée avec succès'], 204);
    }
}