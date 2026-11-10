<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MasterDataSeeder::class,
        ]);

        // 1. Buat Super Admin
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin (Administrator)',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'agency_id' => null,
            ]
        );

        // 2. Buat Operator Dinas PUPR Aceh
        $puprAgency = \App\Models\Agency::where('code', 'PUPR')->first();
        \App\Models\User::firstOrCreate(
            ['email' => 'pupr@aceh.go.id'],
            [
                'name' => 'Operator Dinas PUPR Aceh',
                'password' => bcrypt('operator123'),
                'role' => 'operator',
                'agency_id' => $puprAgency ? $puprAgency->id : null,
            ]
        );

        // 3. Buat Operator Dinas Kesehatan Aceh
        $dinkesAgency = \App\Models\Agency::where('code', 'DINKES')->first();
        \App\Models\User::firstOrCreate(
            ['email' => 'dinkes@aceh.go.id'],
            [
                'name' => 'Operator Dinas Kesehatan Aceh',
                'password' => bcrypt('operator123'),
                'role' => 'operator',
                'agency_id' => $dinkesAgency ? $dinkesAgency->id : null,
            ]
        );

        // 4. Buat Operator DLHK Aceh
        $dlhkAgency = \App\Models\Agency::where('code', 'DLHK')->first();
        \App\Models\User::firstOrCreate(
            ['email' => 'dlhk@aceh.go.id'],
            [
                'name' => 'Operator DLHK Aceh',
                'password' => bcrypt('operator123'),
                'role' => 'operator',
                'agency_id' => $dlhkAgency ? $dlhkAgency->id : null,
            ]
        );

        $this->call([
            StoryMapSampleSeeder::class,
            AcehRealBoundariesSeeder::class,
        ]);

        // Automatically sync all 143 datasets from SIG Aceh API v2 & BNPB API
        // (Dummy sync disabled untuk production)
        // app(\App\Services\SigAcehIntegrationService::class)->syncSigAcehDatasets();
        // app(\App\Services\SigAcehIntegrationService::class)->syncNationalBnpbData();
    }
}
