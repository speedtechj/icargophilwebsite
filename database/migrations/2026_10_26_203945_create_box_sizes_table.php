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
        Schema::create('box_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // Small
            $table->string('dimensions');                     // 18 × 18 × 18 in
            $table->string('best_for')->nullable();           // Clothes, shoes and small gifts
            $table->decimal('price', 8, 2)->default(0);       // starting price
            $table->unsignedTinyInteger('scale')->default(2); // 1-4, size of the drawn box
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('points')->nullable();               // 2-3 short bullets
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_sizes');
    }
};
