<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThematicMap;

class ThematicMapController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('visualization-type');
        
        $query = ThematicMap::where('status', 'published');
        
        if ($type === 'interactive' || $type === 'layout') {
            $query->where('type', $type);
        }

        $maps = $query->latest()->paginate(12);

        return view('tematik.index', compact('maps', 'type'));
    }
}
