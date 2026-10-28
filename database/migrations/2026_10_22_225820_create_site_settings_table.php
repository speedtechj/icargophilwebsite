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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            // call and email
        $table->string('phone')->nullable();
        $table->string('email')->nullable();

        // chat links
        $table->string('messenger_url')->nullable();
        $table->string('viber_url')->nullable();
        $table->string('whatsapp_url')->nullable();

        // address
        $table->string('address')->nullable();
        $table->text('directions')->nullable();

        // office hours (a list of rows, saved as JSON)
        $table->json('hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
