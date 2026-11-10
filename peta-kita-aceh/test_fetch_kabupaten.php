<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Fetching indonesia-kabupaten.json from superpikar/indonesia-geojson...\n";
try {
    $response = Illuminate\Support\Facades\Http::timeout(30)->get('https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/geojson/indonesia-kabupaten.json');
    if ($response->successful()) {
        $json = $response->json();
        $features = $json['features'] ?? [];
        echo "Total features in file: " . count($features) . "\n";
        
        $acehFeatures = [];
        foreach ($features as $f) {
            $props = $f['properties'] ?? [];
            // Check if it belongs to Aceh
            $provinsi = $props['PROVINSI'] ?? ($props['provinsi'] ?? '');
            $kabupaten = $props['KABUPATEN'] ?? ($props['kabupaten'] ?? '');
            
            if (stripos($provinsi, 'ACEH') !== false || stripos($kabupaten, 'ACEH') !== false) {
                $acehFeatures[] = $f;
            }
        }
        
        echo "Aceh features found: " . count($acehFeatures) . "\n";
        if (count($acehFeatures) > 0) {
            echo "First 2 Aceh kabupaten names:\n";
            foreach (array_slice($acehFeatures, 0, 2) as $af) {
                echo " - " . ($af['properties']['KABUPATEN'] ?? $af['properties']['kabupaten'] ?? 'N/A') . "\n";
            }
        }
    } else {
        echo "FAILED to fetch: " . $response->status() . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
