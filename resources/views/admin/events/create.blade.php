@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Create New Event</h2>

                @php
                    $startValue = old('start_time') ? \Carbon\Carbon::parse(old('start_time'))->format('Y-m-d') : '';
                    $endValue = old('end_time') ? \Carbon\Carbon::parse(old('end_time'))->format('Y-m-d') : '';
                @endphp

                <form method="POST" action="{{ route('admin.events.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event Title -->
                        <div>
                            <x-input-label for="title" :value="__('Event Title')" />
                            <x-text-input id="title" class="block mt-1 w-full"
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Event Status -->
                        <div>
                            <x-input-label for="status" :value="__('Event Status')" />
                            <select id="status" name="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select Status</option>
                                <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Start Date -->
                        <div>
                            <x-input-label for="start_time" :value="__('Start Date')" />
                            <x-text-input id="start_time" class="block mt-1 w-full"
                                type="date"
                                name="start_time"
                                value="{{ $startValue }}"
                                required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <!-- End Date -->
                        <div>
                            <x-input-label for="end_time" :value="__('End Date')" />
                            <x-text-input id="end_time" class="block mt-1 w-full"
                                type="date"
                                name="end_time"
                                value="{{ $endValue }}"
                                required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full"
                                type="text"
                                name="location"
                                value="{{ old('location') }}"
                                required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Jumuiya Selection -->
                        <div class="md:col-span-2">
                            <x-input-label for="jumuiya_ids" :value="__('Jumuiya(s)')" />
                            <select id="jumuiya_ids" name="jumuiya_ids[]" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" multiple required>
                                <option value="all" {{ (collect(old('jumuiya_ids'))->contains('all')) ? 'selected' : '' }}>All Jumuiyas</option>
                                @foreach($jumuiyas as $jumuiya)
                                    <option value="{{ $jumuiya->id }}" {{ (collect(old('jumuiya_ids'))->contains($jumuiya->id)) ? 'selected' : '' }}>
                                        {{ $jumuiya->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jumuiya_ids')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple. Select "All Jumuiyas" to target everyone.</p>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
