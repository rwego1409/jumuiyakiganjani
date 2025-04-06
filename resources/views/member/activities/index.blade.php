{{-- resources/views/member/activities/index.blade.php --}}
@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold">Your Activities</h2>
        <div class="mt-4">
            @if ($activities->isEmpty())
                <p>No activities to display.</p>
            @else
                <ul>
                    @foreach ($activities as $activity)
                        <li class="bg-white shadow-sm p-4 mb-4 rounded">
                            <p><strong>Description:</strong> {{ $activity->description }}</p>
                            <p><strong>Type:</strong> {{ $activity->activity_type }}</p>
                            <p><strong>Created At:</strong> {{ $activity->created_at->format('d M, Y') }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
{{-- resources/views/member/activities/index.blade.php --}}
@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Your Activities</h2>
            <span class="text-sm text-gray-500">
                {{ $activities->count() }} {{ Str::plural('activity', $activities->count()) }}
            </span>
        </div>

        @if ($activities->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-700">No activities yet</h3>
                <p class="mt-1 text-gray-500">Your activities will appear here when available</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($activities as $activity)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-150 hover:shadow-md">
                        <div class="p-4 sm:p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    @switch($activity->activity_type)
                                        @case('contribution')
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                            @break
                                        @case('meeting')
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 text-gray-600">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            </span>
                                    @endswitch
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $activity->description }}
                                    </p>
                                    <div class="flex items-center mt-1 text-xs text-gray-500">
                                        <span class="capitalize">{{ $activity->activity_type }}</span>
                                        <span class="mx-1">•</span>
                                        <time datetime="{{ $activity->created_at->toIso8601String() }}">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>
                                <div class="ml-2 text-xs text-gray-400">
                                    {{ $activity->created_at->format('M d') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection