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
                ->constrained('members')
                ->cascadeOnDelete();
            
            $table->foreignId('jumuiya_id')
                ->constrained()
                ->cascadeOnDelete();
            
            // Financial data
            $table->decimal('amount', 13, 2)
                ->comment('Contribution amount in TZS');
            
            // Payment status tracking
            $table->enum('status', ['pending', 'paid', 'failed', 'confirmed', 'rejected'])
                ->default('pending')
                ->comment('Payment processing state');
            
            // Contribution dates
            $table->date('contribution_date')
                ->useCurrent()
                ->comment('Intended contribution date');
            $table->timestamp('payment_date')
                ->nullable()
                ->comment('Actual payment completion timestamp');
            
            // Payment method details
            $table->enum('payment_method', ['cash', 'palm_pesa', 'bank_transfer', 'mobile_money'])
                ->default('palm_pesa')
                ->comment('Payment channel used');
            
            // Unique payment reference using UUID
            $table->uuid('payment_reference')
                ->unique()
                ->comment('Unique payment transaction ID');
            
            // Audit fields
            $table->foreignId('recorded_by')
                ->constrained('users')
                ->comment('User who recorded the contribution');
            
            // Optimized indexes
            $table->index(['member_id', 'status']);
            $table->index(['jumuiya_id', 'contribution_date']);
            $table->index(['payment_method', 'payment_date']);

            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        Schema::dropIfExists('contributions');
    }
};