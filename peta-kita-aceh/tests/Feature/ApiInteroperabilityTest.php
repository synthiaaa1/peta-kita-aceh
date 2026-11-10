<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiInteroperabilityTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->agency = Agency::create(['name' => 'Agency Test', 'code' => 'T1']);
        $this->category = Category::create(['name' => 'Category Test', 'slug' => 'cat-1']);
        
        $this->user = User::factory()->create(['agency_id' => $this->agency->id]);

        $this->publicDataset = Dataset::create([
            'title' => 'Public Dataset',
            'slug' => 'public-dataset',
            'agency_id' => $this->agency->id,
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'published',
            'access_level' => 'public',
            'year' => 2026
        ]);
        
        $this->privateDataset = Dataset::create([
            'title' => 'Private Dataset',
            'slug' => 'private-dataset',
            'agency_id' => $this->agency->id,
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'published',
            'access_level' => 'private',
            'year' => 2026
        ]);
        
        $this->layer = Layer::create([
            'dataset_id' => $this->publicDataset->id,
            'name' => 'Public Layer',
            'geometry_type' => 'point',
            'is_active' => true
        ]);
        
        // Point 1: Lng 95.0, Lat 5.0 (Aceh approx)
        DB::table('spatial_features')->insert([
            'layer_id' => $this->layer->id,
            'geom' => DB::raw("ST_SetSRID(ST_MakePoint(95.0, 5.0), 4326)"),
            'properties' => json_encode(['name' => 'Point 1'])
        ]);
        
        // Point 2: Lng 100.0, Lat 1.0 (Sumatera)
        DB::table('spatial_features')->insert([
            'layer_id' => $this->layer->id,
            'geom' => DB::raw("ST_SetSRID(ST_MakePoint(100.0, 1.0), 4326)"),
            'properties' => json_encode(['name' => 'Point 2'])
        ]);
    }

    public function test_api_v2_datasets_returns_paginated_resource()
    {
        $response = $this->getJson('/api/v2/datasets');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'slug', 'category', 'agency', 'metadata', 'layers']
            ],
            'links',
            'meta'
        ]);
        
        // Private dataset should not be visible to public
        $response->assertJsonMissing(['slug' => 'private-dataset']);
    }

    public function test_api_v2_datasets_filtering_works()
    {
        $response = $this->getJson('/api/v2/datasets?q=Public');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_geojson_bbox_returns_intersecting_features()
    {
        // BBOX covering Point 1 (95.0, 5.0) but not Point 2 (100.0, 1.0)
        // minLng, minLat, maxLng, maxLat
        $bbox = '94.0,4.0,96.0,6.0';
        
        $response = $this->getJson("/api/layers/{$this->layer->id}/geojson?bbox={$bbox}");
        
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Point 1']);
        $response->assertJsonMissing(['name' => 'Point 2']);
        $this->assertFalse($response->json('truncated'));
    }

    public function test_geojson_bbox_validation_rejects_invalid_bbox()
    {
        $response = $this->getJson("/api/layers/{$this->layer->id}/geojson?bbox=invalid,bbox");
        $response->assertStatus(422);
        
        $response = $this->getJson("/api/layers/{$this->layer->id}/geojson?bbox=190.0,0.0,-190.0,0.0");
        $response->assertStatus(422);
    }
}
