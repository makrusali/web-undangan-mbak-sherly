<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invitation_settings', function (Blueprint $table) {
            $table->integer('max_guest')->nullable()->after('message_template')->comment('Maksimal orang per undangan');
        });
    }

    public function down()
    {
        Schema::table('invitation_settings', function (Blueprint $table) {
            $table->dropColumn('max_guest');
        });
    }
};
