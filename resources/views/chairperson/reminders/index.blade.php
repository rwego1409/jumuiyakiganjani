@extends('layouts.chairperson')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">WhatsApp Reminders</h2>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <form action="{{ route('chairperson.reminders.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reminder_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reminder Type</label>
                <select name="reminder_type" id="reminder_type" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="payment">Payment</option>
                    <option value="event">Event</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                <textarea name="message" id="message" rows="3" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Type your WhatsApp reminder message here..."></textarea>
            </div>
            <div class="mb-4">
                <label for="send_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Send At</label>
                <input type="datetime-local" name="send_at" id="send_at" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recipients</label>
                <div class="flex items-center mb-2">
                    <input type="radio" name="recipient_type" value="all" id="all" checked class="mr-2">
                    <label for="all">All Members</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="recipient_type" value="specific" id="specific" class="mr-2">
                    <label for="specific">Select Members</label>
                </div>
                <!-- TODO: Add member selection UI if 'specific' is chosen -->
            </div>
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Send Reminder</button>
        </form>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Scheduled Reminders</h3>
        <!-- TODO: List scheduled reminders here -->
        <p class="text-gray-500 dark:text-gray-400">No scheduled reminders yet.</p>
    </div>
</div>
@endsection
