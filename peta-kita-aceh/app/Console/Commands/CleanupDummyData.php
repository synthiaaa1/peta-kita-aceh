<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Layer;

class CleanupDummyData extends Command
{
    protected $signature = 'sig:cleanup-dummy {--force : Hapus data tanpa konfirmasi}';
    protected $description = 'Inventarisasi dan bersihkan data spatial dummy (BNPB & SIG Aceh Fallback)';

    public function handle()
    {
        $this->info("=== Inventarisasi Data Dummy ===");

        // 1. Identifikasi BNPB Dummy
        $bnpbCount = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber' = 'BNPB Indonesia / SIG Aceh'")
            ->count();
        $this->info("BNPB Dummy Geometries Ditemukan: {$bnpbCount}");

        // 2. Identifikasi SIG Aceh Dummy (Fallback)
        $sigAcehCount = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber_api' = 'sig.acehprov.go.id/api/v2'")
            ->count();
        $this->info("SIG Aceh Fallback Dummy Geometries Ditemukan: {$sigAcehCount}");

        $totalDummy = $bnpbCount + $sigAcehCount;
        
        if ($totalDummy === 0) {
            $this->info("Tidak ada data dummy yang ditemukan di tabel spatial_features.");
            return;
        }

        if (!$this->option('force')) {
            if (!$this->confirm("Ditemukan {$totalDummy} data dummy. Yakin ingin menghapusnya permanen?", false)) {
                $this->warn("Operasi dibatalkan. Tidak ada data yang dihapus.");
                return;
            }
        }

        $this->info("Menghapus data...");
        
        $deletedBnpb = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber' = 'BNPB Indonesia / SIG Aceh'")
            ->delete();
            
        $deletedSig = DB::table('spatial_features')
            ->whereRaw("properties->>'sumber_api' = 'sig.acehprov.go.id/api/v2'")
            ->delete();

        // Update layer geometry_available yang terdampak
        Layer::where('source_type', 'bnpb')->orWhere('source_type', 'sig_aceh')->update(['geometry_available' => false]);

        $this->info("Berhasil dihapus. BNPB: {$deletedBnpb} baris, SIG Aceh: {$deletedSig} baris.");
    }
}
