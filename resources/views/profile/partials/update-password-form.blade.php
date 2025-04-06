<section class="space-y-6">
    <header class="border-b border-gray-200 pb-4">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Update Password') }}
            </h2>
        </div>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">
                {{ __('Current Password') }}
            </label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    autocomplete="current-password"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                >
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700">
                {{ __('New Password') }}
            </label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input 
                    id="update_password_password" 
                    name="password" 
                    type="password" 
                    autocomplete="new-password"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                >
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    autocomplete="new-password"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                >
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-medium text-sm text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >
                    {{ __('Password updated successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>