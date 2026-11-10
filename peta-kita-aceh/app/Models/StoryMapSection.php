<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryMapSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'map_state_json' => 'array',
    ];

    public function storyMap(): BelongsTo
    {
        return $this->belongsTo(StoryMap::class);
    }
}
