<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Dataset;
use App\Models\Layer;
use App\Models\SpatialFeature;
use App\Models\StoryMap;
use App\Models\ThematicMap;
use App\Models\Agency;

echo "=== AUDIT RINGKASAN DATA BASE ===\n";
echo "Total Users         : " . \App\Models\User::count() . "\n";
foreach(\App\Models\User::all() as $u) {
    echo "  - User ID: {$u->id} | {$u->email} ({$u->name})\n";
}
echo "Total Datasets      : " . Dataset::count() . "\n";
echo "Total Layers        : " . Layer::count() . "\n";
echo "Total Features      : " . SpatialFeature::count() . "\n";
echo "Total Story Maps    : " . StoryMap::count() . "\n";
echo "Total Thematic Maps : " . ThematicMap::count() . "\n";
echo "Total Agencies (SKPA): " . Agency::count() . "\n\n";

echo "=== RINCIAN DATASET ===\n";
foreach(Dataset::with('agency', 'layers')->get() as $d) {
    $fCount = 0;
    foreach($d->layers as $l) {
        $fCount += SpatialFeature::where('layer_id', $l->id)->count();
    }
    echo sprintf(
        "ID: %d | [%s / %s] | %s | SKPA: %s | Layers: %d | Features: %d\n",
        $d->id,
        $d->status,
        $d->access_level,
        $d->title,
        $d->agency?->name ?? 'None',
        $d->layers->count(),
        $fCount
    );
}

echo "\n=== RINCIAN STORY MAPS ===\n";
foreach(StoryMap::all() as $s) {
    echo "- {$s->title} (Slug: {$s->slug}, Status: {$s->status})\n";
}

echo "\n=== RINCIAN THEMATIC MAPS ===\n";
foreach(ThematicMap::all() as $t) {
    echo "- {$t->title} (Type: {$t->type}, Status: {$t->status})\n";
}

echo "\n=== CEK SAMPEL GEOMETRI SPASIAL (POLYGON REAL VS DUMMY) ===\n";
$firstFeature = SpatialFeature::selectRaw("id, layer_id, ST_GeometryType(geom) as geom_type, ST_AsText(ST_Centroid(geom)) as centroid, ST_NPoints(geom) as points, properties")->first();
if ($firstFeature) {
    echo "Sample Feature ID: {$firstFeature->id}\n";
    echo "Geometry Type    : {$firstFeature->geom_type}\n";
    echo "Centroid         : {$firstFeature->centroid}\n";
    echo "Vertex Points    : {$firstFeature->points}\n";
    echo "Properties       : " . json_encode($firstFeature->properties) . "\n";
} else {
    echo "Tidak ada spatial feature ditemukan!\n";
}
