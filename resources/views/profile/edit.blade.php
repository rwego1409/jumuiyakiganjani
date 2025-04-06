<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Section -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Profile Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Update your account's profile information and email address.
                    </p>
                </div>
                <div class="px-6 py-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Update Password
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                </div>
                <div class="px-6 py-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Deletion Section -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-red-50">
                    <h3 class="text-lg font-medium text-red-800">
                        Delete Account
                    </h3>
                    <p class="mt-1 text-sm text-red-600">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                    </p>
                </div>
                <div class="px-6 py-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>