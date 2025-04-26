<?php

namespace App\Settings;

// app/Settings/GeneralSettings.php
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $app_name;
    public string $app_url;
    public string $support_email;

    public static function group(): string
    {
        return 'general';
    }

    public static function defaults(): array
    {
        return [
            'app_name' => 'jumuiya_kiganjani',
            'app_url' => env('APP_URL', 'http://localhost'),
            'support_email' => 'support@example.com',
        ];
    }
}