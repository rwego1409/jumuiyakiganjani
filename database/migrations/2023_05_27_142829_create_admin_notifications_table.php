<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // In the migration file
Schema::create('admin_notifications', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('message');
    $table->json('recipients')->nullable(); // ['all', 'specific_users', 'roles']
    $table->json('user_ids')->nullable(); // if specific users are selected
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
