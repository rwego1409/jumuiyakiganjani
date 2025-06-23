@extends('layouts.admin')

@section('content')
<div class="py-4 sm:py-12">
    <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-4 sm:p-6">
                    <h1 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-gray-900 dark:text-gray-100">System Settings</h1>

                    {{-- General Settings --}}
                    <div class="mb-4 sm:mb-6">
                        <h2 class="text-lg font-semibold mb-2 sm:mb-4 text-gray-800 dark:text-gray-200">General</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">App Name</label>
                                <input type="text" name="app_name" value="{{ setting('app_name') }}" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300 text-xs sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">App URL</label>
                                <input type="url" name="app_url" value="{{ setting('app_url') }}" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300 text-xs sm:text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="mb-4 sm:mb-6">
                        <h2 class="text-lg font-semibold mb-2 sm:mb-4 text-gray-800 dark:text-gray-200">Contact & Support</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Support Email</label>
                                <input type="email" name="support_email" value="{{ setting('support_email') }}" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300 text-xs sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="text" name="phone" value="{{ setting('phone') }}" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300 text-xs sm:text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Appearance --}}
                    <div class="mb-4 sm:mb-6">
                        <h2 class="text-lg font-semibold mb-2 sm:mb-4 text-gray-800 dark:text-gray-200">Appearance</h2>
                        <div class="space-y-2 sm:space-y-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
                                <input type="file" name="app_logo" class="mt-1 block w-full text-xs sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Theme</label>
                                <select name="theme" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300 text-xs sm:text-sm">
                                    <option value="light" {{ setting('theme') === 'light' ? 'selected' : '' }}>Light</option>
                                    <option value="dark" {{ setting('theme') === 'dark' ? 'selected' : '' }}>Dark</option>
                                    <option value="system" {{ setting('theme') === 'system' ? 'selected' : '' }}>System Default</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Notifications --}}
                    <div class="mb-4 sm:mb-6">
                        <h2 class="text-lg font-semibold mb-2 sm:mb-4 text-gray-800 dark:text-gray-200">Notifications</h2>
                        <div class="space-y-2 sm:space-y-4">
                            <div class="flex items-center">
                                <input id="email_notifications" name="email_notifications" type="checkbox" class="text-indigo-600 border-gray-300 rounded" {{ setting('email_notifications') ? 'checked' : '' }}>
                                <label for="email_notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Enable Email Notifications
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="mt-4 sm:mt-6">
                        <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
