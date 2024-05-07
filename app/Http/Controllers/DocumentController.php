<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $this->validate($request, [
            'file' => 'required|file|mimes:pdf|max:2048',
            'title' => 'required|string'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::random(15) . '.pdf';
            $filePath = 'uploads/proofs/' . $userId . '/' . $fileName;

            Storage::disk('s3')->putFileAs('uploads/proofs/' . $userId, $file, $fileName, 'public');

            $document = new Document();
            $document->user_id = $userId;
            $document->title = $request->title;
            $document->document = $filePath;
            $document->save();

            return response()->json(['success' => 'File uploaded successfully']);
        }

        return response()->json(['error' => 'No file uploaded or invalid file']);
    }

    public function delete(Request $request){
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $document = Document::where('user_id', $userId)->where('id', $request->id)->first();

        if (!$document) {
            return response()->json(['error' => 'Document not found'], 404);
        }

        Storage::disk('s3')->delete($document->document);

        $document->delete();

        return response()->json(['success' => 'Document deleted successfully']);
    }
}