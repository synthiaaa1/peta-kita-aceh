<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$counts = [
    'Agencies (OPD/Dinas)' => \App\Models\Agency::count(),
    'Categories (Sektor)' => \App\Models\Category::count(),
    'Users' => \App\Models\User::count(),
    'Datasets' => \App\Models\Dataset::count(),
    'Layers' => \App\Models\Layer::count(),
    'Spatial Features (Batas Wilayah/Geometri)' => \App\Models\SpatialFeature::count(),
    'Story Maps' => \App\Models\StoryMap::count(),
    'Story Map Sections (Bab/Bab Cerita)' => \App\Models\StoryMapSection::count(),
    'Thematic Maps' => \App\Models\ThematicMap::count(),
    'Dataset Downloads (Log Unduhan)' => \App\Models\DatasetDownload::count(),
];

foreach ($counts as $table => $count) {
    echo "$table: $count\n";
}

echo "\n--- Story Maps yang ada di database ---\n";
foreach (\App\Models\StoryMap::with('sections')->get() as $sm) {
    echo "- ID: {$sm->id} | Judul: {$sm->title} | Slug: {$sm->slug} | Jumlah Bab: " . $sm->sections->count() . "\n";
}
