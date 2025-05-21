<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContributionStatusEnum extends Migration
{
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            // Use raw SQL or a package (if available) to change the enum values.
            $table->enum('status', ['pending', 'initiated', 'paid', 'failed'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending')->change();
        });
    }
}
