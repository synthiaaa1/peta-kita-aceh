<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoryMap;
use Illuminate\Http\Request;

class StoryMapController extends Controller
{
    public function index()
    {
        $storyMaps = StoryMap::with('author')
            ->where('status', 'published')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $storyMaps
        ]);
    }

    public function show($slug)
    {
        $storyMap = StoryMap::with(['author', 'sections'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $storyMap
        ]);
    }

    public function showPage($slug)
    {
        $storyMap = StoryMap::with(['author', 'sections'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('story-map', compact('storyMap'));
    }
}
