<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function addActivity(Request $request){

        $this->validate($request,[
            'heure_debut' => 'required|date_format:HH:mm',
            'heure_fin' => 'required|date_format:HH:mm|after:heure_debut',
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();


        
        $act = new Activity();
        $act->heure_debut = $data['heure_debut'];
        $act->heure_fin = $data['heure_fin'];
        $act->date = $data['date'];
        $act->type = $data['type'];
        $act->description = $data['description'];
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

    //fonction de modification

    public function updateA(Request $request, $id){

        $new = Activity::find($id);

        if(!$new){
            return response()->json(['message' => 'activity not found', 404]);
        }

        $this->validate($request, [
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
    
        $new->fill([
            'heure_debut' => $data['heure_debut'],
            'heure_fin' => $data['heure_fin'],
            'date' => $data['date'],
            'type' => $data['type'],
            'description' => $data['description']
        ]);
        
        $new->save();
    
        return response()->json(['message' => 'Activity modified successfully', 'activity' => $data], 201);

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
}
