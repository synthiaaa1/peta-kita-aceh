<?php

namespace Tests\Feature;

use App\Models\Dataset;
use App\Models\Agency;
use App\Models\Category;
use App\Models\User;
use App\Models\Layer;
use App\Models\DatasetMetadata;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AuditLog;
use Illuminate\Auth\Access\AuthorizationException;

class DataSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->agencyA = Agency::create(['name' => 'Agency A', 'code' => 'AA']);
        $this->agencyB = Agency::create(['name' => 'Agency B', 'code' => 'AB']);
        $this->category = Category::create(['name' => 'Security', 'slug' => 'sec']);

        $this->operatorA = User::factory()->create(['role' => 'operator', 'agency_id' => $this->agencyA->id]);
        $this->operatorB = User::factory()->create(['role' => 'operator', 'agency_id' => $this->agencyB->id]);
        $this->admin = User::factory()->create(['role' => 'admin']);

        $this->datasetA = Dataset::create([
            'title' => 'Dataset A',
            'slug' => 'dataset-a',
            'agency_id' => $this->agencyA->id,
            'category_id' => $this->category->id,
            'user_id' => $this->operatorA->id,
            'year' => 2026,
            'status' => 'pending_review',
            'access_level' => 'private'
        ]);

        $this->datasetB = Dataset::create([
            'title' => 'Dataset B',
            'slug' => 'dataset-b',
            'agency_id' => $this->agencyB->id,
            'category_id' => $this->category->id,
            'user_id' => $this->operatorB->id,
            'year' => 2026,
            'status' => 'published',
            'access_level' => 'public'
        ]);
        
        // Disable authorization exception handling in HTTP tests to catch it natively if we want,
        // but here we might test models directly or via HTTP. Let's test Models directly for strict validation.
    }

    public function test_operator_cannot_change_agency_id_of_own_dataset()
    {
        $this->actingAs($this->operatorA);

        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('Anda tidak berhak mengubah kepemilikan dataset (Instansi/SKPA).');

        $this->datasetA->update(['agency_id' => $this->agencyB->id]);
    }

    public function test_admin_can_change_agency_id_of_any_dataset()
    {
        $this->actingAs($this->admin);
        
        $this->datasetA->update(['agency_id' => $this->agencyB->id]);
        $this->assertEquals($this->agencyB->id, $this->datasetA->fresh()->agency_id);
    }

    public function test_operator_cannot_publish_dataset_directly()
    {
        $this->actingAs($this->operatorA);

        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('Hanya Admin yang dapat mempublikasikan dataset.');

        $this->datasetA->update(['status' => 'published']);
    }

    public function test_admin_can_publish_dataset()
    {
        $this->actingAs($this->admin);

        $this->datasetA->update(['status' => 'published']);
        $this->assertEquals('published', $this->datasetA->fresh()->status);
    }

    public function test_audit_logs_are_recorded_on_privacy_and_status_changes()
    {
        $this->actingAs($this->admin);
        
        $this->datasetA->update(['status' => 'published']);
        $this->assertTrue(AuditLog::where('model_id', $this->datasetA->id)->where('action', 'dataset_approved')->exists());

        $this->datasetA->update(['access_level' => 'public']);
        $this->assertTrue(AuditLog::where('model_id', $this->datasetA->id)->where('action', 'privacy_changed')->exists());

        $this->datasetA->update(['agency_id' => $this->agencyB->id]);
        $this->assertTrue(AuditLog::where('model_id', $this->datasetA->id)->where('action', 'ownership_changed')->exists());
    }

    public function test_private_datasets_hidden_from_public_api()
    {
        // Dataset A is private and pending_review.
        $response = $this->getJson('/api/datasets');
        $response->assertStatus(200);
        $response->assertJsonMissing(['slug' => 'dataset-a']);
        $response->assertJsonFragment(['slug' => 'dataset-b']);

        // Try direct access
        $response = $this->getJson('/api/datasets/dataset-a');
        $response->assertStatus(404);
    }
}
