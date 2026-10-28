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
        Schema::create('timeline_steps', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('unload');   // container | unload | check | truck | home
            $table->string('title');
            $table->text('text');
            $table->json('points')->nullable();          // 2-3 short bullets
            $table->string('photo')->nullable();
            $table->string('photo_alt')->nullable();
            $table->string('tag')->nullable();           // empty = "Step 1", "Step 2" ...
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
        Schema::dropIfExists('timeline_steps');
    }
};
