@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Resource Details</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.resources.edit', $resource) }}" class="btn-primary">
                            Edit Resource
                        </a>
                        <a href="{{ route('admin.resources.index') }}" class="btn-secondary">
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
                                <dd class="mt-1 text-gray-900">{{ $resource->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">File Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">File Name</dt>
                                <dd class="mt-1 text-gray-900">{{ basename($resource->file_path) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">File Size</dt>
                                <dd class="mt-1 text-gray-900">
                                    {{ round(filesize(storage_path('app/' . $resource->file_path)) / 1024) }} KB
                                </dd>
                            </div>
                            <div>
                                <a href="{{ asset('storage/' . $resource->file_path) }}" 
                                   class="btn-primary inline-block"
                                   download>
                                    Download File
                                </a>
                            </div>
                        </dl>
                    </div>

                    <div class="md:col-span-2 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Description</h3>
                        <p class="text-gray-700">{{ $resource->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection