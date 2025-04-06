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
        Schema::table('resources', function (Blueprint $table) {
            // Remove the 'after' clause or specify an existing column
            $table->unsignedBigInteger('view_count')->default(0);
            // OR if you know an existing column:
            // $table->unsignedBigInteger('view_count')->default(0)->after('file_path');
        });
    }
    
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('view_count');
        });
    }
};
