<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$res = DB::select("SELECT data_type, udt_name FROM information_schema.columns WHERE table_name = 'spatial_features' AND column_name = 'geom'");
echo "Type: " . ($res[0]->data_type ?? 'NOT FOUND') . " | UDT: " . ($res[0]->udt_name ?? '') . "\n";

$indexes = DB::select("SELECT indexdef FROM pg_indexes WHERE tablename = 'spatial_features'");
foreach($indexes as $idx) {
    echo "Index: " . $idx->indexdef . "\n";
}
