<?php

namespace App\Console\Commands;

use App\Models\Jumuiya;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetupJumuiyaCommand extends Command
{
    protected $signature = 'jumuiya:setup';
    protected $description = 'Setup initial Jumuiya Kiganjani application';

    public function handle()
    {
        $this->info('Setting up Jumuiya Kiganjani...');
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@jumuiya.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '255123456789',
        ]);

        $this->info('Admin user created:');
        $this->line('Email: admin@jumuiya.com');
        $this->line('Password: password');

        // Create sample jumuiya
        $jumuiya = Jumuiya::create([
            'name' => 'St. Peter',
            'location' => 'Dar es Salaam',
            'description' => 'Sample Jumuiya',
            'chairperson_id' => $admin->id,
        ]);

        $this->info('Sample Jumuiya created: ' . $jumuiya->name);

        $this->info('Setup completed successfully!');
    }
}