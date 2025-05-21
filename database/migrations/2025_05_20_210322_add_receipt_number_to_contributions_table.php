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
    Schema::table('contributions', function (Blueprint $table) {
        $table->string('receipt_number', 50)
            ->nullable()
            ->unique()
            ->after('status')
            ->comment('Payment receipt reference');
    });
}

public function down()
{
    Schema::table('contributions', function (Blueprint $table) {
        $table->dropColumn('receipt_number');
    });
}

    /**
     * Reverse the migrations.
     */
    
};
