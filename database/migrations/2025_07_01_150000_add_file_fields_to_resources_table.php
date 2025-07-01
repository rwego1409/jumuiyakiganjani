<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->string('original_filename')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('file_extension', 10)->nullable();
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['original_filename', 'file_size', 'file_extension']);
        });
    }
};
