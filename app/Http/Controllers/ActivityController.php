<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function addActivity(Request $request){

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->validate($request,[
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        $today = Carbon::today()->format('Y-m-d');
        if ($data['date'] < $today) {
            return response()->json(['message' => 'La date de l\'activité ne peut pas être antérieure à aujourd\'hui.'], 400);
        }


        
        $act = new Activity();
        $act->heure_debut = $data['heure_debut'];
        $act->heure_fin = $data['heure_fin'];
        $act->date = $data['date'];
        $act->type = $data['type'];
        $act->description = $data['description'];
        $act->user_id = $user->id;;
        $act->save();
    
        return response()->json(['message' => 'Activity created successfully', 'activity' => $act], 201);
    }


    public function indexA()
    {
        $act = Activity::all();

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        return response()->json(['activity' => $act]);
    }

    public function showA($id)
    {
        $act = Activity::find($id);

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }
        return response()->json(['activity' => $act]);
    }

 

    public function updateA(Request $request, $id)
    {
        $new = Activity::find($id);
    
        if (!$new) {
            return response()->json(['message' => 'activity not found'], 404);
        }
    
        $this->validate($request, [
            'heure_debut' => 'required|date_format:H:i:s',
            'heure_fin' => 'required|date_format:H:i:s|after:heure_debut',
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

    
        $data = $request->all();
        $heureDebut = Carbon::parse($data['heure_debut'])->format('H:i');
        $heureFin = Carbon::parse($data['heure_fin'])->format('H:i');
    
        $new->fill([
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
            'date' => $data['date'],
            'type' => $data['type'],
            'description' => $data['description']
        ]);
    
        $new->save();
    
        return response()->json([
            'message' => 'Activity modified successfully',
            'activity' => $data
        ], 201);
    }

    public function destroyA(Request $request, $id)
    {
        $act = Activity::find($id);

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        $act->delete();

        return response()->json(['message' => 'activity deleted successfully'], 201);
    }

    public function showUserActivities($id)
    {
        $act = Activity::where('user_id', $id)->get();

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        return response()->json(['activity' => $act]);
    }

    public function destroyUserActivities($id)
    {
        $user = Auth::user();

        $act = Activity::where('user_id', $id)->delete();

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        return response()->json(['message' => 'activity deleted successfully'], 201);
    }
    
}
