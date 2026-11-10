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
        Schema::table('dataset_downloads', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('layer_id')->constrained()->nullOnDelete();
            $table->timestamp('downloaded_at')->nullable()->useCurrent()->after('user_agent');
            $table->timestamp('updated_at')->nullable()->useCurrent()->after('downloaded_at');
            
            // Add indexes for analytics
            $table->index('user_id');
            $table->index('created_at');
            $table->index('downloaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dataset_downloads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['downloaded_at']);
            $table->dropColumn(['user_id', 'downloaded_at', 'updated_at']);
        });
    }
};
