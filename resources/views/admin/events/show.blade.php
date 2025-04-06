@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Event Details</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary">
                            Edit Event
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="btn-secondary">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Event Information</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Title</dt>
                                <dd class="mt-1 text-gray-900">{{ $event->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 
                                           ($event->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Schedule</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Start Time</dt>
                                <dd class="mt-1 text-gray-900">{{ $event->start_time->format('M d, Y h:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">End Time</dt>
                                <dd class="mt-1 text-gray-900">{{ $event->end_time->format('M d, Y h:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="mt-1 text-gray-900">{{ $event->location }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="md:col-span-2 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Description</h3>
                        <p class="text-gray-700">{{ $event->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection