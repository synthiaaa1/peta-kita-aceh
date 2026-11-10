<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\DatasetDownload;
use App\Models\Layer;
use App\Models\User;
use App\Filament\Resources\Datasets\DatasetResource;
use App\Filament\Resources\Layers\LayerResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeoportalApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic dataset & layer for testing
        $user = User::factory()->create(['role' => 'admin']);
        $agency = Agency::create(['name' => 'Dinas Perhubungan Aceh', 'code' => 'DISHUB']);
        $category = Category::create(['name' => 'Transportasi', 'slug' => 'transportasi']);

        $dataset = Dataset::create([
            'slug' => 'peta-terminal-aceh',
            'title' => 'Peta Terminal Terpadu Aceh',
            'description' => 'Peta lokasi terminal bus dan angkutan kota se-Aceh',
            'category_id' => $category->id,
            'agency_id' => $agency->id,
            'user_id' => $user->id,
            'status' => 'published',
            'access_level' => 'public',
            'year' => 2026,
            'srid' => 4326,
            'published_at' => now(),
        ]);

        Layer::create([
            'dataset_id' => $dataset->id,
            'name' => 'Layer Titik Terminal Bus',
            'geometry_type' => 'point',
            'source_type' => 'vector_table',
            'is_active' => true,
        ]);
    }

    public function test_landing_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('PetaKita');
    }

    public function test_webgis_viewer_page_loads_successfully(): void
    {
        $response = $this->get('/map');
        $response->assertStatus(200);
        $response->assertSee('Memuat Peta Kita Aceh');
    }

    public function test_catalog_index_page_loads_successfully(): void
    {
        $response = $this->get('/katalog');
        $response->assertStatus(200);
        $response->assertSee('Peta Terminal Terpadu Aceh');
    }

    public function test_api_datasets_returns_published_datasets(): void
    {
        $response = $this->getJson('/api/datasets');
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true
                 ])
                 ->assertJsonFragment(['title' => 'Peta Terminal Terpadu Aceh']);
    }

    public function test_api_layer_geojson_endpoint(): void
    {
        $layer = Layer::first();
        $response = $this->getJson("/api/layers/{$layer->id}/geojson");
        $response->assertStatus(200)
                 ->assertJson([
                     'type' => 'FeatureCollection'
                 ]);
    }

    public function test_download_geojson_streams_file_and_records_download_log(): void
    {
        $layer = Layer::first();
        $this->assertEquals(0, DatasetDownload::count());

        $response = $this->get("/api/layers/{$layer->id}/download");
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/geo+json');

        $this->assertEquals(1, DatasetDownload::count());
        $this->assertDatabaseHas('dataset_downloads', [
            'dataset_id' => $layer->dataset_id,
            'layer_id' => $layer->id,
        ]);
    }

    public function test_api_v2_external_bnpb_disaster_sync(): void
    {
        $response = $this->getJson('/api/v2/external/bnpb-disaster');
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'provider' => 'BNPB Indonesia / BPBA Aceh'
                 ]);
    }

    public function test_restricted_and_private_access_level_filtering(): void
    {
        $category = Category::first();
        $admin = User::where('role', 'admin')->first();
        $agencyDispusip = Agency::create(['name' => 'Dinas Perpustakaan', 'code' => 'DISPUSIP']);
        $agencyDinkes = Agency::create(['name' => 'Dinas Kesehatan', 'code' => 'DINKES']);

        $operatorDispusip = User::factory()->create([
            'role' => 'operator',
            'agency_id' => $agencyDispusip->id
        ]);

        // 1. Create Restricted Dataset for DISPUSIP
        $restrictedDs = Dataset::create([
            'slug' => 'peta-arsip-terbatas',
            'title' => 'Peta Lokasi Arsip Terbatas',
            'category_id' => $category->id,
            'agency_id' => $agencyDispusip->id,
            'user_id' => $admin->id,
            'status' => 'published',
            'access_level' => 'restricted',
            'year' => 2026,
        ]);
        $restrictedDs->allowedAgencies()->attach($agencyDispusip->id);

        $restrictedLayer = Layer::create([
            'dataset_id' => $restrictedDs->id,
            'name' => 'Layer Arsip Terbatas',
            'geometry_type' => 'polygon',
            'source_type' => 'vector_table',
            'is_active' => true,
        ]);

        // Guest user MUST NOT see restricted dataset
        $guestRes = $this->getJson('/api/datasets');
        $guestRes->assertJsonMissing(['title' => 'Peta Lokasi Arsip Terbatas']);

        $guestLayerRes = $this->getJson("/api/layers/{$restrictedLayer->id}/geojson");
        $guestLayerRes->assertStatus(403);

        // Operator of tagged agency CAN see restricted dataset
        $this->actingAs($operatorDispusip);
        $opRes = $this->getJson('/api/datasets');
        $opRes->assertJsonFragment(['title' => 'Peta Lokasi Arsip Terbatas']);

        $opLayerRes = $this->getJson("/api/layers/{$restrictedLayer->id}/geojson");
        $opLayerRes->assertStatus(200);

        // 2. Create Private Dataset
        $privateDs = Dataset::create([
            'slug' => 'peta-internal-admin',
            'title' => 'Peta Rahasia Internal',
            'category_id' => $category->id,
            'agency_id' => $agencyDinkes->id,
            'user_id' => $admin->id,
            'status' => 'published',
            'access_level' => 'private',
            'year' => 2026,
        ]);

        // Operator DISPUSIP MUST NOT see private dataset of DINKES
        $opPrivateRes = $this->getJson('/api/datasets');
        $opPrivateRes->assertJsonMissing(['title' => 'Peta Rahasia Internal']);

        // Admin CAN see private dataset
        $this->actingAs($admin);
        $adminRes = $this->getJson('/api/datasets');
        $adminRes->assertJsonFragment(['title' => 'Peta Rahasia Internal']);
    }

    public function test_operator_cannot_delete_datasets_or_layers(): void
    {
        $agency = Agency::first();
        $operator = User::factory()->create([
            'role' => 'operator',
            'agency_id' => $agency->id
        ]);
        $admin = User::where('role', 'admin')->first();

        $dataset = Dataset::first();
        $layer = Layer::first();

        // Operator context
        $this->actingAs($operator);
        $this->assertFalse(DatasetResource::canDelete($dataset));
        $this->assertFalse(DatasetResource::canDeleteAny());
        $this->assertFalse(LayerResource::canDelete($layer));
        $this->assertFalse(LayerResource::canDeleteAny());

        // Admin context
        $this->actingAs($admin);
        $this->assertTrue(DatasetResource::canDelete($dataset));
        $this->assertTrue(DatasetResource::canDeleteAny());
        $this->assertTrue(LayerResource::canDelete($layer));
        $this->assertTrue(LayerResource::canDeleteAny());
    }
}
