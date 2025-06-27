<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <div class="max-w-xl">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('WhatsApp Notifications') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Manage your WhatsApp notification preferences.') }}
            </p>
        </header>

        <form wire:submit="updateSettings" class="mt-6 space-y-6">
            <div>
                <div class="flex items-center">
                    <input wire:model="whatsappEnabled" type="checkbox" id="whatsappEnabled"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                    <label for="whatsappEnabled" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Enable WhatsApp notifications') }}
                    </label>
                </div>
            </div>

            <div x-show="$wire.whatsappEnabled">
                <x-input-label for="phoneNumber" :value="__('Phone Number')" />
                <x-text-input wire:model="phoneNumber" id="phoneNumber" type="tel" class="mt-1 block w-full"
                    placeholder="+255123456789" />
                <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Enter your phone number in international format (e.g., +255123456789)') }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                {{-- <x-action-message class="mr-3" on="settings-updated">
                    {{ __('Saved.') }}
                </x-action-message> --}}
            </div>
        </form>
    </div>
</div>
