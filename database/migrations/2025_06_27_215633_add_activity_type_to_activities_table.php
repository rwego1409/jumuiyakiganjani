<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'activity_type')) {
                $table->string('activity_type')->nullable()->after('properties');
            }
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'activity_type')) {
                $table->dropColumn('activity_type');
            }
        });
    }
};
