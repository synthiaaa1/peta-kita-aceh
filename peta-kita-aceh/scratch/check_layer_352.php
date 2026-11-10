<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Daftar 23 Kabupaten/Kota di Layer 352:\n";
$features = App\Models\SpatialFeature::where('layer_id', 352)->get();
foreach ($features as $f) {
    echo "- ID: {$f->id} | Properties: " . json_encode($f->properties) . "\n";
}
