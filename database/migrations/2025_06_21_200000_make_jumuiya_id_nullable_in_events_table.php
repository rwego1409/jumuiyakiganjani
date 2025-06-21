<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['jumuiya_id']);
            $table->foreignId('jumuiya_id')->nullable()->change();
            $table->foreign('jumuiya_id')->references('id')->on('jumuiyas')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['jumuiya_id']);
            $table->foreignId('jumuiya_id')->nullable(false)->change();
            $table->foreign('jumuiya_id')->references('id')->on('jumuiyas')->cascadeOnDelete();
        });
    }
};
