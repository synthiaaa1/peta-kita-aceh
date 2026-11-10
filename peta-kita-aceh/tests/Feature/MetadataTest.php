<?php

namespace Tests\Feature;

use App\Models\Dataset;
use App\Models\DatasetMetadata;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetadataTest extends TestCase
{
    use RefreshDatabase;

    public function test_dataset_metadata_is_generated_with_identifier()
    {
        $user = User::factory()->create();
        $agency = \App\Models\Agency::create(['name' => 'Bappeda', 'code' => 'BPD']);
        $category = \App\Models\Category::create(['name' => 'Transport', 'slug' => 'transport']);

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
        
        $metadata = DatasetMetadata::create([
            'dataset_id' => $dataset->id,
            'abstract' => 'This is an abstract',
            'dataset_type' => 'dataset'
        ]);

        $this->assertNotEmpty($metadata->metadata_identifier);
        $this->assertStringStartsWith('ACEH-2026-', $metadata->metadata_identifier);
    }

    public function test_metadata_completeness_is_calculated_correctly()
    {
        $user = User::factory()->create();
        $agency = \App\Models\Agency::create(['name' => 'Bappeda', 'code' => 'BPD']);
        $category = \App\Models\Category::create(['name' => 'Transport', 'slug' => 'transport']);

        $dataset = Dataset::create([
            'title' => 'Test Dataset Completeness',
            'slug' => 'test-dataset-completeness-' . uniqid(),
            'agency_id' => $agency->id,
            'category_id' => $category->id,
            'user_id' => $user->id,
            'year' => 2026,
            'status' => 'published',
            'access_level' => 'public'
        ]);
        
        $metadata = DatasetMetadata::create([
            'dataset_id' => $dataset->id,
            'abstract' => 'Test Abstract',
            'topic_category' => 'environment',
            'keywords' => ['test'],
            'dataset_type' => 'dataset',
            'coordinate_system' => 'WGS 84',
        ]);

        // It has abstract, topic, keywords, type, coords. Also metadata_identifier is generated on save.
        // So 6 out of 6 mandatory fields are present -> 100%
        $this->assertEquals(100, $metadata->mandatory_completeness);
        // Only a few recommended fields might be filled (none explicitly above), so it'll be 0% or low.
        $this->assertEquals(0, $metadata->recommended_completeness);

        // Fill all recommended fields
        $metadata->update([
            'alternative_title' => 'Alt Title',
            'purpose' => 'Test',
            'contact_person' => 'Admin',
            'contact_email' => 'admin@test.com',
            'contact_phone' => '12345',
            'spatial_representation_type' => 'vector',
            'geometry_type' => 'Point',
            'bounding_box' => [0,0,1,1],
            'scale_denominator' => '50000',
            'temporal_start' => now()->subYear(),
            'temporal_end' => now(),
            'last_update_date' => now(),
            'lineage' => 'Created',
            'data_quality_statement' => 'Good',
            'accuracy_statement' => 'High',
            'completeness_statement' => 'Full',
            'usage_constraints' => 'None',
            'download_format' => 'SHP'
        ]);

        // Recommended should be 100% now
        $this->assertEquals(100, $metadata->recommended_completeness);

        // Score backward compat average
        $this->assertEquals(100, $metadata->completeness_score);
    }
}
