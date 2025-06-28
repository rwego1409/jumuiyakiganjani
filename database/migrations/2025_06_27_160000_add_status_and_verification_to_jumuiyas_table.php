<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndVerificationToJumuiyasTable extends Migration
{
    public function up()
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            $table->string('status')->default('active');
            $table->boolean('is_verified')->default(false);
        });
    }

    public function down()
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            $table->dropColumn(['status', 'is_verified']);
        });
    }
}
