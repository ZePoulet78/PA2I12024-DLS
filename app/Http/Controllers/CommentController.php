<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($ticketId)
    {
        $comments = Comment::where('ticket_id', $ticketId)->get();
        return response()->json($comments);
    }

    public function show($ticketId, $commentId)
    {
        $comment = Comment::where('ticket_id', $ticketId)->where('id', $commentId)->first();
        return response()->json($comment);
    }

    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $ticket = Ticket::find($ticketId);

        if($ticket->status === 'closed') {
            return response()->json(['message' => 'Ticket is closed'], 400);
        }

        $comment = Comment::create([
            'body' => $request->input('body'),
            'ticket_id' => $ticketId,
        ]);

        return response()->json($comment, 201);
    }
}
