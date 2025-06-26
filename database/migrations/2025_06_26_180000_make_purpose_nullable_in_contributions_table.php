<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePurposeNullableInContributionsTable extends Migration
{
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('purpose')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('purpose')->nullable(false)->change();
        });
    }
}
