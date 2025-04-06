@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Edit Event</h2>
                
                <form method="POST" action="{{ route('admin.events.update', $event) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event Title -->
                        <div>
                            <x-input-label for="title" :value="__('Event Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" 
                                type="text" 
                                name="title" 
                                value="{{ old('title', $event->title) }}" 
                                required />
                        </div>

                        <!-- Event Status -->
                        <div>
                            <x-input-label for="status" :value="__('Event Status')" />
                            <x-select-input id="status" name="status" class="block mt-1 w-full" required>
                                <option value="upcoming" {{ $event->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ $event->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </x-select-input>
                        </div>

                        <!-- Start Time -->
                        <div>
                            <x-input-label for="start_time" :value="__('Start Time')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" 
                                type="datetime-local" 
                                name="start_time" 
                                value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}" 
                                required />
                        </div>

                        <!-- End Time -->
                        <div>
                            <x-input-label for="end_time" :value="__('End Time')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" 
                                type="datetime-local" 
                                name="end_time" 
                                value="{{ old('end_time', $event->end_time->format('Y-m-d\TH:i')) }}" 
                                required />
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" 
                                type="text" 
                                name="location" 
                                value="{{ old('location', $event->location) }}" 
                                required />
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-area id="description" name="description" class="block mt-1 w-full" rows="4">{{ old('description', $event->description) }}</x-text-area>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Update Event
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
