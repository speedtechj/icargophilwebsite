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
        Schema::create('our_stories', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();
            $table->string('lead')->nullable();
            $table->json('paragraphs')->nullable();
            $table->text('quote')->nullable();
            $table->string('founder')->nullable();
            $table->string('role')->nullable();
            $table->string('since', 10)->nullable();
            $table->string('photo')->nullable();        // one picture only
            $table->string('photo_alt')->nullable();
            $table->json('milestones')->nullable();     // [{year, label}, ...]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_stories');
    }
};
