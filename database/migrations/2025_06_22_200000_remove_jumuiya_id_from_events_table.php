<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['jumuiya_id']);
            $table->dropColumn('jumuiya_id');
        });
        // Move created_by after id if needed
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('id')->change();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('jumuiya_id')->constrained();
            $table->unsignedBigInteger('created_by')->nullable()->after('jumuiya_id')->change();
        });
    }
};
