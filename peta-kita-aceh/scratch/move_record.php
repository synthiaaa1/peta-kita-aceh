<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$story = App\Models\StoryMap::where('title', 'like', '%banjir%')->first();
if ($story) {
    $t = new App\Models\ThematicMap();
    $t->title = $story->title;
    $t->slug = $story->slug ?? \Illuminate\Support\Str::slug($story->title);
    $t->description = $story->content ?? $story->description ?? '';
    $t->type = 'interactive'; // Set to interactive since it's a webmap according to user's screenshot
    $t->status = 'published';
    $t->thumbnail = $story->cover_image; // map the image
    $t->agency_id = $story->agency_id ?? \App\Models\Agency::first()->id ?? 1;
    $t->save();
    
    // delete the original story
    $story->delete();
    
    echo "Moved successfully: " . $t->title;
} else {
    echo "Not found";
}
