<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatasetDownload extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'dataset_id',
        'layer_id',
        'user_id',
        'ip_address',
        'user_agent',
        'downloaded_at',
        'created_at',
        'updated_at',
    ];

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }

    public function layer(): BelongsTo
    {
        return $this->belongsTo(Layer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
