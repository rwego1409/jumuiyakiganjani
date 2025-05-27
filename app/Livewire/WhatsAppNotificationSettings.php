<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WhatsAppNotificationSettings extends Component
{
    public $whatsappEnabled;
    public $phoneNumber;

    public function mount()
    {
        $user = Auth::user();
        $this->whatsappEnabled = $user->whatsapp_notifications_enabled;
        $this->phoneNumber = $user->phone;
    }

    public function updateSettings()
    {
        $this->validate([
            'phoneNumber' => 'required_if:whatsappEnabled,true|regex:/^\+?[1-9]\d{1,14}$/',
        ], [
            'phoneNumber.required_if' => 'Phone number is required to enable WhatsApp notifications.',
            'phoneNumber.regex' => 'Please enter a valid phone number.',
        ]);

        $user = Auth::user();
        $user->update([
            'whatsapp_notifications_enabled' => $this->whatsappEnabled,
            'phone' => $this->phoneNumber,
        ]);

        $this->dispatch('settings-updated');
    }

    public function render()
    {
        return view('livewire.whatsapp-notification-settings');
    }
}
