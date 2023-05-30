<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show() {
        return view('video.show');
    }

    public function download(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:254',
            'video' => 'required|file|mimetypes:video/mp4'
        ]);

        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/'. $fileName;
        $isFileUpload = Storage::disk('public')->put($filePath, file_get_contents($request->video));

        $url = Storage::disk('public')->url($fileName);

        if ($isFileUpload) {
            $video = new Vedeo();
            $video->title = $request->title;
            $video->path = $filePath;
            $video->save();
            return back()->with('success', 'видео загружено');
        }
        return back()->with('error', 'Не удалось загрузить видео');
    }
} 
