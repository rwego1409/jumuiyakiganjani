<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->timestamp('reminder_date');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->enum('channel', ['whatsapp', 'sms', 'email'])->default('whatsapp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reminders');
    }
};