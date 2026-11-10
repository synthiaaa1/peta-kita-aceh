<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spatial_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layer_id')->constrained()->cascadeOnDelete();
            $table->text('geom')->nullable();
            $table->jsonb('properties')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spatial_features');
    }
};
