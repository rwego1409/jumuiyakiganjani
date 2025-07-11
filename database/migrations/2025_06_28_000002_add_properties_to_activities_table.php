<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertiesToActivitiesTable extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'properties')) {
                $table->json('properties')->nullable()->after('model_id');
            }
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'properties')) {
                $table->dropColumn('properties');
            }
        });
    }
}
