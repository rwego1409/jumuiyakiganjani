<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('contributions')) {
            // Step 1: Add column if it doesn't exist
            if (!Schema::hasColumn('contributions', 'user_id')) {
                Schema::table('contributions', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('id');
                });
            }

            // Step 2: Disable foreign key checks temporarily
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Step 3: Find a valid user ID to assign
            $validUserId = DB::table('users')->value('id') ?? 1;

            // Step 4: Update all records with a valid user_id
            DB::table('contributions')->whereNull('user_id')->update(['user_id' => $validUserId]);

            // Step 5: Add the foreign key constraint
            Schema::table('contributions', function (Blueprint $table) use ($validUserId) {
                // Ensure no null values remain
                DB::table('contributions')->whereNull('user_id')->update(['user_id' => $validUserId]);
                
                // Change to not nullable and add foreign key
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            });

            // Step 6: Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    public function down()
    {
        if (Schema::hasTable('contributions')) {
            Schema::table('contributions', function (Blueprint $table) {
                // Drop foreign key first
                $table->dropForeign(['user_id']);
                // Then drop column
                $table->dropColumn('user_id');
            });
        }
    }
};