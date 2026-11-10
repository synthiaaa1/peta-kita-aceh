<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Category;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Instansi (OPD) Aceh
        $agencies = [
            ['code' => 'BAPPEDA', 'name' => 'Badan Perencanaan Pembangunan Daerah Aceh', 'desc' => 'Perencanaan Pembangunan dan Tata Ruang Aceh'],
            ['code' => 'PUPR', 'name' => 'Dinas Pekerjaan Umum dan Penataan Ruang Aceh', 'desc' => 'Infrastruktur Jalan, Jembatan, dan Penataan Ruang'],
            ['code' => 'DLHK', 'name' => 'Dinas Lingkungan Hidup dan Kehutanan Aceh', 'desc' => 'Pengelolaan dan Konservasi Hutan Aceh'],
            ['code' => 'DINKES', 'name' => 'Dinas Kesehatan Aceh', 'desc' => 'Fasilitas Kesehatan dan Medis Aceh'],
            ['code' => 'DISDIK', 'name' => 'Dinas Pendidikan Aceh', 'desc' => 'Fasilitas Pendidikan dan Sekolah Aceh'],
            ['code' => 'BPBA', 'name' => 'Badan Penanggulangan Bencana Aceh', 'desc' => 'Mitigasi Bencana dan Kedaruratan Aceh'],
            ['code' => 'DISTANBUN', 'name' => 'Dinas Pertanian dan Perkebunan Aceh', 'desc' => 'Lahan Pertanian dan Ketahanan Pangan'],
            ['code' => 'BIRO-PEM', 'name' => 'Biro Pemerintahan dan Otonomi Daerah Setda Aceh', 'desc' => 'Batas Administrasi dan Wilayah Aceh'],
        ];

        foreach ($agencies as $a) {
            Agency::firstOrCreate(
                ['code' => $a['code']],
                ['name' => $a['name'], 'description' => $a['desc']]
            );
        }

        // 2. Data Kategori Peta
        $categories = [
            ['slug' => 'tata-ruang', 'name' => 'Tata Ruang', 'icon' => 'heroicon-o-map'],
            ['slug' => 'batas-administrasi', 'name' => 'Batas Administrasi', 'icon' => 'heroicon-o-flag'],
            ['slug' => 'infrastruktur', 'name' => 'Infrastruktur & Jaringan', 'icon' => 'heroicon-o-truck'],
            ['slug' => 'lingkungan-hidup', 'name' => 'Lingkungan Hidup & Kehutanan', 'icon' => 'heroicon-o-globe-asia-australia'],
            ['slug' => 'sosial-kependudukan', 'name' => 'Sosial & Kependudukan', 'icon' => 'heroicon-o-users'],
            ['slug' => 'kebencanaan', 'name' => 'Rawan Bencana', 'icon' => 'heroicon-o-exclamation-triangle'],
            ['slug' => 'kesehatan', 'name' => 'Fasilitas Kesehatan', 'icon' => 'heroicon-o-heart'],
            ['slug' => 'pendidikan', 'name' => 'Fasilitas Pendidikan', 'icon' => 'heroicon-o-academic-cap'],
        ];

        foreach ($categories as $c) {
            Category::firstOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name'], 'icon' => $c['icon']]
            );
        }
    }
}
