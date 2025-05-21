@extends('layouts.member')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Notification Details</h1>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $notification->created_at->format('M j, Y \a\t g:i A') }}
            </span>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-4">
            <!-- Title and Sender -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-1">
                    {{ $notification->data['title'] ?? 'No Title' }}
                </h2>
                @if(isset($notification->data['admin']))
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        From: <span class="font-medium">{{ $notification->data['admin']['name'] }}</span>
                    </p>
                @endif
            </div>

            <!-- Message -->
            <div class="prose dark:prose-invert max-w-none mb-6">
                <p class="whitespace-pre-line text-gray-700 dark:text-gray-200">
                    {{ $notification->data['message'] ?? 'No message content available.' }}
                </p>
            </div>

            <!-- Details Toggle -->
            <div x-data="{ showDetails: false }" class="mb-6">
                <button 
                    @click="showDetails = !showDetails"
                    class="flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition focus:outline-none"
                >
                    <span x-text="showDetails ? 'Hide Details' : 'Show Details'"></span>
                    <svg 
                        :class="{ 'transform rotate-180': showDetails }" 
                        class="ml-2 h-4 w-4 transition-transform" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Details Panel -->
                <div 
                    x-show="showDetails" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="mt-4 p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg"
                >
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Notification Details</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Notification ID</p>
                            <p class="text-sm font-mono text-gray-700 dark:text-gray-200">{{ $notification->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Type</p>
                            <p class="text-sm">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-100">
                                    {{ $notification->data['type'] ?? 'general' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                            <p class="text-sm">
                                @if($notification->read_at)
                                    <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Read
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-blue-600 dark:text-blue-400">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                        </svg>
                                        Unread
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if(isset($notification->data['metadata']))
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Additional Data</p>
                            <pre class="text-xs p-2 bg-white dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700 overflow-x-auto text-gray-800 dark:text-gray-100">
{{ json_encode($notification->data['metadata'], JSON_PRETTY_PRINT) }}
                            </pre>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Content -->
            @if(isset($adminNotification) && $adminNotification->related_content)
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-100 dark:border-blue-700 rounded-lg">
                    <h3 class="text-lg font-medium text-blue-800 dark:text-blue-100 mb-2">Related Information</h3>
                    <div class="prose dark:prose-invert prose-blue max-w-none">
                        {!! $adminNotification->related_content !!}
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                @if($notification->read_at)
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Read {{ $notification->read_at->diffForHumans() }}
                    </p>
                @endif
            </div>
            <div class="space-x-3">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-100 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back
                </a>
                @if(isset($notification->data['action_url']))
                    <a href="{{ $notification->data['action_url'] }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Take Action
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

