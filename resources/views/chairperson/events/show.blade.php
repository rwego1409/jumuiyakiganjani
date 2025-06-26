@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Event Details') }}</h2>
            </div>

            <div class="space-y-6">
                <!-- Event Header -->
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $event->name }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Created') }} {{ $event->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                        @if($event->status === 'upcoming') bg-blue-100 text-blue-800
                        @elseif($event->status === 'ongoing') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Start Date & Time') }}</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">
                            {{ $event->start_time->format('M d, Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('End Date & Time') }}</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">
                            {{ $event->end_time->format('M d, Y H:i') }}
                        </p>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Location') }}</h3>
                    <p class="mt-1 text-lg text-gray-900 dark:text-white">
                        {{ $event->location }}
                    </p>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</h3>
                    <div class="mt-1 text-lg text-gray-900 dark:text-white prose dark:prose-invert max-w-none">
                        {{ $event->description }}
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700 gap-3">
                    <a href="{{ route('chairperson.events.index') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100 px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Events') }}
                    </a>
                    <div class="flex space-x-3">
                        <a href="{{ route('chairperson.events.edit', $event->id) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-edit mr-2"></i>{{ __('Edit Event') }}
                        </a>
                        <form action="{{ route('chairperson.events.destroy', $event->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this event?') }}')">
                                <i class="fas fa-trash mr-2"></i>{{ __('Delete Event') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
