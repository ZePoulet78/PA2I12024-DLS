<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class Document extends Controller
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
            $filePath = 'proofs/' . $userId . '/' . $fileName; 

            
            if (!File::exists(public_path('proofs/' . $userId))) {
                File::makeDirectory(public_path('proofs/' . $userId), 0755, true);
            }

            $file->move(public_path($filePath), $fileName);

            
            $document = new Document();
            $document->user_id = $userId;
            $document->title = $request->title;
            $document->document = $filePath;
            $document->save();

            return response()->json(['success' => 'File uploaded successfully']);
        }

        return response()->json(['error' => 'No file uploaded or invalid file']);
    }
}