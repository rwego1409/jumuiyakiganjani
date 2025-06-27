<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            if (!Schema::hasColumn('jumuiyas', 'status')) {
                $table->string('status')->default('pending')->after('chairperson_id');
            } else {
                $table->string('status')->default('pending')->change();
            }
            $table->foreignId('chairperson_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('jumuiyas', function (Blueprint $table) {
            if (Schema::hasColumn('jumuiyas', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
