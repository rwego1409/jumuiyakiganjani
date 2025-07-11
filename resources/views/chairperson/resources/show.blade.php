@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('chairperson.resources.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-pink-600 to-purple-500 hover:from-pink-700 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                {{ __('Back to Resources') }}
            </a>
        </div>
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <!-- Resource Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">
                        {{ $resource->name }}
                    </h2>
                    <p class="mt-1 text-sm text-pink-500 dark:text-pink-300">
                        {{ __('Uploaded') }} {{ $resource->created_at->diffForHumans() }}
                    </p>
                </div>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                    @if($resource->status === 'active') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($resource->status) }}
                </span>
            </div>

            <!-- Resource Details -->
            <div class="space-y-6">
                <!-- Type -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Type') }}</h3>
                    <p class="mt-1 text-lg text-gray-900 dark:text-white">
                        {{ ucfirst($resource->type) }}
                    </p>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</h3>
                    <div class="mt-1 text-lg text-gray-900 dark:text-white prose dark:prose-invert max-w-none">
                        {{ $resource->description }}
                    </div>
                </div>

                <!-- File -->
                @if($resource->file_path)
                <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Attached File') }}</h3>
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

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('chairperson.resources.edit', $resource->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
                        <i class="fas fa-edit mr-2"></i>{{ __('Edit Resource') }}
                    </a>
                    <form action="{{ route('chairperson.resources.destroy', $resource->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
                                onclick="return confirm('{{ __('Are you sure you want to delete this resource?') }}')">
                            <i class="fas fa-trash mr-2"></i>{{ __('Delete Resource') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
