<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jumuiya_notifications', function (Blueprint $table) {
            $table->boolean('send_whatsapp')->default(false)->after('action_url');
        });
    }

    public function down()
    {
        Schema::table('jumuiya_notifications', function (Blueprint $table) {
            $table->dropColumn('send_whatsapp');
        });
    }
};
