<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';
$kernel = app()->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
$res = \Illuminate\Support\Facades\Http::get('http://127.0.0.1:8000/api/layers/1/geojson?bbox=90,0,100,10');
echo "Status: " . $res->status() . "\n";
echo "Response body length: " . strlen($res->body()) . "\n";
echo substr($res->body(), 0, 500);
