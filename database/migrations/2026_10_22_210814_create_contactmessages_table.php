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
        Schema::create('contactmessages', function (Blueprint $table) {
            $table->id();

            // who is writing
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('reply_via', 20)->default('any');

            // what they need
            $table->string('topic', 30);
            $table->string('destination', 30)->nullable();
            $table->string('pickup_city')->nullable();
            $table->string('box_size', 30)->nullable();
            $table->text('message');

            // handled in Filament
            $table->string('status', 20)->default('new');
            $table->text('internal_notes')->nullable();

            // basic spam tracing
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactmessages');
    }
};
