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
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('accent_color')->nullable();
            $table->string('light_color')->nullable();
            $table->string('very_light_color')->nullable();
            $table->string('dark_color')->nullable();
            $table->string('backgrond_image')->nullable();
            $table->string('decor_top_left_image')->nullable();
            $table->string('decor_top_right_image')->nullable();
            $table->string('decor_bottom_left_image')->nullable();
            $table->string('decor_bottom_right_image')->nullable();
            $table->string('decor_falling_petal_image')->nullable();
            $table->float('bg_mask_alpha')->nullable();
            $table->float('hero_mask_alpha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
