<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MakeActivity;
use App\Models\MakeFormation;
use App\Models\Activity;

class MakeActivityController extends Controller
{
    public function makeActivity(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activity,id',
        ]);

        $newActivity = Activity::findOrFail($request->activity_id);

        $conflictingActivity = MakeActivity::join('activity', 'make_activity.activity_id', '=', 'activity.id')
            ->where('make_activity.user_id', $request->user_id)
            ->where('activity.date', $newActivity->date)
            ->where('activity.heure_debut', '<', $newActivity->heure_fin)
            ->where('activity.heure_fin', '>', $newActivity->heure_debut)
            ->first();


        $conflictingFormation = MakeFormation::join('formations', 'make_formations.formation_id', '=', 'formations.id')
            ->where('make_formations.user_id', $request->user_id)
            ->whereDate('formations.date_debut', '<=', $newActivity->date)
            ->whereDate('formations.date_fin', '>=', $newActivity->date)
            ->orWhereDate('formations.date_fin', $newActivity->date)
            ->first();


        if ($conflictingActivity || $conflictingFormation ) {
            return response()->json(['error' => "L'utilisateur a déjà une activité ou une formation prévue à la même date et heure"], 400);
        }

        if($newActivity->actual_users >= $newActivity->max_users){
            return response()->json(['error' => "L'activité est déjà pleine"], 400);
        }

        $newActivity->actual_users += 1;

        $newActivity->save();

        $makeActivity = MakeActivity::create($request->all());

        return response()->json(['message' => 'Activité rejointe avec succès', 'data' => $makeActivity], 201);
    }

    public function indexMa()
    {
        $act = makeActivity::all();

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        return response()->json(['activity' => $act]);
    }

    public function showMa($id)
    {
        $act = makeActivity::find($id);

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }
        return response()->json(['activity' => $act]);
    }

    public function GetUsersIdByActivityId($activity_id)
    {
        $users = MakeActivity::where('activity_id', $activity_id)->get();

        if (!$users) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        return response()->json(['users' => $users]);
    }

    public function GetActivityIdByUserId($user_id)
    {
        $activities = MakeActivity::where('user_id', $user_id)->get();

        if (!$activities) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        foreach ($activities as $activity) {
            $activity->activity = Activity::find($activity->activity_id);
        }

        return response()->json(['activity' => $activities]);
    }

    public function delete($id)
    {
        $act = MakeActivity::find($id);
        
        

        if (!$act) {
            return response()->json(['message' => 'activity not found'], 404);
        }

        $activity = Activity::find($act->activity_id);

        $activity->actual_users -= 1;

        $activity->save();

        $act->delete();

        return response()->json(['message' => 'activity deleted successfully'], 200);
    }
}
