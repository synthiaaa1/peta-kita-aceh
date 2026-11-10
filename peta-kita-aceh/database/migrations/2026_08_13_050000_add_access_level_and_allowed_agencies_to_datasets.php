<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datasets', function (Blueprint $table) {
            $table->string('access_level')->default('public')->after('status'); // public, restricted, private
        });

        Schema::create('dataset_allowed_agencies', function (Blueprint $table) {
            $table->foreignId('dataset_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agency_id')->constrained()->cascadeOnDelete();
            $table->primary(['dataset_id', 'agency_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dataset_allowed_agencies');
        Schema::table('datasets', function (Blueprint $table) {
            $table->dropColumn('access_level');
        });
    }
};
