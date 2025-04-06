<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_type'); // For example, could represent the type of activity
            $table->text('description'); // A description of the activity
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to a user
            
            // Polymorphic fields
            $table->morphs('loggable'); // This will create loggable_id and loggable_type
    
            $table->timestamps();
        });
    }
    
 
    
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}

