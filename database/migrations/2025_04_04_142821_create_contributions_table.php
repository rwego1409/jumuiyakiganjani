<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('member_id')
                ->constrained('members')  // Changed to 'members' table for proper relation
                ->cascadeOnDelete();
            
            $table->foreignId('jumuiya_id')
                ->constrained()
                ->cascadeOnDelete();
            
            // Financial data
            $table->decimal('amount', 13, 2)  // Increased precision for large amounts
                ->comment('Contribution amount in TZS');
            
            // Status tracking
            $table->enum('status', ['pending', 'confirmed', 'rejected'])
                ->default('pending')
                ->comment('Contribution approval state');
            
            // Date information
            $table->date('contribution_date')
                ->useCurrent()
                ->comment('Actual date of contribution');
            
            // Payment details
            $table->enum('payment_method', ['cash', 'mobile', 'bank'])
                ->default('cash')
                ->comment('Payment method used');
            
            // Additional information
            $table->string('purpose', 255)
                ->nullable()
                ->comment('Contribution purpose');
            
            // Audit fields
            $table->foreignId('recorded_by')
                ->constrained('users')
                ->comment('Admin who recorded the contribution');
            
            // Financial tracking
            $table->string('receipt_number', 50)
                ->nullable()
                ->unique()
                ->comment('Official receipt reference');
            
            $table->timestamps();
            
            // Optimized compound indexes
            $table->index(['member_id', 'status']);
            $table->index(['jumuiya_id', 'contribution_date']);
            $table->index(['status', 'payment_method']);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        Schema::dropIfExists('contributions');
    }
};