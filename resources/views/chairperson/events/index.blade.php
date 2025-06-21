@extends('layouts.chairperson')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Events Management') }}
        </h2>
        <a href="{{ route('chairperson.events.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md shadow transition duration-200">
            <i class="fas fa-plus mr-2"></i>{{ __('Add Event') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        @include('chairperson.events.includes.filter')

        @if($events->isEmpty())
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                {{ __('No events found') }}
            </div>
        @else
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="transition transform hover:scale-105 hover:shadow-xl bg-white dark:bg-gray-900 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700 group cursor-pointer">
                    <!-- Event Title & Status -->
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary-700 dark:group-hover:text-primary-300">{{ $event->title ?? $event->name }}</h3>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($event->status === 'upcoming') bg-blue-100 text-blue-800
                            @elseif($event->status === 'ongoing') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-2">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ $event->start_time->format('M d, Y H:i') }}
                        <span class="mx-2">|</span>
                        <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->location }}</span>
                    </div>
                    <div class="text-gray-700 dark:text-gray-300 text-sm mb-4 line-clamp-3">{{ Str::limit($event->description, 120) }}</div>
                    <div class="mt-4">
                        <a href="{{ route('chairperson.events.show', $event->id) }}"
                           class="inline-flex items-center w-full justify-center px-4 py-2 text-sm rounded-md bg-primary-600 hover:bg-primary-700 text-white dark:bg-primary-700 dark:hover:bg-primary-600 transition-colors">
                            {{ __('View Details') }}
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    @if($event->created_by === auth()->id())
                    <div class="absolute top-4 right-4 flex space-x-2 z-10">
                        <a href="{{ route('chairperson.events.edit', $event->id) }}"
                           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 dark:bg-yellow-900 dark:text-yellow-300 dark:hover:bg-yellow-800 dark:hover:text-yellow-100 transition-colors duration-200"
                           title="{{ __('Edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('chairperson.events.destroy', $event->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800 dark:hover:text-red-100 transition-colors duration-200"
                                    title="{{ __('Delete') }}"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this event?') }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
