<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Xử lý tải lên hình ảnh từ trình soạn thảo TinyMCE
     */
    public function uploadEditorImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('editor-images', $filename, 'public');
            
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }
        
        return response()->json([
            'error' => 'Tải lên ảnh thất bại'
        ], 422);
    }
}