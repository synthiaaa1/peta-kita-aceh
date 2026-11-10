<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpatialFeature extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'properties' => 'array',
    ];

    public function layer(): BelongsTo
    {
        return $this->belongsTo(Layer::class);
    }
}
