<?php
$res = file_get_contents('http://127.0.0.1:8000/api/layers/352/geojson');
$json = json_decode($res, true);
echo "API /api/layers/352/geojson:\n";
echo "Type: " . ($json['type'] ?? 'null') . "\n";
echo "Jumlah Features: " . (isset($json['features']) ? count($json['features']) : 0) . "\n";
if (!empty($json['features'])) {
    echo "Contoh feature pertama: " . json_encode($json['features'][0]['properties']) . "\n";
}
