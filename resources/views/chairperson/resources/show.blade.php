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
            <!-- Resource Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $resource->name }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
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
            </div>
        </div>
    </div>
</div>
@endsection
