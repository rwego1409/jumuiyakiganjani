@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M9 17H7a4 4 0 01-4-4V7a4 4 0 014-4h10a4 4 0 014 4v6a4 4 0 01-4 4h-2M9 17v2a4 4 0 004 4h2a4 4 0 004-4v-2"/></svg>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Edit Resource') }}</h2>
            </div>

            <form action="{{ route('chairperson.resources.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Resource Name') }}
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $resource->name) }}" 
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
                            <option value="document" {{ old('type', $resource->type) === 'document' ? 'selected' : '' }}>{{ __('Document') }}</option>
                            <option value="video" {{ old('type', $resource->type) === 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                            <option value="audio" {{ old('type', $resource->type) === 'audio' ? 'selected' : '' }}>{{ __('Audio') }}</option>
                            <option value="image" {{ old('type', $resource->type) === 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                            <option value="other" {{ old('type', $resource->type) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
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
                                         dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">{{ old('description', $resource->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current File -->
                    @if($resource->file_path)
                    <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Current File') }}</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-file mr-2 text-gray-400"></i>
                                <span class="text-gray-900 dark:text-white">{{ basename($resource->file_path) }}</span>
                            </div>
                            <a href="{{ route('chairperson.resources.download', $resource->id) }}" 
                               class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-md text-sm">
                                <i class="fas fa-download mr-1"></i>{{ __('Download') }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- New File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('New File (Optional)') }}
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
                            <option value="active" {{ old('status', $resource->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status', $resource->status) === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit & Cancel Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('chairperson.resources.show', $resource->id) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" 
                                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                            {{ __('Update Resource') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
