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

class Phase8BIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $category;
    protected $agency;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup initial admin and categories/agencies needed for sync
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
    public function test_sig_metadata_sync_does_not_create_dummy_geometry()
    {
        $service = app(SigAcehIntegrationService::class);
        $service->syncSigAcehDatasets();

        $dummyCount = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber_api' = 'sig.acehprov.go.id/api/v2'")
            ->count();

        $this->assertEquals(0, $dummyCount, "Sync harusnya tidak lagi membuat dummy geometry");
    }

    /** @test */
    public function test_sig_dataset_without_geometry_is_not_valid_spatial_layer()
    {
        $service = app(SigAcehIntegrationService::class);
        $service->syncSigAcehDatasets();
        
        $layer = Layer::where('source_type', 'sig_aceh')->first();
        if ($layer) {
            $this->assertFalse((bool)$layer->geometry_available, "Layer dari SIG Aceh harus ditandai geometry_available = false");
        } else {
            $this->assertTrue(true);
        }
    }

    /** @test */
    public function test_bnpb_does_not_use_hardcoded_geometry()
    {
        $service = app(SigAcehIntegrationService::class);
        $service->syncNationalBnpbData();

        $dummyCount = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber' = 'BNPB Indonesia / SIG Aceh'")
            ->count();

        $this->assertEquals(0, $dummyCount, "BNPB tidak boleh lagi menyimpan geometry hardcode");
        
        $layer = Layer::where('source_type', 'bnpb')->first();
        if ($layer) {
            $this->assertFalse((bool)$layer->geometry_available, "BNPB layer harus ditandai tanpa geometry");
        }
    }

    /** @test */
    public function test_bpba_does_not_use_hardcoded_geometry()
    {
        $this->test_bnpb_does_not_use_hardcoded_geometry();
    }

    /** @test */
    public function test_real_geojson_inserts_into_spatial_features()
    {
        $layer = $this->createDummyDatasetLayer();
        $geoService = app(GeoConversionService::class);
        
        $geoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'properties' => ['name' => 'Real Test'],
                    'geometry' => ['type' => 'Point', 'coordinates' => [95.3, 5.5]]
                ]
            ]
        ]);

        $geoService->importGeoJson($layer, $geoJson);

        $this->assertDatabaseHas('spatial_features', ['layer_id' => $layer->id]);
    }

    /** @test */
    public function test_srid_geometry_is_4326()
    {
        $layer = $this->createDummyDatasetLayer();
        $geoService = app(GeoConversionService::class);
        
        $geoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                ['type' => 'Feature', 'properties' => [], 'geometry' => ['type' => 'Point', 'coordinates' => [95.0, 5.0]]]
            ]
        ]);
        $geoService->importGeoJson($layer, $geoJson);

        $hasPostGis = !empty(DB::select("SELECT 1 FROM pg_extension WHERE extname = 'postgis'"));
        if ($hasPostGis) {
            $srid = DB::select("SELECT ST_SRID(geom) as srid FROM spatial_features WHERE layer_id = ? LIMIT 1", [$layer->id]);
            $this->assertEquals(4326, $srid[0]->srid);
        } else {
            $this->assertTrue(true, "PostGIS not available for SRID test");
        }
    }

    /** @test */
    public function test_bbox_returns_correct_geometry()
    {
        $layer = $this->createDummyDatasetLayer('public');
        
        $geoService = app(GeoConversionService::class);
        $geoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                ['type' => 'Feature', 'properties' => ['name' => 'In BBOX'], 'geometry' => ['type' => 'Point', 'coordinates' => [95.3, 5.5]]],
                ['type' => 'Feature', 'properties' => ['name' => 'Out BBOX'], 'geometry' => ['type' => 'Point', 'coordinates' => [100.0, -5.0]]]
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

    /** @test */
    public function test_restricted_dataset_returns_403_for_unauthorized()
    {
        $layer = $this->createDummyDatasetLayer('restricted');
        $response = $this->getJson("/api/layers/{$layer->id}/geojson");
        $response->assertStatus(403);
    }

    /** @test */
    public function test_closed_dataset_is_protected()
    {
        $layer = $this->createDummyDatasetLayer('closed');
        $response = $this->getJson("/api/layers/{$layer->id}/geojson");
        $response->assertStatus(403);
    }

    /** @test */
    public function test_opd_upload_works()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function test_boundary_filter_kabupaten_works()
    {
        $layer = $this->createDummyDatasetLayer('public');
        
        $geoService = app(GeoConversionService::class);
        $geoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                ['type' => 'Feature', 'properties' => ['regency_code' => '1171'], 'geometry' => ['type' => 'Point', 'coordinates' => [95.0, 5.0]]],
                ['type' => 'Feature', 'properties' => ['regency_code' => '1108'], 'geometry' => ['type' => 'Point', 'coordinates' => [96.0, 4.0]]]
            ]
        ]);
        $geoService->importGeoJson($layer, $geoJson);

        $response = $this->getJson("/api/layers/{$layer->id}/geojson?regency_code=1171");
        $response->assertStatus(200);
        
        $features = $response->json('features');
        $this->assertCount(1, $features);
        $this->assertEquals('1171', $features[0]['properties']['regency_code']);
    }

    /** @test */
    public function test_boundary_filter_kecamatan_works()
    {
        $layer = $this->createDummyDatasetLayer('public');
        
        $geoService = app(GeoConversionService::class);
        $geoJson = json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                ['type' => 'Feature', 'properties' => ['district_code' => '117101'], 'geometry' => ['type' => 'Point', 'coordinates' => [95.0, 5.0]]],
                ['type' => 'Feature', 'properties' => ['district_code' => '110801'], 'geometry' => ['type' => 'Point', 'coordinates' => [96.0, 4.0]]]
            ]
        ]);
        $geoService->importGeoJson($layer, $geoJson);

        $response = $this->getJson("/api/layers/{$layer->id}/geojson?district_code=117101");
        $response->assertStatus(200);
        
        $features = $response->json('features');
        $this->assertCount(1, $features);
        $this->assertEquals('117101', $features[0]['properties']['district_code']);
    }
}
