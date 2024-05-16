<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceBenevolat;
use Illuminate\Support\Facades\Auth;

class ServiceBenevolatController extends Controller
{
    public function addVolunteering(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date_format:Y-m-d',
            'heure' => 'required|date_format:H:i',
        ]);

        $data = $request->all();

        $volunteering = new ServiceBenevolat();
        $volunteering->fill($data); 
        $volunteering->date = $data['date'];
        $volunteering->heure = $data['heure'];
        $volunteering->id_beneficiary = $user->id;
        $volunteering->save();

        return response()->json(['message' => 'Bénévolat créé avec succès', 'volunteering' => $volunteering], 201);
    }

    public function getVolunteeringsByUser()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $volunteerings = ServiceBenevolat::where('id_beneficiary', $user->id)->get();

        return response()->json(['volunteerings' => $volunteerings, 'user' => $user]);
    }

    public function index()
    {
        $volunteerings = ServiceBenevolat::all();

        return response()->json(['volunteerings' => $volunteerings]);
    }

    public function show($id)
    {
        $volunteering = ServiceBenevolat::find($id);

        if (!$volunteering) {
            return response()->json(['message' => 'Bénévolat non trouvé'], 404);
        }

        return response()->json(['volunteering' => $volunteering]);
    }


    public function update(Request $request, $id)
    {
        $volunteering = ServiceBenevolat::find($id);

        if (!$volunteering) {
            return response()->json(['message' => 'Service non trouvé'], 404);
        }

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date_format:Y-m-d',
            'heure' => 'required|date_format:H:i',
        ]);

        $data = $request->all();
        $volunteering->fill($data);
        $volunteering->save();

        return response()->json([
            'message' => 'Service modifié avec succès',
            'volunteering' => $volunteering
        ], 200);
    }

    public function destroy($id)
    {
        $volunteering = ServiceBenevolat::find($id);

        if (!$volunteering) {
            return response()->json(['message' => 'Service non trouvé'], 404);
        }

        $volunteering->delete();

        return response()->json(['message' => 'Service supprimé avec succès'], 200);
    }

    public function joinVolunteering(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $volunteering = ServiceBenevolat::find($id);

        if (!$volunteering) {
            return response()->json(['message' => 'Service non trouvé'], 404);
        }

        if($volunteering->id_volunteer) {
            return response()->json(['message' => 'Ce service est deja pris en charge'], 400);
        }


        //$volunteering->id_volunteer = $user->id;
        $volunteering->update(['id_volunteer' => $user->id]);

        return response()->json(['message' => 'Vous avez rejoint le bénévolat avec succès'], 200);
    }

    public function leaveVolunteering($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $volunteering = ServiceBenevolat::find($id);

        if (!$volunteering) {
            return response()->json(['message' => 'Service non trouvé'], 404);
        }

        if ($volunteering->id_volunteer !== $user->id) {
            return response()->json(['message' => 'Vous n\'êtes pas autorisé à vous désinscrire de ce service'], 403);
        }

        $volunteering->update(['id_volunteer' => null]);

        return response()->json(['message' => 'Vous vous êtes désinscrit du bénévolat avec succès'], 200);
    }

    public function getVolunteerServices()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $volunteerServices = ServiceBenevolat::where('id_volunteer', $user->id)->get();

        return response()->json(['volunteerServices' => $volunteerServices]);
    }


}
