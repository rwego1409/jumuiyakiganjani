@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center mb-8">
                    <svg class="h-8 w-8 text-primary-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-900">Edit Resource</h2>
                </div>

                <form method="POST" action="{{ route('admin.resources.update', $resource) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Title Field -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" 
                                type="text" 
                                name="title" 
                                :value="old('title', $resource->title)" 
                                required />
                        </div>

                        <!-- Description Field (Fixed) -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea 
                                id="description"
                                name="description"
                                rows="4"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                            >{{ old('description', $resource->description ?? '') }}</textarea>
                        </div>

                        <!-- Type Field -->
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <x-select-input id="type" name="type" class="block mt-1 w-full" 
                                :options="[
                                    'document' => 'Document',
                                    'pdf' => 'PDF',
                                    'image' => 'Image',
                                    'video' => 'Video',
                                    'audio' => 'Audio'
                                ]" 
                                :selected="old('type', $resource->type)" 
                                required />
                        </div>

                        <!-- File Upload Field -->
                        <div>
                            <x-input-label for="file" :value="__('File (Leave empty to keep current file)')" />
                            <div class="mt-1 flex items-center">
                                <input type="file" name="file" id="file"
                                    class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-gray-100 file:text-gray-700
                                        hover:file:bg-gray-200">
                            </div>
                            @if($resource->file_path)
                            <p class="mt-2 text-sm text-gray-600">
                                Current file: 
                                <a href="{{ asset('storage/' . $resource->file_path) }}" 
                                   class="text-primary-600 hover:underline" 
                                   download>
                                    {{ basename($resource->file_path) }}
                                </a>
                                ({{ round($resource->file_size / 1024) }} KB)
                            </p>
                            @endif
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.resources.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Update Resource
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection