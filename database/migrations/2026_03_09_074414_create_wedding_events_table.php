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
        Schema::create('wedding_events', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Event name (e.g., "Akad Nikah", "Resepsi")
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end')->nullable();
            $table->string('location_name');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Event image
            $table->string('gmaps_link')->nullable(); // Google Maps link
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes(); // For soft delete functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weeding_events');
    }
};
