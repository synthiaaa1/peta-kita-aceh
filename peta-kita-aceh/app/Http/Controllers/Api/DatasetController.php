<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dataset;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function index()
    {
        $datasets = Dataset::with(['category', 'agency', 'metadata', 'layers'])
            ->accessibleBy(auth()->user())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $datasets
        ]);
    }

    public function show($slug)
    {
        $dataset = Dataset::with(['category', 'agency', 'layers', 'metadata'])
            ->accessibleBy(auth()->user())
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $dataset
        ]);
    }

    public function indexV2(Request $request)
    {
        $query = Dataset::with(['category', 'agency', 'metadata', 'layers'])
            ->accessibleBy(auth()->user());

        if ($request->filled('q')) {
            $query->where('title', 'ilike', '%' . $request->q . '%');
        }
        
        if ($request->filled('agency')) {
            $query->whereHas('agency', fn($q) => $q->where('slug', $request->agency)->orWhere('id', $request->agency));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        
        $perPage = min(abs((int) $request->input('per_page', 15)), 100);
        $datasets = $query->paginate($perPage);

        return \App\Http\Resources\DatasetResource::collection($datasets);
    }

    public function showV2($slug)
    {
        $dataset = Dataset::with(['category', 'agency', 'layers', 'metadata'])
            ->accessibleBy(auth()->user())
            ->where('slug', $slug)
            ->firstOrFail();

        return new \App\Http\Resources\DatasetResource($dataset);
    }
}
