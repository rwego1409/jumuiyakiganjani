<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemSettingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('system_settings')->insert([
            ['key' => 'site_name', 'value' => 'Jumuiya System'],
            ['key' => 'site_description', 'value' => 'Jumuiya Management System'],
            ['key' => 'contact_email', 'value' => 'admin@jumuiya.com'],
            ['key' => 'contact_phone', 'value' => '+255700000000'],
            ['key' => 'maintenance_mode', 'value' => '0'],
            ['key' => 'allow_registrations', 'value' => '1'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
