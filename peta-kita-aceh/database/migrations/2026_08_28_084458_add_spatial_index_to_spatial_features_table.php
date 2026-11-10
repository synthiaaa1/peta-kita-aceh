<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For testing environments where the column might still be 'text', cast it to geometry.
        // In production, it's already 'geometry' so this is safe.
        $hasGeometry = collect(DB::select("SELECT 1 FROM pg_type WHERE typname = 'geometry'"))->isNotEmpty();
        
        if ($hasGeometry) {
            DB::statement('ALTER TABLE spatial_features ALTER COLUMN geom TYPE geometry USING geom::geometry');
            DB::statement('CREATE INDEX IF NOT EXISTS spatial_features_geom_idx ON spatial_features USING GIST (geom)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS spatial_features_geom_idx');
    }
};
