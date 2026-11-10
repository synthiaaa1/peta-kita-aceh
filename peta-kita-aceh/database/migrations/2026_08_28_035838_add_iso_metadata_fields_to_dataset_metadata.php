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
        Schema::table('dataset_metadata', function (Blueprint $table) {
            // A. IDENTITAS DATASET
            $table->string('alternative_title')->nullable()->after('dataset_id');
            $table->text('abstract')->nullable()->after('alternative_title');
            $table->string('purpose')->nullable()->after('abstract');
            $table->string('dataset_type')->default('dataset')->after('purpose'); // dataset, series, service
            $table->string('topic_category')->nullable()->after('dataset_type');
            $table->jsonb('keywords')->nullable()->after('topic_category');

            // B. INFORMASI PRODUSEN DATA
            $table->string('contact_email')->nullable()->after('contact_person');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('metadata_author')->nullable()->after('contact_phone');

            // C. INFORMASI SPASIAL
            $table->string('spatial_representation_type')->nullable()->after('metadata_author'); // vector, grid, textTable, etc.
            $table->string('geometry_type')->nullable()->after('spatial_representation_type'); // point, line, polygon, etc.
            $table->string('scale_denominator')->nullable()->after('coordinate_system');
            $table->jsonb('bounding_box')->nullable()->after('scale_denominator'); // [minX, minY, maxX, maxY]

            // D. INFORMASI TEMPORAL
            $table->date('temporal_start')->nullable()->after('bounding_box');
            $table->date('temporal_end')->nullable()->after('temporal_start');
            $table->date('last_update_date')->nullable()->after('temporal_end');
            // update_frequency is already in the table

            // E. KUALITAS DAN SUMBER DATA
            $table->text('data_quality_statement')->nullable()->after('update_frequency');
            $table->text('lineage')->nullable()->after('data_quality_statement');
            $table->text('accuracy_statement')->nullable()->after('lineage');
            $table->text('completeness_statement')->nullable()->after('accuracy_statement');

            // F. DISTRIBUSI DAN AKSES
            // access_level and license are in `datasets` table.
            $table->text('usage_constraints')->nullable()->after('completeness_statement');
            $table->string('download_format')->nullable()->after('usage_constraints'); // GeoJSON, SHP, KML, etc.
            
            // IDENTIFIER
            $table->string('metadata_identifier')->nullable()->unique()->after('id'); // e.g. ACEH-2024-001
            
            // Indexes for Search/Filter
            $table->index('dataset_type');
            $table->index('topic_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dataset_metadata', function (Blueprint $table) {
            $table->dropIndex(['dataset_type']);
            $table->dropIndex(['topic_category']);
            $table->dropColumn([
                'metadata_identifier',
                'alternative_title', 'abstract', 'purpose', 'dataset_type', 'topic_category', 'keywords',
                'contact_email', 'contact_phone', 'metadata_author',
                'spatial_representation_type', 'geometry_type', 'scale_denominator', 'bounding_box',
                'temporal_start', 'temporal_end', 'last_update_date',
                'data_quality_statement', 'lineage', 'accuracy_statement', 'completeness_statement',
                'usage_constraints', 'download_format'
            ]);
        });
    }
};
