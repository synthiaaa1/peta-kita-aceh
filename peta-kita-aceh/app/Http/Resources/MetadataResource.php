<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetadataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_identifier' => $this->file_identifier,
            'abstract' => $this->abstract,
            'lineage' => $this->lineage,
            'topic_category' => $this->topic_category,
            'spatial_resolution' => $this->spatial_resolution,
            'date_stamp' => $this->date_stamp,
            'completeness' => [
                'mandatory' => $this->mandatory_completeness,
                'recommended' => $this->recommended_completeness,
            ]
        ];
    }
}
