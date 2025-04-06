@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Resource Details</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.resources.edit', $resource) }}" 
                           class="btn-primary inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Resource
                        </a>
                        <a href="{{ route('admin.resources.index') }}" 
                           class="btn-secondary inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Resource Information</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Title</dt>
                                <dd class="mt-1 text-gray-900">{{ $resource->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1 text-gray-900 capitalize">{{ $resource->type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Upload Date</dt>
                                <dd class="mt-1 text-gray-900">{{ $resource->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Downloads</dt>
                                <dd class="mt-1 text-gray-900">{{ $resource->download_count ?? 0 }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">File Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">File Name</dt>
                                <dd class="mt-1 text-gray-900">{{ $resource->original_filename }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">File Type</dt>
                                <dd class="mt-1 text-gray-900 uppercase">{{ $resource->file_extension }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">File Size</dt>
                                <dd class="mt-1 text-gray-900">{{ $resource->file_size }} KB</dd>
                            </div>
                            <div>
                                <a href="{{ route('admin.resources.download', $resource) }}" 
                                   class="btn-primary inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download File
                                </a>
                            </div>
                        </dl>
                    </div>

                    @if($resource->description)
                    <div class="md:col-span-2 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Description</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $resource->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection