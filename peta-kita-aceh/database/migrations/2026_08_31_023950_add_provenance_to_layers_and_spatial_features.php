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
            if (!Schema::hasColumn('layers', 'source_type')) {
                $table->string('source_type')->nullable()->comment('Contoh: sig_aceh, opd, bnpb, bpba, boundary');
            }
            if (!Schema::hasColumn('layers', 'geometry_available')) {
                $table->boolean('geometry_available')->default(true)->comment('Apakah layer memiliki data spatial (geometry)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layers', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'geometry_available']);
        });
    }
};
