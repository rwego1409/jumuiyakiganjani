<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use App\Imports\ContributionsImport;
use Illuminate\Support\Facades\Log;

class TestImports extends Command
{
    protected $signature = 'test:imports';
    protected $description = 'Test members and contributions imports';

    public function handle()
    {
        $this->info('Testing imports...');

        try {
            // Test members import
            $this->info('Testing members import...');
            Excel::import(new MembersImport, public_path('test_members.csv'));
            $this->info('Members import successful!');

            // Test contributions import
            $this->info('Testing contributions import...');
            Excel::import(new ContributionsImport, public_path('test_contributions.csv'));
            $this->info('Contributions import successful!');

        } catch (\Exception $e) {
            $this->error('Import failed: ' . $e->getMessage());
            Log::error('Import test failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
