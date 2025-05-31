@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('WhatsApp Reminders') }}
        </h2>
        <a href="{{ route('superuser.whatsapp_reminders.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
            <i class="fas fa-plus mr-2"></i>{{ __('Create Reminder') }}
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Title') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Message') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Scheduled At') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($reminders as $reminder)
                <tr>
                    <td class="px-6 py-4">{{ $reminder->title }}</td>
                    <td class="px-6 py-4">{{ Str::limit($reminder->message, 60) }}</td>
                    <td class="px-6 py-4">{{ $reminder->scheduled_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('superuser.whatsapp_reminders.edit', $reminder) }}" class="text-primary-600 hover:text-primary-800 mr-2">{{ __('Edit') }}</a>
                        <form action="{{ route('superuser.whatsapp_reminders.destroy', $reminder) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">{{ __('No reminders found.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
