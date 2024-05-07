<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'title'=> 'required',
            'file' => 'required|file',
            'ticket_id' => 'required|exists:tickets,id'
        ]);

        $data = $request->all();
        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            Storage::disk('s3')->putFileAs('uploads/attachment/' . $data['ticket_id'], $file, $fileName, 'public');

            $attachment = new Attachment();
            $attachment->title = $request->title;
            $attachment->ticket_id = $ticketId;
            $attachment->save();

            $attachment->file = Storage::disk('s3')->url('uploads/attachment/' . $data['ticket_id'] . '/' . $fileName); 
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
