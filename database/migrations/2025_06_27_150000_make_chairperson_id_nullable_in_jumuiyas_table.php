<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeChairpersonIdNullableInJumuiyasTable extends Migration
{
    public function up()
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            $table->unsignedBigInteger('chairperson_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            $table->unsignedBigInteger('chairperson_id')->nullable(false)->change();
        });
    }
}
