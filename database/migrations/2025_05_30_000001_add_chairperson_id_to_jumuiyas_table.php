<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            if (!Schema::hasColumn('jumuiyas', 'chairperson_id')) {
                $table->foreignId('chairperson_id')->nullable()->constrained('users');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            if (Schema::hasColumn('jumuiyas', 'chairperson_id')) {
                $table->dropForeign(['chairperson_id']);
                $table->dropColumn('chairperson_id');
            }
        });
    }
};
