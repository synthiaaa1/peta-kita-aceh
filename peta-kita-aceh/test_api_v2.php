<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Fetching datasets from SIG Aceh API v2...\n";
try {
    $response = Illuminate\Support\Facades\Http::timeout(10)->get('https://sig.acehprov.go.id/api/v2/datasets');
    if ($response->successful()) {
        $json = $response->json();
        echo "SUCCESS! Response data count: " . (isset($json['data']) ? count($json['data']) : 'none') . "\n";
        if (isset($json['data']) && count($json['data']) > 0) {
            echo "First 3 items:\n";
            print_r(array_slice($json['data'], 0, 3));
        }
    } else {
        echo "FAILED: " . $response->status() . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
