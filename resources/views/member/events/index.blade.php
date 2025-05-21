@extends('layouts.member')

@section('content')
<div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center mb-8 gap-3">
            <svg class="h-8 w-8 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Events</h2>
        </div>

        <!-- Events Container -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($events as $event)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <!-- Event Header -->
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $event->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $event->location }}</p>
                    </div>
                    <span class="px-2.5 py-0.5 text-xs rounded-full {{ 
                        $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' :
                        ($event->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' :
                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100') 
                    }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                <!-- Event Details -->
                <div class="space-y-2">
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $event->start_time->format('M j, Y H:i') }}
                    </div>

                    @if($event->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                        {{ $event->description }}
                    </p>
                    @endif
                </div>

                <!-- Action Button -->
                <div class="mt-4">
                    <a href="{{ route('member.events.show', $event->id) }}" 
                       class="inline-flex items-center w-full justify-center px-4 py-2 text-sm rounded-md bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                        View Details
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($events->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center border border-gray-200 dark:border-gray-700">
            <p class="text-gray-600 dark:text-gray-400">No events found</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* Custom dark mode transitions */
.dark .event-card {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}
</style>
@endpush