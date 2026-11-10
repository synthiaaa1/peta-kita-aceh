<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RichCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first() ?? User::create([
            'name' => 'Admin Satu Peta Aceh',
            'email' => 'admin@satupeta.acehprov.go.id',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // 1. Instansi (OPD)
        $agencyDLHK = Agency::firstOrCreate(['code' => 'DLHK'], ['name' => 'Dinas Lingkungan Hidup dan Kehutanan Aceh', 'description' => 'Pengelolaan Kehutanan dan Lingkungan Hidup']);
        $agencyDisdik = Agency::firstOrCreate(['code' => 'DISDIK'], ['name' => 'Dinas Pendidikan Aceh', 'description' => 'Fasilitas dan Layanan Pendidikan Aceh']);
        $agencyBPBA = Agency::firstOrCreate(['code' => 'BPBA'], ['name' => 'Badan Penanggulangan Bencana Aceh', 'description' => 'Mitigasi Bencana dan Kedaruratan Spasial']);
        $agencyDinkes = Agency::firstOrCreate(['code' => 'DINKES'], ['name' => 'Dinas Kesehatan Aceh', 'description' => 'Fasilitas Kesehatan dan Rumah Sakit Rujukan']);
        $agencyBappeda = Agency::firstOrCreate(['code' => 'BAPPEDA'], ['name' => 'Bappeda Provinsi Aceh', 'description' => 'Perencanaan Pembangunan dan Tata Ruang']);
        $agencyPUPR = Agency::firstOrCreate(['code' => 'PUPR'], ['name' => 'Dinas Pekerjaan Umum dan Penataan Ruang Aceh', 'description' => 'Infrastruktur Jalan dan Jaringan Drainase']);

        // 2. Kategori Sektor
        $catLingkungan = Category::firstOrCreate(['slug' => 'lingkungan-hidup'], ['name' => 'Lingkungan Hidup & Kehutanan', 'icon' => 'heroicon-o-globe-asia-australia']);
        $catPendidikan = Category::firstOrCreate(['slug' => 'pendidikan'], ['name' => 'Fasilitas Pendidikan', 'icon' => 'heroicon-o-academic-cap']);
        $catBencana = Category::firstOrCreate(['slug' => 'kebencanaan'], ['name' => 'Rawan Bencana & Kedaruratan', 'icon' => 'heroicon-o-exclamation-triangle']);
        $catKesehatan = Category::firstOrCreate(['slug' => 'kesehatan'], ['name' => 'Fasilitas Kesehatan', 'icon' => 'heroicon-o-heart']);
        $catTataRuang = Category::firstOrCreate(['slug' => 'tata-ruang'], ['name' => 'Tata Ruang & Wilayah', 'icon' => 'heroicon-o-map']);
        $catAdministrasi = Category::firstOrCreate(['slug' => 'batas-administrasi'], ['name' => 'Batas Administrasi Desa & Kota', 'icon' => 'heroicon-o-flag']);

        // 3. (Dummy datasets dihapus atas permintaan)
    }
}
