@extends('layouts.chairperson')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('chairperson.events.index') }}" class="text-primary-500 hover:text-primary-700">
            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Events') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Event Header -->
            <div class="flex justify-between items-start mb-6">
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

            <!-- Event Details -->
            <div class="space-y-6">
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
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
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
@endsection
