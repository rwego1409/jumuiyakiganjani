@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Event Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $event->name }}</h1>
                        <div class="flex items-center mt-2 text-sm text-gray-600">
                            <i class="far fa-calendar-alt mr-2"></i>

                            <!-- Using Carbon::parse to ensure it's a Carbon instance -->
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('l, F j, Y \a\t g:i A') ?: 'Date not available' }}</span>

                            @if($event->end_time)
                                <span class="mx-1">to</span>
                                <span>{{ \Carbon\Carbon::parse($event->end_time)->format('l, F j, Y \a\t g:i A') }}</span>
                            @else
                                <span class="mx-1">to</span>
                                <span>Ongoing</span>
                            @endif
                        </div>

                        @if($event->location)
                        <div class="flex items-center mt-1 text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Event Status Badge -->
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                <!-- Event Description -->
                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($event->description)) !!}
                </div>

                <!-- Event Actions -->
                <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200">
                    @if($event->status === 'active')
                        <a href="{{ route('member.events.attend', $event) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-calendar-check mr-2"></i> Attend Event
                        </a>
                    @endif
                    
                    <a href="{{ route('member.events.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
