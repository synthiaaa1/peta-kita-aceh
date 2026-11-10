<?php

namespace App\Http\Controllers;

use App\Models\StoryMap;
use Illuminate\Http\Request;

class StoryMapController extends Controller
{
    public function index()
    {
        $storyMaps = StoryMap::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('story-maps.index', compact('storyMaps'));
    }

    public function show($slug)
    {
        $storyMap = StoryMap::with(['sections' => function($q) {
                $q->orderBy('order');
            }, 'author'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('story-maps.show', compact('storyMap'));
    }
}
