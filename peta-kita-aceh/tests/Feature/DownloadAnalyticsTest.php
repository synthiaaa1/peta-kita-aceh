<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Dataset;
use App\Models\DatasetDownload;
use App\Models\Layer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DownloadAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup initial user roles/agencies if needed
    }

    protected function createDatasetAndLayer()
    {
        $agency = \App\Models\Agency::create(['name' => 'Bappeda', 'code' => 'BPD' . uniqid()]);
        $category = \App\Models\Category::create(['name' => 'Transport', 'slug' => 'transport-' . uniqid()]);
        $user = User::factory()->create();
        
        $dataset = Dataset::create([
            'title' => 'Test Dataset',
            'slug' => 'test-dataset-' . uniqid(),
            'agency_id' => $agency->id,
            'category_id' => $category->id,
            'user_id' => $user->id,
            'year' => 2026,
            'status' => 'published',
            'access_level' => 'public'
        ]);

        $layer = Layer::create([
            'dataset_id' => $dataset->id,
            'name' => 'Test Layer',
            'geometry_type' => 'point',
            'is_active' => true,
        ]);

        return [$dataset, $layer];
    }

    public function test_public_user_can_download_public_dataset_and_it_is_tracked()
    {
        [$dataset, $layer] = $this->createDatasetAndLayer();

        $response = $this->get("/api/layers/{$layer->id}/download");

        $response->assertStatus(200);
        $this->assertDatabaseHas('dataset_downloads', [
            'dataset_id' => $dataset->id,
            'layer_id' => $layer->id,
            'user_id' => null,
        ]);
    }

    public function test_download_spam_protection_prevents_duplicate_logs_within_5_minutes()
    {
        [$dataset, $layer] = $this->createDatasetAndLayer();

        // First download
        $this->get("/api/layers/{$layer->id}/download");
        $this->assertEquals(1, DatasetDownload::count());

        // Second download immediately
        $this->get("/api/layers/{$layer->id}/download");
        // Count should still be 1 because of anti-spam logic
        $this->assertEquals(1, DatasetDownload::count());
    }

    public function test_authenticated_user_download_logs_user_id()
    {
        $user = User::factory()->create(['role' => 'operator']);
        [$dataset, $layer] = $this->createDatasetAndLayer();

        $this->actingAs($user)->get("/api/layers/{$layer->id}/download");

        $this->assertDatabaseHas('dataset_downloads', [
            'dataset_id' => $dataset->id,
            'user_id' => $user->id,
        ]);
    }
}
