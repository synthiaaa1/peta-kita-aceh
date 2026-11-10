<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatasetResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'year' => $this->year,
            'status' => $this->status,
            'access_level' => $this->access_level,
            'published_at' => $this->published_at,
            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],
            'agency' => [
                'id' => $this->agency?->id,
                'name' => $this->agency?->name,
                'code' => $this->agency?->code,
            ],
            'metadata' => new MetadataResource($this->whenLoaded('metadata')),
            'layers' => LayerResource::collection($this->whenLoaded('layers')),
        ];
    }
}
