<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TicketCategory;

class TicketCatgoryController extends Controller
{
    public function index()
    {
        $ticketCategories = TicketCategory::all();
        return response()->json(['ticketCategories' => $ticketCategories], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $ticketCategory = new TicketCategory();
        $ticketCategory->name = $request->name;
        $ticketCategory->save();

        return response()->json($ticketCategory, 201);
    }

    public function show($id)
    {
        $ticketCategory = TicketCategory::find($id);
        return response()->json(['ticketCategory' => $ticketCategory]);
    }

    public function update(Request $request, $id)
    {
        $ticketCategory = TicketCategory::find($id);
        $ticketCategory->update($request->all());

        return response()->json($ticketCategory, 200);
    }


    public function destroy($id)
    {
        $ticketCategory = TicketCategory::find($id);
        $ticketCategory->delete();

        return response()->json(['message' => 'Ticket category deleted successfully'], 204);
    }

}
