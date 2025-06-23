@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3 justify-between flex-wrap">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Create Event') }}</h2>
                </div>
                <a href="{{ route('chairperson.events.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-pink-100 to-purple-100 dark:from-pink-800 dark:to-purple-800 border border-pink-200 dark:border-purple-700 rounded-lg text-pink-700 dark:text-pink-100 font-semibold text-xs sm:text-sm shadow hover:from-pink-200 hover:to-purple-200 dark:hover:from-pink-700 dark:hover:to-purple-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Events') }}
                </a>
            </div>

            <form action="{{ route('chairperson.events.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Event Name') }}
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Start Date & Time') }}
                            </label>
                            <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('End Date & Time') }}
                            </label>
                            <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Location') }}
                        </label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Description') }}
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                         dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Status') }}
                        </label>
                        <select name="status" id="status"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="upcoming" {{ old('status') === 'upcoming' ? 'selected' : '' }}>{{ __('Upcoming') }}</option>
                            <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>{{ __('Ongoing') }}</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row justify-end gap-2 pt-2">
                        <a href="{{ route('chairperson.events.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-gray-200 to-purple-100 dark:from-gray-800 dark:to-purple-900 border border-gray-300 dark:border-purple-700 rounded-xl font-semibold text-xs sm:text-sm text-gray-700 dark:text-gray-100 uppercase tracking-widest shadow hover:from-gray-300 hover:to-purple-200 dark:hover:from-gray-700 dark:hover:to-purple-800 transition">
                            <i class="fas fa-arrow-left mr-2"></i> {{ __('Back') }}
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-pink-600 to-purple-500 border border-transparent rounded-xl font-semibold text-xs sm:text-sm text-white uppercase tracking-widest shadow hover:from-pink-700 hover:to-purple-600">
                            {{ __('Create Event') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
