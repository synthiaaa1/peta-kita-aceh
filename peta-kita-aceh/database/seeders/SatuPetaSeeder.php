<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Agency;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\StoryMap;
use App\Models\StoryMapSection;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SatuPetaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Agency
        $agency = Agency::firstOrCreate(
            ['code' => 'BAPPEDA-ACH'],
            [
                'name' => 'Bappeda Provinsi Aceh',
                'description' => 'Badan Perencanaan Pembangunan Daerah Provinsi Aceh'
            ]
        );

        $agency2 = Agency::firstOrCreate(
            ['code' => 'DLHK-ACH'],
            [
                'name' => 'Dinas Lingkungan Hidup dan Kehutanan Aceh',
                'description' => 'Dinas Lingkungan Hidup dan Kehutanan'
            ]
        );

        // 2. Buat Category
        $catTataRuang = Category::firstOrCreate(
            ['slug' => 'tata-ruang'],
            ['name' => 'Tata Ruang', 'icon' => 'heroicon-o-map']
        );
        $catLingkungan = Category::firstOrCreate(
            ['slug' => 'lingkungan'],
            ['name' => 'Lingkungan Hidup', 'icon' => 'heroicon-o-globe-asia-australia']
        );

        // (Dummy dataset 1 dan 2 telah dihapus karena digantikan oleh batas administrasi riil)

        // ==========================================
        // 6. Buat Story Map
        // ==========================================
        $adminUser = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::first();
        $story = StoryMap::firstOrCreate(
            ['slug' => 'cerita-tata-ruang-aceh'],
            [
                'title' => 'Mengintip Tata Ruang Serambi Mekkah',
                'author_id' => $adminUser ? $adminUser->id : 1,
                'status' => 'published',
                'published_at' => Carbon::now(),
            ]
        );

        // Buat Sections untuk Story Map
        StoryMapSection::where('story_map_id', $story->id)->delete();

        StoryMapSection::create([
            'story_map_id' => $story->id,
            'order' => 1,
            'narrative_text' => "Selamat datang di Story Map Aceh.\n\nPada bab ini, kita akan melihat gambaran luas mengenai kawasan Banda Aceh dan sekitarnya yang terus berkembang pesat.",
            'map_state_json' => json_encode([
                'center' => ['lat' => 5.5483, 'lng' => 95.3238],
                'zoom' => 9
            ])
        ]);

        StoryMapSection::create([
            'story_map_id' => $story->id,
            'order' => 2,
            'narrative_text' => "Kawasan Inti (Banda Aceh).\n\nArea hijau terang di peta merepresentasikan kawasan pusat pelayanan dan administrasi utama di Provinsi Aceh.",
            'map_state_json' => json_encode([
                'center' => ['lat' => 5.5483, 'lng' => 95.3238],
                'zoom' => 11
            ])
        ]);
    }
}
