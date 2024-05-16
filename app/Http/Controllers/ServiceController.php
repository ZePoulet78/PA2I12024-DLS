<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            return response()->json(['message' => 'Services not found'], 404);
        }

        return response()->json(['services' => $services], 200);
    }

    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        return response()->json(['service' => $service], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',

        ]);

        $data = $request->all();

        $service = new Service();
        $service->name = $data['name'];
        $service->save();

        return response()->json(['message' => 'Service created successfully', 'data' => $service], 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',

        ]);

        $data = $request->all();

        $service->name = $data['name'];
        $service->save();

        return response()->json(['message' => 'Service updated successfully', 'data' => $service], 200);
    }

    public function delete($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully'], 200);
    }
}
