@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Create New Event</h2>
                
                <form method="POST" action="{{ route('admin.events.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="title" :value="__('Event Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" 
                                type="text" 
                                name="title" 
                                required />
                        </div>

                        <div>
    <x-input-label for="status" :value="__('Event Status')" />
    <select id="status" name="status" class="block mt-1 w-full" required>
        <option value="upcoming">Upcoming</option>
        <option value="ongoing">Ongoing</option>
        <option value="completed">Completed</option>
    </select>
</div>

                        <div>
                            <x-input-label for="start_time" :value="__('Start Time')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" 
                                type="datetime-local" 
                                name="start_time" 
                                required />
                        </div>

                        <div>
                            <x-input-label for="end_time" :value="__('End Time')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" 
                                type="datetime-local" 
                                name="end_time" 
                                required />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" 
                                type="text" 
                                name="location" 
                                required />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-area id="description" name="description" class="block mt-1 w-full" rows="4" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            Create Event
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection