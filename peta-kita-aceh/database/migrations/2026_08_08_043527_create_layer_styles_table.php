<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layer_styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layer_id')->constrained()->cascadeOnDelete();
            $table->string('fill_color')->nullable();
            $table->string('stroke_color')->nullable();
            $table->decimal('stroke_width', 8, 2)->nullable();
            $table->decimal('opacity', 3, 2)->default(1.00);
            $table->jsonb('style_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layer_styles');
    }
};
