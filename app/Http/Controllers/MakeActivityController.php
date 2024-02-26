<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MakeActivity;

class MakeActivityController extends Controller
{
    public function makeActivity(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activity,id',
        ]);

        $makeActivity = MakeActivity::create($request->all());

        return response()->json(['message' => 'MakeActivity créée avec succès', 'data' => $makeActivity], 201);
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
}
