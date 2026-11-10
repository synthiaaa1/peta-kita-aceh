<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_map_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_map_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->text('narrative_text')->nullable();
            $table->string('media_path')->nullable();
            $table->jsonb('map_state_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_map_sections');
    }
};
