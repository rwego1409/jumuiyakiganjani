<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- WhatsApp Notification Settings -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
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
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
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
                            <x-input-error :messages="$errors->get('payment_reminder_template')" class="mt-2" />
                        </div>

                        <!-- Event Reminder Template -->
                        <div>
                            <x-input-label for="event_reminder_template" :value="__('Event Reminder Template')" />
                            <x-text-input id="event_reminder_template" type="text" class="mt-1 block w-full"
                                :value="setting('whatsapp.templates.event_reminder')"
                                placeholder="Default: {{__('Hello {name}, reminder: {event} is scheduled for {date} at {location}.')}}" />
                            <x-input-error :messages="$errors->get('event_reminder_template')" class="mt-2" />
                        </div>

                        <!-- Save Button -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save Templates') }}</x-primary-button>
                            <x-action-message class="mr-3" on="templates-saved">
                                {{ __('Saved.') }}
                            </x-action-message>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>