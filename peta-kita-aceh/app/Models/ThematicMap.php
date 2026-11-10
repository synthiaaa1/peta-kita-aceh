<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThematicMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'thumbnail',
        'file_path',
        'config_json',
        'agency_id',
        'status',
        'source_url',
    ];

    protected $casts = [
        'config_json' => 'array',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
