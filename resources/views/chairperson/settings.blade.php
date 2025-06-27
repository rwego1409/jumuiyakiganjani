<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-pink-700 dark:text-pink-300 leading-tight md:text-4xl lg:text-5xl flex items-center gap-2">
            <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            {{ __('Settings') }}
        </h2>
    </x-slot>
    <div class="py-12 min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Section -->
            <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/50 dark:border-pink-900/50">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <!-- Password Section -->
            <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/50 dark:border-pink-900/50">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <!-- WhatsApp Notification Settings -->
            <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/50 dark:border-pink-900/50">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-semibold text-pink-700 dark:text-pink-300 flex items-center gap-2">
                            <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            {{ __('WhatsApp Notifications') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Manage your WhatsApp notification preferences. You can receive important updates about member activities, contributions, and events.') }}
                        </p>
                    </header>
                    <livewire:whatsapp-notification-settings />
                </div>
            </div>
            <!-- Notification Templates -->
            <div class="p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/50 dark:border-pink-900/50">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-semibold text-pink-700 dark:text-pink-300 flex items-center gap-2">
                            <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            {{ __('Notification Templates') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Customize message templates for different types of notifications sent to members.') }}
                        </p>
                    </header>
                    <div class="mt-6 space-y-6">
                        <!-- Payment Reminder Template -->
                        <div>
                            <x-input-label for="payment_reminder_template" :value="__('Payment Reminder Template')" />
                            <x-text-input id="payment_reminder_template" type="text" class="mt-1 block w-full"
                                :value="setting('whatsapp.templates.payment_reminder')"
                                placeholder="Default: {{__('Hello {name}, your payment of {amount} is due on {date}.')}}" />
                        </div>

                        <!-- Event Reminder Template -->
                        <div>
                            <x-input-label for="event_reminder_template" :value="__('Event Reminder Template')" />
                            <x-text-input id="event_reminder_template" type="text" class="mt-1 block w-full"
                                :value="setting('whatsapp.templates.event_reminder')"
                                placeholder="Default: {{__('Hello {name}, reminder: {event} is scheduled for {date} at {location}.')}}" />
                        </div>

                        <!-- Save Button -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Templates') }}</x-primary-button>
                            {{-- <x-action-message class="mr-3" on="templates-saved">{{ __('Saved.') }}</x-action-message> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>