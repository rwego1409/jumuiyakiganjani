@extends('layouts.member')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-8">
            <svg class="h-8 w-8 text-primary-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-900">Events</h2>
        </div>
        <p class="mb-6 text-gray-600">Here are the events you can participate in.</p>
        @if ($events->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
                No events at this time
            </div>
        @else
            <div class="space-y-4">
                @foreach ($events as $event)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $event->name }}</h3>

                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($event->start_time)->format('l, F j, Y') }}</span>

                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                @if($event->status === 'upcoming') 
                                    bg-blue-100 text-blue-800 
                                @elseif($event->status === 'ongoing') 
                                    bg-yellow-100 text-yellow-800 
                                @elseif($event->status === 'completed') 
                                    bg-green-100 text-green-800 
                                @else
                                    bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                            <a href="{{ route('member.events.show', $event->id) }}" 
                               class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
