<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Agency;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\Layer;
use App\Models\LayerStyle;

class AcehRealBoundariesSeeder extends Seeder
{
    protected string $baseUrl = 'https://raw.githubusercontent.com/JfrAziz/indonesia-district/master/id11_aceh/';

    protected function isPostGisAvailable(): bool
    {
        try {
            $res = DB::select("SELECT 1 FROM pg_extension WHERE extname = 'postgis'");
            return !empty($res);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function run(): void
    {
        // 1. Dapatkan Kategori dan Instansi BAPPEDA / BIRO-PEM
        $catAdministrasi = Category::firstOrCreate(
            ['slug' => 'batas-administrasi'],
            ['name' => 'Batas Administrasi', 'icon' => 'heroicon-o-flag']
        );

        $agencyBiroPem = Agency::firstOrCreate(
            ['code' => 'BIRO-PEM'],
            [
                'name' => 'Biro Pemerintahan dan Otonomi Daerah Setda Aceh',
                'description' => 'Biro Pemerintahan dan Otonomi Daerah Sekretariat Daerah Aceh'
            ]
        );

        $adminUser = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::first();
        $adminId = $adminUser ? $adminUser->id : 1;

        // 2. Buat Tiga Dataset Batas Administrasi Riil (Terpisah)
        $datasetKab = Dataset::updateOrCreate(
            ['slug' => 'batas-kabupaten-kota-aceh-riil'],
            [
                'title' => 'Batas Wilayah Kabupaten/Kota Provinsi Aceh (Riil)',
                'description' => 'Dataset batas wilayah administrasi 23 Kabupaten/Kota se-Provinsi Aceh berbasis poligon asli.',
                'category_id' => $catAdministrasi->id,
                'agency_id' => $agencyBiroPem->id,
                'user_id' => $adminId,
                'status' => 'published',
                'access_level' => 'public',
                'license' => 'Badan Pusat Statistik (BPS) / BNPB',
                'year' => 2026,
                'srid' => 4326,
                'published_at' => now(),
            ]
        );

        $datasetKec = Dataset::updateOrCreate(
            ['slug' => 'batas-kecamatan-aceh-riil'],
            [
                'title' => 'Batas Wilayah Kecamatan Provinsi Aceh (Riil)',
                'description' => 'Dataset batas wilayah administrasi 290 Kecamatan se-Provinsi Aceh berbasis poligon asli.',
                'category_id' => $catAdministrasi->id,
                'agency_id' => $agencyBiroPem->id,
                'user_id' => $adminId,
                'status' => 'published',
                'access_level' => 'public',
                'license' => 'Badan Pusat Statistik (BPS) / BNPB',
                'year' => 2026,
                'srid' => 4326,
                'published_at' => now(),
            ]
        );

        $datasetDesa = Dataset::updateOrCreate(
            ['slug' => 'batas-desa-kelurahan-aceh-riil'],
            [
                'title' => 'Batas Wilayah Desa/Kelurahan Provinsi Aceh (Riil)',
                'description' => 'Dataset batas wilayah administrasi 6.576 Desa/Kelurahan se-Provinsi Aceh berbasis poligon asli.',
                'category_id' => $catAdministrasi->id,
                'agency_id' => $agencyBiroPem->id,
                'user_id' => $adminId,
                'status' => 'published',
                'access_level' => 'public',
                'license' => 'Badan Pusat Statistik (BPS) / BNPB',
                'year' => 2026,
                'srid' => 4326,
                'published_at' => now(),
            ]
        );

        // 3. Buat/Update Layer untuk Kabupaten/Kota, Kecamatan, dan Desa
        $layerKabupaten = Layer::updateOrCreate(
            ['name' => 'Batas Kabupaten/Kota (Riil)'],
            [
                'dataset_id' => $datasetKab->id,
                'geometry_type' => 'polygon',
                'source_type' => 'vector_table',
                'source_reference' => 'spatial_features',
                'is_active' => true,
            ]
        );

        $layerKecamatan = Layer::updateOrCreate(
            ['name' => 'Batas Kecamatan (Riil)'],
            [
                'dataset_id' => $datasetKec->id,
                'geometry_type' => 'polygon',
                'source_type' => 'vector_table',
                'source_reference' => 'spatial_features',
                'is_active' => true,
            ]
        );

        $layerDesa = Layer::updateOrCreate(
            ['name' => 'Batas Desa/Kelurahan (Riil)'],
            [
                'dataset_id' => $datasetDesa->id,
                'geometry_type' => 'polygon',
                'source_type' => 'vector_table',
                'source_reference' => 'spatial_features',
                'is_active' => true,
            ]
        );

        // Set style untuk kabupaten
        LayerStyle::updateOrCreate(
            ['layer_id' => $layerKabupaten->id],
            [
                'fill_color' => '#0284c7',
                'stroke_color' => '#0369a1',
                'stroke_width' => 2.5,
                'opacity' => 0.15
            ]
        );

        // Set style untuk kecamatan
        LayerStyle::updateOrCreate(
            ['layer_id' => $layerKecamatan->id],
            [
                'fill_color' => '#10b981',
                'stroke_color' => '#047857',
                'stroke_width' => 1.5,
                'opacity' => 0.08
            ]
        );

        // Set style untuk desa
        LayerStyle::updateOrCreate(
            ['layer_id' => $layerDesa->id],
            [
                'fill_color' => '#6b7280',
                'stroke_color' => '#9ca3af',
                'stroke_width' => 0.8,
                'opacity' => 0.04
            ]
        );

        // Cek jika data spasial sudah terpopulasi lengkap untuk menghindari download ulang
        $hasFeatures = DB::table('spatial_features')->where('layer_id', $layerDesa->id)->count() >= 6000;
        
        if ($hasFeatures) {
            $this->command->info("Data batas wilayah riil sudah terpopulasi lengkap di database. Melewati proses pengunduhan.");
            // Hapus dataset gabungan lama yang sekarang yatim piatu
            Dataset::where('slug', 'batas-wilayah-administrasi-aceh-riil')->delete();
            return;
        }

        // Bersihkan data lama pada layer tujuan (hanya jika data kosong/belum lengkap)
        DB::table('spatial_features')->whereIn('layer_id', [$layerKabupaten->id, $layerKecamatan->id, $layerDesa->id])->delete();

        // 4. Periksa ketersediaan PostGIS
        $hasPostGis = $this->isPostGisAvailable();

        if (!$hasPostGis) {
            $this->command->warn("PostGIS tidak terdeteksi! Memasukkan data batas wilayah tiruan (dummy fallback) untuk testing...");
            $this->seedDummyFallback($layerKabupaten->id, $layerKecamatan->id, $layerDesa->id);
            return;
        }

        $regencyPaths = [
            'id1101_simeulue/id1101_simeulue.geojson',
            'id1102_aceh_singkil/id1102_aceh_singkil.geojson',
            'id1103_aceh_selatan/id1103_aceh_selatan.geojson',
            'id1104_aceh_tenggara/id1104_aceh_tenggara.geojson',
            'id1105_aceh_timur/id1105_aceh_timur.geojson',
            'id1106_aceh_tengah/id1106_aceh_tengah.geojson',
            'id1107_aceh_barat/id1107_aceh_barat.geojson',
            'id1108_aceh_besar/id1108_aceh_besar.geojson',
            'id1109_pidie/id1109_pidie.geojson',
            'id1110_bireuen/id1110_bireuen.geojson',
            'id1111_aceh_utara/id1111_aceh_utara.geojson',
            'id1112_aceh_barat_daya/id1112_aceh_barat_daya.geojson',
            'id1113_gayo_lues/id1113_gayo_lues.geojson',
            'id1114_aceh_tamiang/id1114_aceh_tamiang.geojson',
            'id1115_nagan_raya/id1115_nagan_raya.geojson',
            'id1116_aceh_jaya/id1116_aceh_jaya.geojson',
            'id1117_bener_meriah/id1117_bener_meriah.geojson',
            'id1118_pidie_jaya/id1118_pidie_jaya.geojson',
            'id1171_kota_banda_aceh/id1171_kota_banda_aceh.geojson',
            'id1172_kota_sabang/id1172_kota_sabang.geojson',
            'id1173_kota_langsa/id1173_kota_langsa.geojson',
            'id1174_kota_lhokseumawe/id1174_kota_lhokseumawe.geojson',
            'id1175_kota_subulussalam/id1175_kota_subulussalam.geojson'
        ];

        $this->command->info("Memulai pengunduhan data spasial desa dari GitHub...");

        $totalFeatures = 0;
        foreach ($regencyPaths as $path) {
            $regencyName = ucwords(str_replace('_', ' ', explode('/', explode('_', $path)[1] ?? '')[0] ?? ''));
            $this->command->comment("Mengunduh data batas desa: $regencyName...");
            
            try {
                $response = Http::timeout(120)->get($this->baseUrl . $path);
                
                if ($response->successful()) {
                    $geoJson = $response->json();
                    $features = $geoJson['features'] ?? [];
                    
                    $this->command->info("  Berhasil. Memproses " . count($features) . " fitur desa...");
                    
                    DB::beginTransaction();
                    foreach ($features as $f) {
                        $props = $f['properties'] ?? [];
                        
                        // Properti terstruktur agar memiliki label 'nama' dan metadata induk
                        $cleanProps = [
                            'nama' => $props['village'] ?? 'Desa',
                            'district' => $props['district'] ?? 'Kecamatan',
                            'regency' => $props['regency'] ?? 'Aceh',
                            'regency_code' => $props['regency_code'] ?? '',
                            'district_code' => $props['district_code'] ?? '',
                            'village_code' => $props['village_code'] ?? '',
                            'provinsi' => 'Aceh'
                        ];
                        
                        $geometryJson = json_encode($f['geometry']);
                        $propertiesJson = json_encode($cleanProps);
                        
                        DB::statement(
                            'INSERT INTO spatial_features (layer_id, geom, properties, created_at, updated_at) 
                             VALUES (?, ST_SetSRID(ST_GeomFromGeoJSON(?), 4326), ?::jsonb, NOW(), NOW())',
                            [$layerDesa->id, $geometryJson, $propertiesJson]
                        );
                        
                        $totalFeatures++;
                    }
                    DB::commit();
                } else {
                    $this->command->error("  Gagal mengunduh path: $path (HTTP: " . $response->status() . ")");
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("  Kesalahan saat memproses $regencyName: " . $e->getMessage());
            }
        }

        $this->command->info("Selesai mengunduh. Total batas desa diimpor secara permanen: $totalFeatures.");

        if ($totalFeatures === 0) {
            $this->command->warn("Tidak ada data desa yang berhasil diimpor. Menggunakan fallback dummy...");
            $this->seedDummyFallback($layerKabupaten->id, $layerKecamatan->id, $layerDesa->id);
            return;
        }

        // 6. Jalankan PostGIS ST_Union untuk menghasilkan poligon Kabupaten/Kota dari batas desa
        $this->command->comment("Melakukan PostGIS ST_Union untuk Batas Kabupaten/Kota...");
        DB::statement("
            INSERT INTO spatial_features (layer_id, geom, properties, created_at, updated_at)
            SELECT 
                ?, 
                ST_Multi(ST_Union(geom)), 
                json_build_object(
                    'nama', properties->>'regency',
                    'regency_code', properties->>'regency_code',
                    'provinsi', 'Aceh'
                )::jsonb, 
                NOW(), 
                NOW()
            FROM spatial_features
            WHERE layer_id = ?
            GROUP BY properties->>'regency', properties->>'regency_code'
        ", [$layerKabupaten->id, $layerDesa->id]);

        // 7. Jalankan PostGIS ST_Union untuk menghasilkan poligon Kecamatan dari batas desa
        $this->command->comment("Melakukan PostGIS ST_Union untuk Batas Kecamatan...");
        DB::statement("
            INSERT INTO spatial_features (layer_id, geom, properties, created_at, updated_at)
            SELECT 
                ?, 
                ST_Multi(ST_Union(geom)), 
                json_build_object(
                    'nama', properties->>'district',
                    'kabupaten', properties->>'regency',
                    'regency_code', properties->>'regency_code',
                    'district_code', properties->>'district_code',
                    'provinsi', 'Aceh'
                )::jsonb, 
                NOW(), 
                NOW()
            FROM spatial_features
            WHERE layer_id = ?
            GROUP BY properties->>'regency', properties->>'district', properties->>'regency_code', properties->>'district_code'
        ", [$layerKecamatan->id, $layerDesa->id]);

        $this->command->info("Selesai! Batas Administrasi Kabupaten/Kota, Kecamatan, dan Desa berhasil diimpor.");
    }

    /**
     * Fallback dummy seeder if PostGIS is not available or if download fails
     */
    protected function seedDummyFallback($layerKabId, $layerKecId, $layerDesaId): void
    {
        $regencies = [
            ['name' => 'Banda Aceh', 'code' => '1171', 'lat' => 5.5483, 'lng' => 95.3238, 'districts' => ['Syiah Kuala', 'Kuta Alam', 'Baiturrahman', 'Meuraxa']],
            ['name' => 'Aceh Besar', 'code' => '1108', 'lat' => 5.3000, 'lng' => 95.6000, 'districts' => ['Darussalam', 'Krueng Barona Jaya', 'Ingin Jaya', 'Lhoknga']],
            ['name' => 'Lhokseumawe', 'code' => '1173', 'lat' => 5.1801, 'lng' => 97.1407, 'districts' => ['Muara Dua', 'Banda Sakti', 'Muara Satu', 'Blang Mangat']],
            ['name' => 'Langsa', 'code' => '1174', 'lat' => 4.4683, 'lng' => 97.9683, 'districts' => ['Langsa Barat', 'Langsa Kota', 'Langsa Timur', 'Langsa Lama']],
            ['name' => 'Simeulue', 'code' => '1101', 'lat' => 2.6416, 'lng' => 96.0000, 'districts' => ['Teupah Barat', 'Teupah Selatan', 'Simeulue Timur', 'Teluk Dalam']],
        ];

        $hasPostGis = $this->isPostGisAvailable();

        foreach ($regencies as $reg) {
            $lat = $reg['lat'];
            $lng = $reg['lng'];
            $size = 0.08;

            $kabGeom = [
                'type' => 'Polygon',
                'coordinates' => [[
                    [$lng - $size, $lat - $size],
                    [$lng + $size, $lat - $size],
                    [$lng + $size, $lat + $size],
                    [$lng - $size, $lat + $size],
                    [$lng - $size, $lat - $size],
                ]]
            ];

            $kabProps = [
                'nama' => $reg['name'],
                'regency_code' => $reg['code'],
                'provinsi' => 'Aceh'
            ];

            $this->insertFeature($layerKabId, $kabGeom, $kabProps, $hasPostGis);

            // Generate kecamatan sub-polygons
            foreach ($reg['districts'] as $idx => $distName) {
                $subSize = 0.035;
                $offsetLat = ($idx % 2 === 0 ? 1 : -1) * 0.04;
                $offsetLng = ($idx >= 2 ? 1 : -1) * 0.04;
                
                $cLat = $lat + $offsetLat;
                $cLng = $lng + $offsetLng;

                $kecGeom = [
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [$cLng - $subSize, $cLat - $subSize],
                        [$cLng + $subSize, $cLat - $subSize],
                        [$cLng + $subSize, $cLat + $subSize],
                        [$cLng - $subSize, $cLat + $subSize],
                        [$cLng - $subSize, $cLat - $subSize],
                    ]]
                ];

                $kecProps = [
                    'nama' => $distName,
                    'kabupaten' => $reg['name'],
                    'regency_code' => $reg['code'],
                    'district_code' => $reg['code'] . '0' . ($idx + 1),
                    'provinsi' => 'Aceh'
                ];

                $this->insertFeature($layerKecId, $kecGeom, $kecProps, $hasPostGis);

                // Generate 3 dummy villages inside this kecamatan
                for ($d = 1; $d <= 3; $d++) {
                    $dName = "Desa " . $distName . " " . $d;
                    $dCode = $reg['code'] . '0' . ($idx + 1) . '00' . $d;

                    $dSize = 0.01;
                    $dOffsetLat = ($d === 1 ? 0.015 : ($d === 2 ? -0.015 : 0));
                    $dOffsetLng = ($d === 1 ? -0.015 : ($d === 2 ? 0.015 : 0));

                    $dLat = $cLat + $dOffsetLat;
                    $dLng = $cLng + $dOffsetLng;

                    $desaGeom = [
                        'type' => 'Polygon',
                        'coordinates' => [[
                            [$dLng - $dSize, $dLat - $dSize],
                            [$dLng + $dSize, $dLat - $dSize],
                            [$dLng + $dSize, $dLat + $dSize],
                            [$dLng - $dSize, $dLat + $dSize],
                            [$dLng - $dSize, $dLat - $dSize],
                        ]]
                    ];

                    $desaProps = [
                        'nama' => $dName,
                        'district' => $distName,
                        'regency' => $reg['name'],
                        'regency_code' => $reg['code'],
                        'district_code' => $reg['code'] . '0' . ($idx + 1),
                        'village_code' => $dCode,
                        'provinsi' => 'Aceh'
                    ];

                    $this->insertFeature($layerDesaId, $desaGeom, $desaProps, $hasPostGis);
                }
            }
        }
    }

    protected function insertFeature($layerId, array $geom, array $props, bool $hasPostGis): void
    {
        $geometryJson = json_encode($geom);
        $propertiesJson = json_encode($props);

        if ($hasPostGis) {
            DB::statement(
                'INSERT INTO spatial_features (layer_id, geom, properties, created_at, updated_at) 
                 VALUES (?, ST_SetSRID(ST_GeomFromGeoJSON(?), 4326), ?::jsonb, NOW(), NOW())',
                [$layerId, $geometryJson, $propertiesJson]
            );
        } else {
            DB::table('spatial_features')->insert([
                'layer_id' => $layerId,
                'geom' => $geometryJson,
                'properties' => $propertiesJson,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
