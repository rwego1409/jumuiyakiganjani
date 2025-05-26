<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_name', 'jumuiya_kiganjani');
        $this->migrator->add('general.app_url', env('APP_URL', 'http://localhost'));
        $this->migrator->add('general.support_email', 'support@example.com');
        
        // Migrate data from system_settings if it exists
        if (Schema::hasTable('system_settings')) {
            $systemSettings = DB::table('system_settings')->get();
            foreach ($systemSettings as $setting) {
                try {
                    $this->migrator->add("general.{$setting->key}", json_decode($setting->value));
                } catch (\Exception $e) {
                    $this->migrator->add("general.{$setting->key}", $setting->value);
                }
            }
        }
    }
};
