@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        {{ session('success') }}
                        @if(session('notification_id'))
                        <a href="{{ route('admin.notifications.show', session('notification_id')) }}" class="font-medium underline text-green-800 hover:text-green-600">
                            View Notification
                        </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Notification</h1>
        
        <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-6">
            @csrf

            <!-- Notification Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                    required autofocus placeholder="Enter notification title" value="{{ old('title') }}" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Notification Message -->
            <div>
                <x-input-label for="message" :value="__('Message')" />
                <textarea id="message" name="message" rows="5"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required placeholder="Enter detailed notification message">{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>

            <!-- Notification Type -->
            <div>
                <x-input-label for="type" :value="__('Notification Type')" />
                <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General Notification</option>
                    <option value="alert" {{ old('type') == 'alert' ? 'selected' : '' }}>Alert</option>
                    <option value="reminder" {{ old('type') == 'reminder' ? 'selected' : '' }}>Reminder</option>
                    <option value="update" {{ old('type') == 'update' ? 'selected' : '' }}>System Update</option>
                </select>
            </div>

            <!-- Recipients Selection -->
            <div>
                <x-input-label :value="__('Recipients')" />
                <div class="mt-2 space-y-2">
                    <div class="flex items-center">
                        <input id="all_users" name="recipient_type" type="radio" value="all" 
                            {{ old('recipient_type', 'all') == 'all' ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <label for="all_users" class="ml-2 block text-sm text-gray-700">All Active Users</label>
                    </div>
                    <div class="flex items-center">
                        <input id="specific_users" name="recipient_type" type="radio" value="specific"
                            {{ old('recipient_type') == 'specific' ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        <label for="specific_users" class="ml-2 block text-sm text-gray-700">Specific Users</label>
                    </div>
                </div>
            </div>

            <!-- Specific Users Selection (conditional) -->
            <div id="specificUsersContainer" class="{{ old('recipient_type') == 'specific' ? '' : 'hidden' }}">
                <x-input-label for="user_ids" :value="__('Select Users')" />
                <select name="user_ids[]" id="user_ids" multiple
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple users</p>
            </div>

            <!-- Action URL -->
            <div>
                <x-input-label for="action_url" :value="__('Action Link (optional)')" />
                <x-text-input id="action_url" name="action_url" type="url" class="mt-1 block w-full"
                    placeholder="https://example.com/action" value="{{ old('action_url') }}" />
                <p class="mt-1 text-sm text-gray-500">URL to direct users when they click the notification</p>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.notifications.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <x-primary-button type="submit">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                    </svg>
                    Send Notification
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle specific users dropdown
    const recipientTypeRadios = document.querySelectorAll('input[name="recipient_type"]');
    const specificUsersContainer = document.getElementById('specificUsersContainer');
    
    function toggleRecipientFields() {
        const selectedValue = document.querySelector('input[name="recipient_type"]:checked').value;
        specificUsersContainer.classList.toggle('hidden', selectedValue !== 'specific');
    }
    
    recipientTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleRecipientFields);
    });
    
    // Initial check
    toggleRecipientFields();
});
</script>
@endsection