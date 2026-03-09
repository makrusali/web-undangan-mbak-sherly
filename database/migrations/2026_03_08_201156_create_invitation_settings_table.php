<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invitation_settings', function (Blueprint $table) {
            $table->id();

            // First section image
            $table->string('hero_image')->nullable();

            // Invitation text with template (supports {{guest}})
            $table->text('invitation_text')->nullable();

            // Message template for WhatsApp
            $table->text('message_template')->nullable()->comment('Template for WhatsApp messages with {{guest}} placeholder');

            // Groom info
            $table->string('groom_nickname')->nullable();
            $table->string('groom_fullname')->nullable();
            $table->string('groom_photo')->nullable();
            $table->string('groom_parents')->nullable();
            $table->string('groom_instagram')->nullable();

            // Bride info
            $table->string('bride_nickname')->nullable();
            $table->string('bride_fullname')->nullable();
            $table->string('bride_photo')->nullable();
            $table->string('bride_parents')->nullable();
            $table->string('bride_instagram')->nullable();

            // Love story (using quill - long text)
            $table->longText('love_story')->nullable();

            // Couple photo and thanks message
            $table->string('couple_photo')->nullable();
            $table->longText('thanks_message')->nullable();

            // Song/Audio
            $table->string('song_file')->nullable();
            $table->string('song_title')->nullable();
            $table->string('song_artist')->nullable();
            $table->boolean('song_autoplay')->default(false);

            // Active status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitation_settings');
    }
};
