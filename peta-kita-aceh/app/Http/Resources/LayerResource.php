<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'geometry_type' => $this->geometry_type,
            'is_active' => $this->is_active,
            'links' => [
                'geojson' => url("/api/layers/{$this->id}/geojson"),
                'download' => url("/api/layers/{$this->id}/download"),
            ]
        ];
    }
}
