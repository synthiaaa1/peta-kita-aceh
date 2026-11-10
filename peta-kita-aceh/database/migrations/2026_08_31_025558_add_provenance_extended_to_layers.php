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
        Schema::table('layers', function (Blueprint $table) {
            if (!Schema::hasColumn('layers', 'source_url')) {
                $table->text('source_url')->nullable()->comment('URL asli sumber spasial (misal WFS/GeoJSON endpoint)');
            }
            if (!Schema::hasColumn('layers', 'last_synced_at')) {
                $table->timestamp('last_synced_at')->nullable()->comment('Waktu terakhir sinkronisasi spasial');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layers', function (Blueprint $table) {
            $table->dropColumn(['source_url', 'last_synced_at']);
        });
    }
};
