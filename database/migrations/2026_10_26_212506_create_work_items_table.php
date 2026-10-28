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
        Schema::create('work_items', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('photo');      // photo | video
            $table->string('category');                    // unloading | deliveries | warehouse | customers
            $table->string('image')->nullable();           // photo, or the video's thumbnail
            $table->string('video_url')->nullable();       // YouTube / Facebook link or .mp4 URL
            $table->string('caption');
            $table->string('meta')->nullable();            // e.g. Manila warehouse · Oct 2026
            $table->text('description')->nullable();       // used by the featured video only
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_items');
    }
};
