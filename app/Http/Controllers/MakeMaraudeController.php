<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maraude;
use App\Models\MakeMaraude;
use App\Models\Activity;
use App\Models\MakeActivity;
use App\Models\Formation;
use App\Models\MakeFormation;

class MakeMaraudeController extends Controller
{
    public function makeMaraude(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'maraude_id' => 'required|exists:maraude,id|unique:make_maraudes,maraude_id,NULL,id,user_id,' . $request->user_id,
        ]);

        $maraude = Maraude::findOrFail($request->maraude_id);

        $conflictingActivity = MakeActivity::join('activity', 'make_activity.activity_id', '=', 'activity.id')
            ->where('make_activity.user_id', $request->user_id)
            ->where('activity.date', $maraude->maraud_date)
            ->where('activity.heure_debut', '<', $maraude->return_time)
            ->where('activity.heure_fin', '>', $maraude->departure_time)
            ->first();

        $conflictingFormation = MakeFormation::join('formations', 'make_formations.formation_id', '=', 'formations.id')
            ->where('make_formations.user_id', $request->user_id)
            ->whereDate('formations.date_debut', '<=', $maraude->maraud_date)
            ->whereDate('formations.date_fin', '>=', $maraude->maraud_date)
            ->orWhereBetween('formations.date_debut', [$maraude->maraud_date, $maraude->maraud_date])
            ->orWhereBetween('formations.date_fin', [$maraude->maraud_date, $maraude->maraud_date])
            ->first();


        $conflictingMakeMaraude = MakeMaraude::join('maraude', 'make_maraudes.maraude_id', '=', 'maraude.id')
            ->where('make_maraudes.user_id', $request->user_id)
            ->where('maraude.maraud_date', $maraude->maraud_date)
            ->where(function ($query) use ($maraude) {
                $query->where('maraude.departure_time', '<', $maraude->return_time)
                    ->where('maraude.return_time', '>', $maraude->departure_time);
            })
            ->first();

        if ($conflictingActivity || $conflictingFormation || $conflictingMakeMaraude) {
            return response()->json(['error' => 'L\'utilisateur a déjà une activité, une formation ou une maraude prévue à la même date et heure'], 400);
        }

        $makeMaraude = MakeMaraude::create($request->all());

        return response()->json(['message' => 'MakeMaraude créée avec succès', 'data' => $makeMaraude], 201);
    }

    public function index()
    {
        $makeMaraudes = MakeMaraude::all();

        return response()->json(['makeMaraudes' => $makeMaraudes]);
    }

    public function show($id)
    {
        $makeMaraude = MakeMaraude::find($id);

        if (!$makeMaraude) {
            return response()->json(['message' => 'MakeMaraude non trouvée'], 404);
        }

        return response()->json(['makeMaraude' => $makeMaraude]);
    }

    public function getUsersByMaraudeId($maraude_id)
    {
        $users = MakeMaraude::where('maraude_id', $maraude_id)->get();

        if (!$users) {
            return response()->json(['message' => 'Maraude not found'], 404);
        }

        return response()->json(['users' => $users]);
    }

    public function getMaraudesByUserId($user_id)
    {
        $maraudes = MakeMaraude::where('user_id', $user_id)->get();

        if (!$maraudes) {
            return response()->json(['message' => 'User not found'], 404);
        }


        foreach ($maraudes as $maraude) {
            $maraude->maraude = Maraude::find($maraude->maraude_id);
        }


        return response()->json(['maraudes' => $maraudes]);
    }


    public function destroy($user_id, $maraude_id)
    {
        $makeMaraude = MakeMaraude::where('user_id', $user_id)->where('maraude_id', $maraude_id)->first();

        if (!$makeMaraude) {
            return response()->json(['message' => 'Maraude non trouvée'], 404);
        }

        $makeMaraude->delete();

        return response()->json(['message' => 'Désinscrit avec succès'], 201);
    }

    public function checkUserMaraude($user_id, $maraude_id)
    {
        $makeMaraude = MakeMaraude::where('user_id', $user_id)->where('maraude_id', $maraude_id)->first();

        if ($makeMaraude) {
            return response()->json(['message' => true], 200);
        }

        return response()->json(['message' => false], 404);
    }
    
}
