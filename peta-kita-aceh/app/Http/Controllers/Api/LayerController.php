<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\SpatialFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class LayerController extends Controller
{
    protected function isPostGisAvailable(): bool
    {
        try {
            $res = DB::select("SELECT 1 FROM pg_extension WHERE extname = 'postgis'");
            return !empty($res);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function geojson(Request $request, $id)
    {
        $layer = Layer::with(['dataset', 'style'])->findOrFail($id);

        // Verify dataset accessibility
        $accessibleDataset = Dataset::accessibleBy(auth()->user())->where('id', $layer->dataset_id)->first();
        if (!$accessibleDataset) {
            return response()->json([
                'message' => 'Akses terbatas atau dataset belum dipublikasikan.'
            ], 403);
        }

        // BBOX Validation
        $bbox = null;
        if ($request->filled('bbox')) {
            $parts = explode(',', $request->bbox);
            if (count($parts) === 4) {
                $minLng = (float) $parts[0];
                $minLat = (float) $parts[1];
                $maxLng = (float) $parts[2];
                $maxLat = (float) $parts[3];

                if ($minLng >= -180 && $minLng <= 180 &&
                    $maxLng >= -180 && $maxLng <= 180 &&
                    $minLat >= -90 && $minLat <= 90 &&
                    $maxLat >= -90 && $maxLat <= 90 &&
                    $minLng < $maxLng && $minLat < $maxLat) {
                    $bbox = [$minLng, $minLat, $maxLng, $maxLat];
                } else {
                    return response()->json(['message' => 'Format BBOX tidak valid atau di luar jangkauan (minLng,minLat,maxLng,maxLat)'], 422);
                }
            } else {
                return response()->json(['message' => 'BBOX harus memiliki tepat 4 koordinat'], 422);
            }
        }

        $isPostGis = $this->isPostGisAvailable();

        $districtCode = $request->district_code ?? 'all';
        $regencyCode = $request->regency_code ?? 'all';
        
        // Cache Key Privacy: if dataset is public, cache globally. 
        // For restricted, cache per agency to avoid duplication for users in same agency.
        // For private, cache per user.
        $user = auth()->user();
        if ($accessibleDataset->access_level === 'public') {
            $privacySalt = 'public';
        } elseif ($accessibleDataset->access_level === 'restricted') {
            $privacySalt = $user && $user->role === 'admin' ? 'admin_' . $user->id : 'agency_' . ($user->agency_id ?? 'none');
        } else {
            $privacySalt = 'user_' . ($user->id ?? 'none');
        }
        
        $bboxStr = $bbox ? implode('_', $bbox) : 'none';
        $cacheKey = "layer_{$id}_geojson_{$districtCode}_{$regencyCode}_pg_{$isPostGis}_bbox_{$bboxStr}_priv_{$privacySalt}";

        $featureCollection = Cache::remember($cacheKey, now()->addHours(24), function () use ($id, $request, $isPostGis, $bbox) {
            $query = DB::table('spatial_features')
                ->where('layer_id', $id)
                ->whereNotNull('geom');

            if ($request->filled('district_code')) {
                if ($isPostGis) {
                    $query->whereRaw("properties->>'district_code' = ?", [$request->district_code]);
                } else {
                    $query->where('properties', 'like', '%"district_code":"' . $request->district_code . '"%');
                }
            }

            if ($request->filled('regency_code')) {
                if ($isPostGis) {
                    $query->whereRaw("properties->>'regency_code' = ?", [$request->regency_code]);
                } else {
                    $query->where('properties', 'like', '%"regency_code":"' . $request->regency_code . '"%');
                }
            }
            
            if ($isPostGis && $bbox) {
                // ST_MakeEnvelope(xmin, ymin, xmax, ymax, srid)
                $query->whereRaw("ST_Intersects(geom, ST_MakeEnvelope(?, ?, ?, ?, 4326))", $bbox);
            }

            // Fetch LIMIT + 1 to detect truncation
            $limit = 8000;
            $query->limit($limit + 1);

            if ($isPostGis) {
                $features = $query->select('id', 'properties', DB::raw('ST_AsGeoJSON(geom) as geometry'))->get();
            } else {
                $features = $query->select('id', 'properties', 'geom as geometry')->get();
            }

            $isTruncated = false;
            if ($features->count() > $limit) {
                $isTruncated = true;
                $features->pop(); // Remove the extra feature
            }

            return [
                'type' => 'FeatureCollection',
                'truncated' => $isTruncated,
                'features' => $features->map(function ($feature) {
                    $geom = is_string($feature->geometry) ? json_decode($feature->geometry, true) : $feature->geometry;
                    return [
                        'type' => 'Feature',
                        'id' => $feature->id,
                        'properties' => is_string($feature->properties) ? json_decode($feature->properties, true) : ($feature->properties ?? []),
                        'geometry' => $geom
                    ];
                })
            ];
        });

        return response()->json($featureCollection);
    }

    public function downloadGeoJson(Request $request, $id)
    {
        $layer = Layer::with('dataset')->findOrFail($id);

        // Verify dataset accessibility
        $accessibleDataset = Dataset::accessibleBy(auth()->user())->where('id', $layer->dataset_id)->first();
        if (!$accessibleDataset) {
            abort(403, 'Akses terbatas atau dataset belum dipublikasikan.');
        }

        // Record download log (with anti-spam protection)
        try {
            $ip = $request->ip();
            $userId = auth()->id();
            
            // Anti-spam: check if downloaded in the last 5 minutes by the same IP or User
            $recentDownload = \App\Models\DatasetDownload::where('dataset_id', $layer->dataset_id)
                ->where(function($q) use ($ip, $userId) {
                    $q->where('ip_address', $ip);
                    if ($userId) {
                        $q->orWhere('user_id', $userId);
                    }
                })
                ->where('created_at', '>=', now()->subMinutes(5))
                ->first();

            if (!$recentDownload) {
                \App\Models\DatasetDownload::create([
                    'dataset_id' => $layer->dataset_id,
                    'layer_id' => $layer->id,
                    'user_id' => $userId,
                    'ip_address' => $ip,
                    'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                    'downloaded_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Failed recording dataset download: " . $e->getMessage());
        }

        if ($this->isPostGisAvailable()) {
            $features = DB::select("
                SELECT properties, ST_AsGeoJSON(geom) as geometry 
                FROM spatial_features 
                WHERE layer_id = ?
            ", [$id]);
        } else {
            $features = DB::select("
                SELECT properties, geom as geometry 
                FROM spatial_features 
                WHERE layer_id = ?
            ", [$id]);
        }

        $geoJson = [
            "type" => "FeatureCollection",
            "features" => []
        ];

        foreach ($features as $f) {
            $props = is_string($f->properties) ? json_decode($f->properties) : $f->properties;
            $geom = is_string($f->geometry) ? json_decode($f->geometry) : $f->geometry;
            $geoJson['features'][] = [
                "type" => "Feature",
                "properties" => $props,
                "geometry" => $geom
            ];
        }

        $filename = \Illuminate\Support\Str::slug($layer->name) . '.geojson';

        return response()->streamDownload(function () use ($geoJson) {
            echo json_encode($geoJson, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }, $filename, [
            'Content-Type' => 'application/geo+json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }
}
