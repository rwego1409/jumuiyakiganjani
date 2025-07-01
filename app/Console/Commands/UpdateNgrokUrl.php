<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NgrokService;

class UpdateNgrokUrl extends Command
{
    protected $signature = 'ngrok:update';
    protected $description = 'Update ngrok URL in config';

    public function handle()
    {
        $url = NgrokService::getTunnelUrl();
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        if (preg_match('/NGROK_URL=.*/', $envContent)) {
            $envContent = preg_replace('/NGROK_URL=.*/', 'NGROK_URL=' . $url, $envContent);
        } else {
            $envContent .= "\nNGROK_URL=$url";
        }
        file_put_contents($envPath, $envContent);
        $this->info("Ngrok URL updated: " . $url);
    }
}
