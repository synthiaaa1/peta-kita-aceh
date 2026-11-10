<?php

$sm = App\Models\StoryMap::updateOrCreate(
    ['slug' => 'menjelajah-keindahan-aceh'],
    [
        'title' => 'Menjelajah Keindahan Aceh', 
        'author_id' => 1, 
        'status' => 'published', 
        'published_at' => now(),
        'cover_image' => null,
        'url' => 'https://storymaps.arcgis.com/stories/example' // Tambahkan link eksternal di sini
    ]
); 

$sm->sections()->delete();

$sm->sections()->create([
    'order' => 1, 
    'narrative_text' => '<h1>Selamat Datang di Banda Aceh</h1><p>Perjalanan kita dimulai dari ibu kota provinsi, Banda Aceh. Kota ini kaya akan sejarah dan budaya.</p>', 
    'map_state_json' => ['lat' => 5.550, 'lng' => 95.317, 'zoom' => 12]
]); 

$sm->sections()->create([
    'order' => 2, 
    'narrative_text' => '<h2>Lhokseumawe, Kota Petro Dolar</h2><p>Bergerak ke timur, kita akan menemui Lhokseumawe, kota industri yang permai di pesisir Selat Malaka.</p>', 
    'map_state_json' => ['lat' => 5.180, 'lng' => 97.150, 'zoom' => 12]
]);

$sm->sections()->create([
    'order' => 3, 
    'narrative_text' => '<h2>Pesona Gayo Lues</h2><p>Kini kita beranjak ke dataran tinggi Gayo yang sejuk, terkenal dengan produksi kopi kelas dunianya.</p>', 
    'map_state_json' => ['lat' => 4.020, 'lng' => 97.350, 'zoom' => 10]
]);

echo "Seeded successfully!\n";
