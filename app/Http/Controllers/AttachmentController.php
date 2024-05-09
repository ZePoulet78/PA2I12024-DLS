<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
class AttachmentController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $request->validate([
            'title'=> 'required',
            'file' => 'required|file',
            // 'ticket_id' => 'required|exists:tickets,id'
        ]);

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'uploads/attachment/' . $ticketId . '/' . $fileName;

            Storage::disk('s3')->putFileAs('uploads/attachment/' . $ticketId, $file, $fileName, 'public');

            $attachment = new Attachment();
            $attachment->title = $request->title;
            $attachment->file = Storage::disk('s3')->url('uploads/attachment/' . $ticketId . '/' . $fileName);
            $attachment->ticket_id = $ticketId;
            $attachment->save();

        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }

        return response()->json(['message' => 'Attachment uploaded successfully'], 201);
    }

    public function show($id)
    {
        $attachment = Attachment::find($id);

        if (!$attachment) {
            return response()->json(['message' => 'Attachment not found'], 404);
        }

        return response()->json($attachment);
    }

    public function delete($id)
    {
        $attachment = Attachment::find($id);

        if (!$attachment) {
            return response()->json(['message' => 'Attachment not found'], 404);
        }

        Storage::disk('s3')->delete($attachment->file);
        $attachment->delete();

        return response()->json(['message' => 'Attachment deleted successfully']);
    }
}
