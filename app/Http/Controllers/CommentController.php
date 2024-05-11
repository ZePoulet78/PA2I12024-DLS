<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

        $user = $comment->user;

        return response()->json([
            'comment' => $comment,
            'user' => $user    
        ], 200);
    }

    public function store(Request $request, $ticketId)
    {
        $user = Auth::user();

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
            'user_id' => $user->id
        ]);

        return response()->json([
            'comment' => $comment,
            'user' => $user,
    ], 201);
    }

    public function destroy($ticketId, $commentId)
    {
        $comment = Comment::where('ticket_id', $ticketId)->where('id', $commentId)->first();

        if($comment) {
            $comment->delete();
            return response()->json(['message' => 'Comment deleted'], 200);
        }

        return response()->json(['message' => 'Comment not found'], 404);
    }
}
