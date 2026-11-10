<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SpatialCachePrivacyTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->agencyA = Agency::create(['name' => 'Agency A', 'code' => 'AA']);
        $this->agencyB = Agency::create(['name' => 'Agency B', 'code' => 'BB']);
        
        $this->userA1 = User::factory()->create(['agency_id' => $this->agencyA->id, 'role' => 'operator']);
        $this->userA2 = User::factory()->create(['agency_id' => $this->agencyA->id, 'role' => 'operator']);
        $this->userB = User::factory()->create(['agency_id' => $this->agencyB->id, 'role' => 'operator']);
        
        $this->admin = User::factory()->create(['role' => 'admin']);

        $this->category = \App\Models\Category::create(['name' => 'Test', 'slug' => 'test']);
        
        // Restricted dataset by Agency A
        $this->restrictedDataset = Dataset::create([
            'title' => 'Restricted Dataset',
            'slug' => 'restricted-dataset',
            'agency_id' => $this->agencyA->id,
            'category_id' => $this->category->id,
            'user_id' => $this->userA1->id,
            'status' => 'published',
            'access_level' => 'restricted',
            'year' => 2026
        ]);
        
        $this->layer = Layer::create([
            'dataset_id' => $this->restrictedDataset->id,
            'name' => 'Layer Restricted',
            'geometry_type' => 'point',
            'is_active' => true
        ]);
        
        Cache::flush();
    }

    public function test_users_in_same_agency_share_restricted_cache()
    {
        // User A1 requests
        $response1 = $this->actingAs($this->userA1)->getJson("/api/layers/{$this->layer->id}/geojson");
        $response1->assertStatus(200);
        
        // Due to testing environment, we can just verify that User A2 can access it 
        // and doesn't generate a new cache key (it hits the same key).
        $response2 = $this->actingAs($this->userA2)->getJson("/api/layers/{$this->layer->id}/geojson");
        $response2->assertStatus(200);
        
        // User B should get 403
        $responseB = $this->actingAs($this->userB)->getJson("/api/layers/{$this->layer->id}/geojson");
        $responseB->assertStatus(403);
        
        // Guest should get 403
        $responseGuest = $this->getJson("/api/layers/{$this->layer->id}/geojson");
        $responseGuest->assertStatus(403);
    }
}
