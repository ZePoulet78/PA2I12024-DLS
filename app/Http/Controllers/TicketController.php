<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOption\None;

class TicketController extends Controller
{
    public function index()
    {        
        $tickets = Ticket::all();

        // get the user for each ticket in json format
        $ticketsWithUser = $tickets->map(function($ticket) {
            $user = User::find($ticket->user_id);
            return [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'description' => $ticket->description,
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'assigned_to' => $ticket->assigned_to,
                'user' => $user
            ];
        });

        return response()->json(['tickets' => $ticketsWithUser], 200);
        
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

        $user = User::find($ticket->user_id);

        $tech = User::find($ticket->assigned_to);

        if(!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }


        return response()->json([
            'ticket'=>$ticket,
            'user'=>$user,
            'tech'=>$tech
        
        ]);
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
        
        if($ticket->assigned_to != null){
            return response()->json(['message' => 'Ticket already assigned'], 400);
        }

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

    public function getTicketByStatus($status)
    {
        $tickets = Ticket::where('status', $status)->get();
        return response()->json(['tickets' => $tickets], 200);
    }

    public function getTicketByPriority($priority)
    {
        $tickets = Ticket::where('priority', $priority)->get();
        return response()->json(['tickets' => $tickets], 200);
    }

    public function getTicketAttachments($id)
    {
        $ticket = Ticket::find($id);

        if(!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $attachments = $ticket->attachments()->get();

        return response()->json(['attachments' => $attachments], 200);
    }

    public function getTicketComments($id)
    {
        $ticket = Ticket::find($id);
    
        if(!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
    
        $comments = $ticket->comments()->with('user')->get();
    
        $commentsWithUser = $comments->map(function($comment) {
            return [
                'id' => $comment->id,
                'body' => $comment->body,
                'user' => $comment->user
            ];
        });
    
        return response()->json(['comments' => $commentsWithUser], 200);
    }
    

    public function getTicketByAssigned($tech_id)
    {
        $tickets = Ticket::where('assigned_to', $tech_id)->get();

        $user = User::find($tech_id);

        return response()->json([
            'tickets' => $tickets,
            'user' => $user
        ], 200);
    }

    public function getAssignedUser($id)
    {
        $ticket = Ticket::find($id);
    
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
    
        $user = $ticket->assignedTo;
    
        return response()->json(['user' => $user], 200);
    }
    

}
