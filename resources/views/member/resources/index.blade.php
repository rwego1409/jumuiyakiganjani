{{-- resources/views/member/resources/index.blade.php --}}
@extends('layouts.member')

@section('header')
    Community Resources
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Community Resources</h2>
                <p class="mt-1 text-sm text-gray-600">Access helpful documents and files for your Jumuiya</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option>All Types</option>
                        <option>Document</option>
                        <option>PDF</option>
                        <option>Image</option>
                        <option>Video</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @if ($resources->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No resources available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for community resources.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($resources as $resource)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $resource->title }}</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($resource->type === 'document') bg-blue-100 text-blue-800
                                @elseif($resource->type === 'pdf') bg-red-100 text-red-800
                                @elseif($resource->type === 'image') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($resource->type) }}
                            </span>
                        </div>
                        
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $resource->created_at->format('M j, Y') }}
                        </div>
                        
                        <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                            {{ $resource->description }}
                        </p>
                        
                        <div class="mt-6 flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                {{ round($resource->file_size / 1024) }} KB
                            </span>
                            <a href="{{ asset('storage/' . $resource->file_path) }}" 
                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               download>
                                <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($resources->hasPages())
            <div class="mt-6">
                {{ $resources->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection