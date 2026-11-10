<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatasetMetadata extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function ($metadata) {
            if (empty($metadata->metadata_identifier) && !empty($metadata->dataset_id)) {
                $dataset = Dataset::find($metadata->dataset_id);
                $year = $dataset ? $dataset->year : date('Y');
                // Format: ACEH-{YYYY}-{DatasetID}
                $metadata->metadata_identifier = "ACEH-{$year}-" . str_pad($metadata->dataset_id, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $casts = [
        'additional_info' => 'array',
        'keywords' => 'array',
        'bounding_box' => 'array',
        'temporal_start' => 'date',
        'temporal_end' => 'date',
        'last_update_date' => 'date',
    ];

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }

    public function getMandatoryCompletenessAttribute(): int
    {
        $mandatoryFields = [
            'abstract',
            'topic_category',
            'keywords',
            'dataset_type',
            'metadata_identifier',
        ];

        // Since SRID is in dataset and has default, we check coordinate_system if it's considered spatial
        // We'll add coordinate_system to mandatory to be strict about spatial metadata.
        $mandatoryFields[] = 'coordinate_system';

        $filledCount = 0;
        foreach ($mandatoryFields as $field) {
            if (!empty($this->{$field})) {
                $filledCount++;
            }
        }

        // Title, Agency, Access Level are in Dataset and are required in DB/Form, so they are inherently 100% filled.
        // We calculate percentage purely based on the nullable metadata fields.
        return (int) round(($filledCount / count($mandatoryFields)) * 100);
    }

    public function getRecommendedCompletenessAttribute(): int
    {
        $recommendedFields = [
            'alternative_title',
            'purpose',
            'contact_person',
            'contact_email',
            'contact_phone',
            'spatial_representation_type',
            'geometry_type',
            'bounding_box',
            'scale_denominator',
            'temporal_start',
            'temporal_end',
            'last_update_date',
            'lineage',
            'data_quality_statement',
            'accuracy_statement',
            'completeness_statement',
            'usage_constraints',
            'download_format'
        ];

        $filledCount = 0;
        foreach ($recommendedFields as $field) {
            if (!empty($this->{$field})) {
                $filledCount++;
            }
        }

        return (int) round(($filledCount / count($recommendedFields)) * 100);
    }

    public function getCompletenessScoreAttribute(): int
    {
        // Backward compatibility: average of mandatory and recommended
        return (int) round(($this->mandatory_completeness + $this->recommended_completeness) / 2);
    }
}
