<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoryMap;
use App\Models\StoryMapSection;
use Illuminate\Support\Str;

class StoryMapSampleSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::first();
        $adminId = $adminUser ? $adminUser->id : 1;

        $story = StoryMap::firstOrCreate(
            ['slug' => 'menjelajah-keindahan-aceh'],
            [
                'title' => 'Menjelajah Keindahan Aceh',
                'status' => 'published',
                'published_at' => now(),
                'author_id' => $adminId
            ]
        );

        StoryMapSection::where('story_map_id', $story->id)->delete();

        StoryMapSection::create([
            'story_map_id' => $story->id,
            'narrative_text' => "**Pendahuluan**\n\nSelamat datang di Aceh!\n\nAceh adalah provinsi di ujung barat Indonesia dengan lanskap alam yang memukau, dari pegunungan Taman Nasional Gunung Leuser hingga keindahan bahari Pulau Weh Sabang.\n\nMari kita mulai perjalanan kita dari pusat ibukotanya, Kota Banda Aceh. Silakan scroll ke bawah untuk melanjutkan perjalanan.",
            'order' => 1,
            'map_state_json' => json_encode([
                'center' => ['lat' => 5.5483, 'lng' => 95.3238],
                'zoom' => 9
            ])
        ]);

        StoryMapSection::create([
            'story_map_id' => $story->id,
            'narrative_text' => "**Kota Banda Aceh**\n\nKota Banda Aceh, Serambi Mekkah.\n\nBanda Aceh kaya akan sejarah, pusat kebudayaan Islam, dan situs sejarah maritim yang indah seperti Masjid Raya Baiturrahman.",
            'order' => 2,
            'map_state_json' => json_encode([
                'center' => ['lat' => 5.5483, 'lng' => 95.3238],
                'zoom' => 13
            ])
        ]);

        StoryMapSection::create([
            'story_map_id' => $story->id,
            'narrative_text' => "**Kota Sabang (Pulau Weh)**\n\nMenuju Titik Nol Km: Sabang.\n\nSurga bahari di utara Sumatra dengan terumbu karang yang menakjubkan dan keindahan pantai pasir putih.",
            'order' => 3,
            'map_state_json' => json_encode([
                'center' => ['lat' => 5.8933, 'lng' => 95.3214],
                'zoom' => 12
            ])
        ]);

        StoryMapSection::create([
            'story_map_id' => $story->id,
            'narrative_text' => "**Dataran Tinggi Gayo (Takengon)**\n\nPesona Danau Laut Tawar & Kopi Gayo.\n\nKawasan pegunungan dengan udara sejuk, keindahan danau alami, dan perkebunan kopi terbaik dunia.",
            'order' => 4,
            'map_state_json' => json_encode([
                'center' => ['lat' => 4.6247, 'lng' => 96.8458],
                'zoom' => 11
            ])
        ]);
    }
}
