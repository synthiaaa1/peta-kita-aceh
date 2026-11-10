<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Layer::all() as $l) {
    $count = App\Models\SpatialFeature::where('layer_id', $l->id)->count();
    echo "Layer ID: {$l->id} | Name: {$l->name} | Type: {$l->type} | Features Count: {$count}\n";
}

echo "\nContoh nama-nama kabupaten di Layer 1:\n";
$features = App\Models\SpatialFeature::where('layer_id', 1)->take(10)->get();
foreach ($features as $f) {
    echo "- " . json_encode($f->properties) . "\n";
}
