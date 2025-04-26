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
        // Check if the 'status' column exists before adding it
        if (!Schema::hasColumn('contributions', 'status')) {
            Schema::table('contributions', function (Blueprint $table) {
                $table->enum('status', ['pending', 'verified', 'rejected', 'confirmed'])  // Added 'confirmed'
                    ->default('pending')
                    ->after('amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Only drop the column if it exists
        if (Schema::hasColumn('contributions', 'status')) {
            Schema::table('contributions', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
