<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the 'user_id' column doesn't exist before adding it
        if (!Schema::hasColumn('contributions', 'user_id')) {
            Schema::table('contributions', function (Blueprint $table) {
                $table->foreignId('user_id') 
                ->nullable()         // Add user_id as a foreign key
                    ->constrained('users')           // References the 'users' table
                    ->cascadeOnDelete();             // Delete contributions if user is deleted
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Check if the 'user_id' column exists before dropping it
        if (Schema::hasColumn('contributions', 'user_id')) {
            Schema::table('contributions', function (Blueprint $table) {
                $table->dropForeign(['user_id']);   // Drop foreign key constraint
                $table->dropColumn('user_id');      // Drop the 'user_id' column
            });
        }
    }
};

