<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jumuiya_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jumuiya_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('general'); // general, alert, reminder, update
            $table->string('recipient_type'); // all, specific
            $table->json('member_ids')->nullable();
            $table->string('action_url')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jumuiya_notifications');
    }
};
