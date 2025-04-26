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
    Schema::table('events', function (Blueprint $table) {
        $table->boolean('is_active')->default(true); // Add is_active column with a default value of true
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
}

};
