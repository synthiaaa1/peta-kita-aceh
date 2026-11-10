<?php

namespace App\Services\Spatial;

use App\Models\Layer;
use App\Models\SpatialFeature;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeoConversionService
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

    /**
     * Parse GeoJSON string and insert into spatial_features table
     */
    public function importGeoJson(Layer $layer, string $geoJsonContent): array
    {
        try {
            $data = json_decode($geoJsonContent, true);
            
            if (!$data || !isset($data['type']) || $data['type'] !== 'FeatureCollection') {
                throw new \Exception('Invalid GeoJSON format. Expected FeatureCollection.');
            }

            $insertedCount = 0;
            $features = $data['features'] ?? [];
            $hasPostGis = $this->isPostGisAvailable();

            DB::beginTransaction();

            // Delete old features for this layer if overwriting
            SpatialFeature::where('layer_id', $layer->id)->delete();

            foreach ($features as $feature) {
                if (!isset($feature['geometry']) || empty($feature['geometry'])) {
                    continue; // Skip invalid individual geometries, but we'll check total at the end
                }
                
                // Extra validation: ensure it has type and coordinates
                if (!isset($feature['geometry']['type']) || !isset($feature['geometry']['coordinates'])) {
                    continue;
                }

                $geometryJson = json_encode($feature['geometry']);
                $propertiesJson = json_encode($feature['properties'] ?? []);

                if ($hasPostGis) {
                    DB::statement(
                        'INSERT INTO spatial_features (layer_id, geom, properties, created_at, updated_at) 
                         VALUES (?, ST_SetSRID(ST_GeomFromGeoJSON(?), 4326), ?::jsonb, NOW(), NOW())',
                        [$layer->id, $geometryJson, $propertiesJson]
                    );
                } else {
                    DB::table('spatial_features')->insert([
                        'layer_id' => $layer->id,
                        'geom' => $geometryJson,
                        'properties' => $propertiesJson,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $insertedCount++;
            }

            if ($insertedCount === 0) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'No valid geometries found to import.',
                    'count' => 0
                ];
            }

            DB::commit();

            return [
                'success' => true,
                'message' => "Successfully imported $insertedCount features.",
                'count' => $insertedCount
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('GeoJSON import failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
