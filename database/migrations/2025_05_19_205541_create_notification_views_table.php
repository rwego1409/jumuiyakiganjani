<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Make sure this matches the data type of the notifications table
            $table->uuid('notification_id')->constrained(
                table: 'notifications',
                column: 'id',
                onDelete: 'cascade'
            );
            
            $table->timestamp('viewed_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'notification_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_views');
    }
};