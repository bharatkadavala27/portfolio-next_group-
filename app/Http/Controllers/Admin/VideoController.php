<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


// app/Http/Controllers/Admin/VideoController.php
class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('admin.youtube.create', compact('videos'));
    }

    public function create()
    {
        return view('admin.youtube.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_embed_code' => 'required|string',
        ]);

        Video::create($request->only('title', 'youtube_embed_code'));
        return redirect()->route('videos.index')->with('success', 'Video Added Successfully');
    }

    public function edit(Video $video)
    {
        return view('admin.youtube.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_embed_code' => 'required|string',
        ]);

        $video->update($request->only('title', 'youtube_embed_code'));
        return redirect()->route('videos.index')->with('success', 'Video Updated Successfully');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video Deleted Successfully');
    }
}
