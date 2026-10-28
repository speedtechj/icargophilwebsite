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
        Schema::create('team_pages', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('team_photo')->nullable();          // one picture of the whole team
            $table->string('team_photo_caption')->nullable();
            $table->string('leader_name')->nullable();
            $table->string('leader_role')->nullable();
            $table->text('leader_text')->nullable();
            $table->string('leader_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_pages');
    }
};
