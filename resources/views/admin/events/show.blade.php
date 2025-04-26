@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ $event->title }}</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary">Edit Event</a>
                        <a href="{{ route('admin.events.index') }}" class="btn-secondary">Back to Events</a>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium">Description</h3>
                            <p class="text-gray-600">{{ $event->description }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium">Date & Time</h3>
                            <p class="text-gray-600">{{ $event->start_time->format('F j, Y g:i A') }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium">Location</h3>
                            <p class="text-gray-600">{{ $event->location }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium">Attendees ({{ $event->attendees->count() }})</h3>
                            <div class="mt-2 space-y-2">
                                @foreach($event->attendees as $attendee)
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $attendee->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $attendee->email }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $attendee->pivot->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection