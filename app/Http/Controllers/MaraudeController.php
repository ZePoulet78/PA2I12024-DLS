<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maraude;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'ville' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $maraude = Maraude::create($validator->validated());

        return response()->json($maraude, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'ville' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $maraude = Maraude::findOrFail($id);
        $maraude->update($validator->validated());

        return response()->json($maraude, 200);
    }

    public function destroy($id)
    {
        $maraude = Maraude::findOrFail($id);
        $maraude->delete();

        return response()->json(null, 204);
    }
}
