<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldsToJumuiyasTable extends Migration
{
    public function up()
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            $table->string('subscription_type')->nullable();
            $table->date('subscription_start')->nullable();
            $table->date('subscription_end')->nullable();
        });
    }

    public function down()
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            $table->dropColumn(['subscription_type', 'subscription_start', 'subscription_end']);
        });
    }
}
