<?php
use App\Models\Layer;
use App\Models\SpatialFeature;
echo "\n=== REAL GEOMETRY LAYERS ===\n";
$real = Layer::where('geometry_available', true)->get();
foreach($real as $l) {
    $c = SpatialFeature::where('layer_id', $l->id)->count();
    echo "- Layer: {$l->name} (Source: {$l->source_type}) -> {$c} features\n";
}
echo "\n=== METADATA ONLY ===\n";
$meta = Layer::where('geometry_available', false)->get();
foreach($meta as $l) {
    echo "- Layer: {$l->name} (Source: {$l->source_type})\n";
}
