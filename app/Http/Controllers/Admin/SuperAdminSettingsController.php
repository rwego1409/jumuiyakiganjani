<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemSettings;
use Illuminate\Support\Facades\DB;

class SuperAdminSettingsController extends Controller
{
    public function index()
    {
        $settingsArray = DB::table('system_settings')->pluck('value', 'key')->all();
        
        $settings = [
            'site_name' => $settingsArray['site_name'] ?? 'Jumuiya System',
            'site_description' => $settingsArray['site_description'] ?? 'Jumuiya Management System',
            'contact_email' => $settingsArray['contact_email'] ?? 'admin@jumuiya.com',
            'contact_phone' => $settingsArray['contact_phone'] ?? '+255700000000',
            'maintenance_mode' => $settingsArray['maintenance_mode'] ?? '0',
            'allow_registrations' => $settingsArray['allow_registrations'] ?? '1',
        ];

        return view('admin.super.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:1000'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'string', 'max:15'],
            'maintenance_mode' => ['boolean'],
            'allow_registrations' => ['boolean'],
        ]);

        foreach ($validated as $key => $value) {
            DB::table('system_settings')
                ->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value]
                );
        }

        return redirect()->route('super_admin.settings')
            ->with('success', 'Settings updated successfully');
    }
}
