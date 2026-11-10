<?php

namespace App\Console\Commands;

use App\Services\SigAcehIntegrationService;
use Illuminate\Console\Command;

class SyncSigAcehData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sig:sync-aceh {--source=all : Source to sync: aceh, bnpb, or all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarik dan integrasikan data spasial otomatis dari API SIG Aceh (sig.acehprov.go.id/api/v2) dan instansi nasional BNPB';

    /**
     * Execute the console command.
     */
    public function handle(SigAcehIntegrationService $service): int
    {
        $source = $this->option('source');

        $this->info("Memulai sinkronisasi data spasial...");

        if ($source === 'all' || $source === 'aceh') {
            $this->info("Menarik 143 dataset publik dari Portal SIG Aceh (sig.acehprov.go.id/api/v2)...");
            $resultAceh = $service->syncSigAcehDatasets();
            $this->info($resultAceh['message']);
        }

        if ($source === 'all' || $source === 'bnpb') {
            $this->info("Menarik data kebencanaan dari API Nasional BNPB...");
            $resultBnpb = $service->syncNationalBnpbData();
            $this->info($resultBnpb['message']);
        }

        $this->info("Sinkronisasi data API selesai secara otomatis!");

        return Command::SUCCESS;
    }
}
