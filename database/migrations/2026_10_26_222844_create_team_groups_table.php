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
        Schema::create('team_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('briefcase');   // briefcase | box | truck | chat
            $table->string('text')->nullable();
            $table->json('members')->nullable();            // [{name, role, text, photo}, ...]
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
        Schema::dropIfExists('team_groups');
    }
};
