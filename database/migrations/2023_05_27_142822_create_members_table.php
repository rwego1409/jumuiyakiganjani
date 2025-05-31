<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key referencing 'users' table
            $table->foreignId('jumuiya_id')->constrained();  // Foreign key referencing 'jumuiyas' table (ensure this table exists)
            $table->string('phone')->nullable();  // Member's phone number
            $table->string('address')->nullable();  // Member's address
            $table->date('birth_date')->nullable();  // Member's birth date
            $table->date('joined_date');  // Date when the member joined
            $table->enum('status', ['active', 'inactive'])->default('active');  // Member status (active or inactive)
            $table->timestamps();  // Created at and updated at timestamps
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};