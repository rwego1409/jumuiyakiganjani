@extends('layouts.chairperson')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('chairperson.resources.index') }}" class="text-primary-500 hover:text-primary-700">
            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Resources') }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('Create New Resource') }}
            </h2>

            <form action="{{ route('chairperson.resources.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Resource Name') }}
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Type') }}
                        </label>
                        <select name="type" id="type"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="document" {{ old('type') === 'document' ? 'selected' : '' }}>{{ __('Document') }}</option>
                            <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                            <option value="audio" {{ old('type') === 'audio' ? 'selected' : '' }}>{{ __('Audio') }}</option>
                            <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                            <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                        </select>
                        @error('type')
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

                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('File') }}
                        </label>
                        <input type="file" name="file" id="file"
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary-50 file:text-primary-700
                                      hover:file:bg-primary-100
                                      dark:file:bg-gray-700 dark:file:text-gray-300">
                        @error('file')
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
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                            {{ __('Create Resource') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
