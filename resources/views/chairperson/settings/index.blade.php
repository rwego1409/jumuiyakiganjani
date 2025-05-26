@extends('layouts.chairperson')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Jumuiya Settings</h2>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('chairperson.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Notification Settings -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Notification Settings</h3>
                    
                    <div class="space-y-4">
                        <!-- Email Notifications -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="notifications[email_enabled]" id="email_enabled"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded"
                                    {{ $settings['notifications']['email_enabled'] ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="email_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable Email Notifications
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Receive notifications via email
                                </p>
                            </div>
                        </div>

                        <!-- WhatsApp Notifications -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="notifications[whatsapp_enabled]" id="whatsapp_enabled"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded"
                                    {{ $settings['notifications']['whatsapp_enabled'] ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="whatsapp_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable WhatsApp Notifications
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Send notifications to members via WhatsApp
                                </p>
                            </div>
                        </div>

                        <!-- SMS Notifications -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="notifications[sms_enabled]" id="sms_enabled"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded"
                                    {{ $settings['notifications']['sms_enabled'] ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="sms_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable SMS Notifications
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Send notifications to members via SMS
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contribution Reminder Settings -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Contribution Reminders</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="contribution_reminders[enabled]" id="contribution_reminders_enabled"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded"
                                    {{ $settings['contribution_reminders']['enabled'] ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="contribution_reminders_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable Contribution Reminders
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="reminder_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Days before due date to send reminder
                            </label>
                            <input type="number" name="contribution_reminders[reminder_days]" id="reminder_days"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                                       dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                min="1" max="30" value="{{ $settings['contribution_reminders']['reminder_days'] }}">
                            @error('contribution_reminders.reminder_days')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Meeting Reminder Settings -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Meeting Reminders</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="meeting_reminders[enabled]" id="meeting_reminders_enabled"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded"
                                    {{ $settings['meeting_reminders']['enabled'] ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="meeting_reminders_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable Meeting Reminders
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="reminder_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Hours before meeting to send reminder
                            </label>
                            <input type="number" name="meeting_reminders[reminder_hours]" id="reminder_hours"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                                       dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                min="1" max="168" value="{{ $settings['meeting_reminders']['reminder_hours'] }}">
                            @error('meeting_reminders.reminder_hours')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle contribution reminder days input based on enabled state
    const contributionRemindersEnabled = document.getElementById('contribution_reminders_enabled');
    const reminderDays = document.getElementById('reminder_days');

    contributionRemindersEnabled.addEventListener('change', function() {
        reminderDays.disabled = !this.checked;
    });
    reminderDays.disabled = !contributionRemindersEnabled.checked;

    // Toggle meeting reminder hours input based on enabled state
    const meetingRemindersEnabled = document.getElementById('meeting_reminders_enabled');
    const reminderHours = document.getElementById('reminder_hours');

    meetingRemindersEnabled.addEventListener('change', function() {
        reminderHours.disabled = !this.checked;
    });
    reminderHours.disabled = !meetingRemindersEnabled.checked;
});
</script>
@endpush
