<?php

// database/migrations/2025_04_26_XXXXXX_create_general_settings.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_name', 'jumuiya_kiganjani');
        $this->migrator->add('general.app_url', 'http://localhost:8000');
        $this->migrator->add('general.support_email', 'support@example.com');
    }
}

