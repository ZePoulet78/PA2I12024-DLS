<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Vehicle;


class CollectController extends Controller
{
    public function index()
    {
        $collects = Collect::all();

        foreach ($collects as $collect) {
            $user = User::findOrFail($collect->id_user);
            $vehicle = Vehicle::findOrFail($collect->id_vehicule);
            $collect->user = $user;
            $collect->vehicle = $vehicle;
        }

        return response()->json(['collects'=>$collects], 200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'id_vehicule' => 'required|exists:vehicles,id',
            'id_user' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::findOrFail($request->id_user);

        if ($user->hasRole(2)) {
            return response()->json(['message' => "L'utilisateur n'est pas un cammionneur"], 403);
        }

        if (Carbon::parse($request->date)->isPast()) {
            return response()->json(['message' => "La date est dans le passé"], 400);
        }


        $collect = Collect::where('id_user', $request->id_user)
        ->where('date', $request->date)
        ->first();

        if ($collect) {
            return response()->json(['message' => 'Le véhicule a déjà une collecte prévue ce jour'], 400);
        }

        $collect = Collect::where('id_vehicule', $request->id_vehicule)
            ->where('date', $request->date)
            ->first();

        if ($collect) {
            return response()->json(['message' => "L'utilisateur a déjà une collecte prévue ce jour"], 400);
        }



        
        $collect = new Collect();
        $collect->date = $request->date;
        $collect->id_vehicule = $request->id_vehicule;
        $collect->id_user = $request->id_user;
        $collect->plan_de_route = '';
        $collect->save();
        return response()->json($collect, 201);
    }

    public function show($id)
    {
        $collect = Collect::findOrFail($id);

        $user = User::findOrFail($collect->id_user);

        $vehicle = Vehicle::findOrFail($collect->id_vehicule);




        return response()->json(['collect' => $collect, 'user' => $user, 'vehicle' => $vehicle], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'id_vehicule' => 'required|exists:vehicles,id',
            'id_user' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::findOrFail($request->id_user);

        if ($user->hasRole(2)) {
            return response()->json(['message' => 'L\'utilisateur n\'est pas un cammionneur'], 403);
        }

        if (Carbon::parse($request->date)->isPast()) {
            return response()->json(['message' => 'La date est dans le passé'], 400);
        }


        $collect = Collect::where('id_user', $request->id_user)
        ->where('date', $request->date)
        ->first();

        if ($collect) {
            return response()->json(['message' => 'Le véhicule a déjà une collecte prévue ce jour'], 400);
        }

        $collect = Collect::where('id_vehicule', $request->id_vehicule)
            ->where('date', $request->date)
            ->first();

        if ($collect) {
            return response()->json(['message' => "L'utilisateur a déjà une collecte prévue ce jour"], 400);
        }


        $collect = Collect::findOrFail($id);
        $collect->update($validator->validated());
        return response()->json($collect, 200);
    }

    public function destroy($id)
    {
        $collect = Collect::findOrFail($id);
        $collect->delete();
        return response()->json(null, 200);
    }

    public function getUsersCollects($id)
    {
        $collects = Collect::where('id_user', $id)->get();
        return response()->json($collects);
    }

    public function addRoutePlan($id, Request $request)
    {
        $collect = Collect::findOrFail($id);

        $this->validate($request, [
            'plan_de_route' => 'required|string'
        ]);

        $collect->plan_de_route = $request->plan_de_route;
        $collect->save();


        return response()->json($collect, 200);
    } 
}