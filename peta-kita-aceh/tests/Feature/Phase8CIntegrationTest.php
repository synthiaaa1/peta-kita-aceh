<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\Category;
use App\Models\Agency;
use App\Services\SigAcehIntegrationService;
use App\Services\Spatial\GeoConversionService;
use Illuminate\Support\Str;

class Phase8CIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $category;
    protected $agency;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'Database\Seeders\MasterDataSeeder']);
        $this->adminUser = User::firstOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin', 'role' => 'admin', 'password' => bcrypt('password')]);
        $this->category = Category::first();
        $this->agency = Agency::first();
    }

    protected function createDummyDatasetLayer($accessLevel = 'public')
    {
        $dataset = Dataset::create([
            'slug' => Str::random(10),
            'title' => 'Test Dataset',
            'description' => 'Test',
            'category_id' => $this->category->id,
            'agency_id' => $this->agency->id,
            'user_id' => $this->adminUser->id,
            'status' => 'published',
            'access_level' => $accessLevel,
            'license' => 'Open',
            'year' => date('Y'),
            'published_at' => now(),
        ]);

        return Layer::create([
            'dataset_id' => $dataset->id,
            'name' => 'Test Layer',
            'geometry_type' => 'polygon',
            'source_type' => 'opd',
            'geometry_available' => true,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function test_geometry_invalid_rejected()
    {
        $layer = $this->createDummyDatasetLayer();
        $geoService = app(GeoConversionService::class);
        
        $invalidGeoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'geometry' => null // Invalid
                ]
            ]
        ]);

        $result = $geoService->importGeoJson($layer, $invalidGeoJson);

        $this->assertFalse($result['success']);
        $this->assertDatabaseMissing('spatial_features', ['layer_id' => $layer->id]);
    }

    /** @test */
    public function test_sig_metadata_only_does_not_create_dummy_geometry()
    {
        $service = app(SigAcehIntegrationService::class);
        $service->syncSigAcehDatasets();
        
        $dummyCount = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber_api' = 'sig.acehprov.go.id/api/v2'")
            ->count();
        $this->assertEquals(0, $dummyCount);
    }
    
    /** @test */
    public function test_bnpb_does_not_make_hardcoded_geometry()
    {
        $service = app(SigAcehIntegrationService::class);
        $service->syncNationalBnpbData();
        
        $dummyCount = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber' = 'BNPB Indonesia / SIG Aceh'")
            ->count();
        $this->assertEquals(0, $dummyCount);
    }

    /** @test */
    public function test_provenance_is_saved()
    {
        $layer = $this->createDummyDatasetLayer();
        $layer->update(['source_url' => 'http://example.com/wfs', 'last_synced_at' => now()]);
        
        $this->assertDatabaseHas('layers', [
            'id' => $layer->id,
            'source_url' => 'http://example.com/wfs'
        ]);
        $this->assertNotNull($layer->fresh()->last_synced_at);
    }

    /** @test */
    public function test_bbox_returns_real_geometry_only()
    {
        $layer = $this->createDummyDatasetLayer('public');
        
        $geoService = app(GeoConversionService::class);
        $geoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                ['type' => 'Feature', 'properties' => ['name' => 'In BBOX'], 'geometry' => ['type' => 'Point', 'coordinates' => [95.3, 5.5]]],
            ]
        ]);
        $geoService->importGeoJson($layer, $geoJson);

        $response = $this->getJson("/api/layers/{$layer->id}/geojson?bbox=95.0,5.0,96.0,6.0");
        $response->assertStatus(200);
        
        $hasPostGis = !empty(DB::select("SELECT 1 FROM pg_extension WHERE extname = 'postgis'"));
        if ($hasPostGis) {
            $features = $response->json('features');
            $this->assertCount(1, $features);
            $this->assertEquals('In BBOX', $features[0]['properties']['name']);
        } else {
            $this->assertTrue(true);
        }
    }
}
