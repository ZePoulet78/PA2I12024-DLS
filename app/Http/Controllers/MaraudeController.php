<?php

namespace App\Http\Controllers;

use App\Models\Maraude;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Collect;
use App\Models\Vehicle;


class MaraudeController extends Controller
{
    public function index()
    {
        $maraudes = Maraude::all();

        foreach ($maraudes as $maraude) {
            $user = User::findOrFail($maraude->user_id);
            $vehicle = Vehicle::findOrFail($maraude->vehicle_id);
            $maraude->user = $user;
            $maraude->vehicle = $vehicle;
        }

        return response()->json(['maraudes'=>$maraudes]);
    }

    public function show($id)
    {
        $maraude = Maraude::findOrFail($id);

        $maraude->vehicle;

        $maraude->user;

        return response()->json(['maraude'=>$maraude]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'maraud_date' => 'required|date_format:Y-m-d',
            'departure_time' => 'required|date_format:H:i',
            'return_time' => 'required|date_format:H:i|after:departure_time',
            'vehicle_id' => 'required|exists:vehicles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->all();

        $user = User::findOrFail($data['user_id']);

        if (!$user->hasRole('Camionneur')) {
            return response()->json(['message' => $user], 400);
        }


        if (Carbon::parse($data['maraud_date'])->isPast()) {
            return response()->json(['message' => "La date est dans le passé"], 400);
        }


        $collect = Collect::where('id_user', $data['user_id'])
        ->where('date', $data['maraud_date'])
        ->first();

        if ($collect) {
            return response()->json(['message' => 'Le véhicule a déjà une collecte prévue ce jour'], 400);
        }

        $collect = Collect::where('id_vehicule', $data['vehicle_id'])
            ->where('date', $data['maraud_date'])
            ->first();

        if ($collect) {
            return response()->json(['message' => "L'utilisateur a déjà une collecte prévue ce jour"], 400);
        }

        $maraude = Maraude::where('user_id', $data['user_id'])
            ->where('maraud_date', $data['maraud_date'])
            ->first();

        if ($maraude) {
            return response()->json(['message' => 'Le chauffeur a déjà une maraude prévue ce jour'], 400);
        }

        $maraude = Maraude::where('vehicle_id', $data['vehicle_id'])
            ->where('maraud_date', $data['maraud_date'])
            ->first();


        if ($maraude) {
            return response()->json(['message' => 'Le véhicule a déjà une maraude prévue ce jour'], 400);
        }


        $maraude = new Maraude();
        $maraude->maraud_date = $data['maraud_date'];
        $maraude->departure_time = $data['departure_time'];
        $maraude->return_time = $data['return_time'];
        $maraude->vehicle_id = $data['vehicle_id'];
        $maraude->user_id = $data['user_id'];
        $maraude->itinerary = "Itinéraire non défini";
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
        ]);

        $data = $request->all();

        $maraude->fill([
            'maraud_date' => $data['maraud_date'],
            'departure_time' => $data['departure_time'],
            'return_time' => $data['return_time'],
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

    public function showMaraudesByUser($id)
    {
        $maraudes = Maraude::where('user_id', $id)->get();
        return response()->json(['maraudes' => $maraudes]);
    }

}