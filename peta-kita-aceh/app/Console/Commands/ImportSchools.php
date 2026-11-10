<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSchools extends Command
{
    protected $signature = 'import:schools';
    protected $description = 'Import schools CSV to layer 6';

    public function handle()
    {
        $csvPath = 'd:/JOKI/PETA/sekolah_jawa_barat.csv';
        if (!file_exists($csvPath)) {
            $this->error('File not found!');
            return;
        }

        $file = fopen($csvPath, 'r');
        $headerLine = fgets($file);
        $headerLine = trim($headerLine);
        $headerLine = rtrim($headerLine, ';');
        $headers = str_getcsv($headerLine);

        $this->info('Start importing...');
        
        $layerId = 6;
        $count = 0;
        $batch = [];
        
        // To avoid memory exhaustion or long query execution, insert in batches
        while (($line = fgets($file)) !== false) {
            $line = trim($line);
            if (empty($line)) continue;
            
            $line = rtrim($line, ';');
            $row = str_getcsv($line);
            
            if (count($headers) !== count($row)) {
                continue; // Skip malformed rows
            }

            $data = array_combine($headers, $row);
            
            $lat = $data['lat'] ?? null;
            $lng = $data['long'] ?? null;
            
            if (is_numeric($lat) && is_numeric($lng)) {
                $batch[] = [
                    'layer_id' => $layerId,
                    'properties' => json_encode($data),
                    'geom' => DB::raw("ST_GeomFromText('POINT($lng $lat)')"),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $count++;
            }
            
            if (count($batch) >= 1000) {
                DB::table('spatial_features')->insert($batch);
                $batch = [];
                $this->info("Imported $count...");
            }
        }
        
        if (count($batch) > 0) {
            DB::table('spatial_features')->insert($batch);
        }
        
        fclose($file);
        $this->info("Finished! Total records: $count");
    }
}
