<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {        
        $tickets = Ticket::all();
        return response()->json(['tickets' => $tickets], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'ticket_category_id' => 'required',
        ]);

        $data = $request->all();

        $ticket = new Ticket();
        $ticket->subject = $data['subject'];
        $ticket->description = $data['description'];
        $ticket->status = 'open';
        $ticket->user_id = $user->id;
        $ticket->ticket_category_id = $data['ticket_category_id'];
        $ticket->priority = 'low';
        $ticket->save();

        return response()->json($ticket, 201);
    }

    public function show($id)
    {

        $ticket = Ticket::find($id);
        return response()->json(['ticket'=>$ticket]);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->update($request->all());

        return response()->json($ticket, 200);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();

        return response()->json(['message'=>'Ticket deleted successfully'], 204);
    }


    public function getTicketByUser($user_id)
    {
        $user = User::findOrFail($user_id);

        $tickets = $user->tickets()->get();

        if(!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['tickets' => $tickets,
            'user' => $user]);
    }

    public function getTicketByCategory($category_id)
    {
        $tickets = Ticket::where('ticket_category_id', $category_id)->get();
        return response()->json(['tickets' => $tickets], 200);
    }

    public function changePriority(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $data = $request->all();

        $ticket->priority = $data['priority'];
        $ticket->save();

        return response()->json($ticket, 200);
    }

    public function assignTicket(Request $request, $id)
    {
        $user = Auth::user();

        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }

        $ticket = Ticket::find($id);

        $ticket->assigned_to = $user->id;
        $ticket->save();

        return response()->json($ticket, 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $data = $request->all();

        $ticket->status = $data['status'];
        $ticket->save();

        return response()->json($ticket, 200);
    }

    // get ticket by status
    public function getTicketByStatus($status)
    {
        $tickets = Ticket::where('status', $status)->get();
        return response()->json(['tickets' => $tickets], 200);
    }
}
