<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('member_id')
                ->constrained('users')  // Explicit table name
                ->cascadeOnDelete();    // Delete contributions if member is deleted
            
            $table->foreignId('jumuiya_id')
                ->constrained()
                ->cascadeOnDelete();
            
            // Financial data
            $table->decimal('amount', 10, 2)
                ->comment('Contribution amount in local currency');
            
            // Date information
            $table->date('contribution_date')
                ->index()
                ->comment('Date when contribution was made');
            
            // Payment details
            $table->string('payment_method', 50)
                ->default('cash')
                ->comment('Payment method used: cash, mpesa, bank, etc.');
            
            // Additional information
            $table->text('purpose')
                ->nullable()
                ->comment('Optional purpose of the contribution');
            
            // Tracking
            $table->string('receipt_number')
                ->nullable()
                ->unique()
                ->comment('Official receipt number if available');
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['member_id', 'contribution_date']);
            $table->index(['jumuiya_id', 'contribution_date']);
        });

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        Schema::dropIfExists('contributions');
    }
};