<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMemberIdNullableInContributions extends Migration
{
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable(false)->change();
        });
    }
}